#!/bin/sh
#
# The Fascinator - Installer script
# Copyright (C) 2008  University of Southern Queensland
# 
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
# 
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# 
# You should have received a copy of the GNU General Public License along
# with this program; if not, write to the Free Software Foundation, Inc.,
# 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
#

echo "The Fascinator Installation"

# Check for root privileges
if [ `id -u` != "0" ]; then
	echo "ERROR: The installer must be run with root privileges!"
	exit 1
fi

# Get the operating system
UNAME=`uname`
if [ "$UNAME" = "Linux" ] ; then
	if [ -f /etc/lsb-release ] ; then
		OSNAME="ubuntu"
	# 20080926 (pc) For Debian
        elif [ -f /etc/debian_version ] ; then
                OSNAME="debian" 
	elif [ -f /etc/redhat-release ] ; then
		grep "CentOS" /etc/redhat-release
		if [ $? = 0 ] ; then
			OSNAME="centos"
		else
			OSNAME="redhat"
		fi
	else
		echo "ERROR: Unsupported Linux distribution"
		exit 1
	fi
elif [ "$UNAME" = "Darwin" ] ; then
	OSNAME="macosx"
else
	echo "ERROR: Unsupported operating system '$UNAME'"
	exit 1
fi

# Get user who invoked the script
if [ "$OSNAME" = "centos" ] 
then
	REAL_USER=$USER
else
	#REAL_USER=$SUDO_USER
	# 20080926 (pc) I don't use sudo, this will just find the user to be 'root' 
	# need something better here, prompt for username? auto create one on the fly?
	REAL_USER=`id | cut -d'(' -f3 | cut -d')' -f1`
fi
echo "Installing The Fascinator as user '$REAL_USER'"

# Utility commands
MKDIR="mkdir -p"
SED="sed -i .backup"
CHOWN="chown -R $REAL_USER"

# Check for curl or wget
which curl > /dev/null
if [ $? = 1 ]; then
	which wget > /dev/null
	if [ $? = 1 ]; then
		echo "ERROR: Failed to find curl or wget!"
		exit 1
	else
		GET="wget -O"
		GET_QUIET="wget -q -O"
		GET_STDOUT="wget -q -O -"
	fi
else
	GET="curl -L -o"
	GET_QUIET="curl -L -s -o"
	GET_STDOUT="curl -L -s"
fi

# Get installation directory
cd `dirname $0`
INSTALL_HOME=`pwd`
cd -
echo "Installing from directory '$INSTALL_HOME'"
echo

# Software download locations
FEDORA_URL=http://downloads.sourceforge.net/fedora-commons/fedora-3.0-installer.jar
SOLR_URL=http://www.apache.org/dist/lucene/solr/1.2/apache-solr-1.2.0.tgz
FASCINATOR_URL=http://ice.usq.edu.au/projects/fascinator/svn/dist/the-fascinator.zip
INSTALLER_URL=http://ice.usq.edu.au/projects/fascinator/svn/dist/installer

# Default destination directories
read -p "Enter the base directory to install to [default is /opt]: " BASE_DIR
if [ "$BASE_DIR" = "" ]; then
	BASE_DIR=/opt
fi
BASE_DIR=`echo $BASE_DIR | sed "s/\/*$//"`
FASCINATOR_HOME=$BASE_DIR/the-fascinator
FEDORA_HOME=$BASE_DIR/fedora
CATALINA_HOME=$FEDORA_HOME/tomcat
SOLR_HOME=$BASE_DIR/solr
PORTAL_CONFIG_HOME=$BASE_DIR/portal-config
CATALINA_OPTS="-Dsolr.solr.home=$SOLR_HOME"
echo
echo "Installation directories"
echo "    The Fascinator : $FASCINATOR_HOME"
echo "    Fedora Commons : $FEDORA_HOME"
echo "    Apache Tomcat  : $CATALINA_HOME"
echo "    Apache Solr    : $SOLR_HOME"
echo "    Portal config  : $PORTAL_CONFIG_HOME"
echo

# Get user passwords
FEDORA_PASSWORD=""
while [ "$FEDORA_PASSWORD" = "" ]; do
	#read -s -p "Enter the Fedora administrator (fedoraAdmin) password: " FEDORA_PASSWORD
	# 20080926 (pc) this failed for me, works as -sp. Debian specific? Need to test in Red Hat/etc
	read -sp "Enter the Fedora administrator (fedoraAdmin) password: " FEDORA_PASSWORD
	echo
	if [ "$FEDORA_PASSWORD" = "" ]; then
		echo "Must specify a value"
	fi
done

SOLR_PASSWORD=""
while [ "$SOLR_PASSWORD" = "" ]; do
	read -sp "Enter the Solr administrator (solrAdmin) password: " SOLR_PASSWORD
	echo
	if [ "$SOLR_PASSWORD" = "" ]; then
		echo "Must specify a value"
	fi
done

# Get proxy if required
if [ "$http_proxy" ]; then
	echo "Proxy is currently set to '$http_proxy'"
	read -p "Enter a proxy server (enter 'none' to disable proxy): " USER_PROXY 
	if [ "$USER_PROXY" = "none" ]; then
		unset http_proxy
	fi
else
	read -p "Enter a proxy server in this format, http://proxy:port (eg http://proxy.edu.au:8080), leave blank for no proxy: " USER_PROXY
fi
if [ "$USER_PROXY" != "" ]; then
	export http_proxy="$USER_PROXY"
fi

# Create temp directory for downloads
TMPDIR=$INSTALL_HOME/tmp
if [ ! -d  $TMPDIR ]; then
	$MKDIR $TMPDIR
	$CHOWN $TMPDIR
fi

#Extract the proxy host and port using expansion
TMP=${USER_PROXY##*/}
HOST=${TMP%%:*}
PORT=${USER_PROXY##*:}


# Create environment script
ENV_SH=$INSTALL_HOME/setenv.sh
echo "#!/bin/sh" > $ENV_SH
echo "export FASCINATOR_HOME=$FASCINATOR_HOME" >> $ENV_SH
echo "export FEDORA_HOME=$FEDORA_HOME" >> $ENV_SH
echo "export CATALINA_HOME=$CATALINA_HOME" >> $ENV_SH
echo "export SOLR_HOME=$SOLR_HOME" >> $ENV_SH
echo "export PORTAL_CONFIG_HOME=$PORTAL_CONFIG_HOME" >> $ENV_SH
echo "export CATALINA_OPTS=$CATALINA_OPTS" >> $ENV_SH
echo "export JAVA_OPTS=\"-Xmx512m -Dhttp.proxyHost=$HOST -Dhttp.proxyPort=$PORT -Dhttp.nonProxyHosts=localhost\"" >> $ENV_SH
$CHOWN $ENV_SH
chmod u+x $ENV_SH

# Get uninstall script
UNINSTALL_SH=$INSTALL_HOME/uninstall.sh
$GET_QUIET $UNINSTALL_SH $INSTALLER_URL/uninstall.sh
$CHOWN $UNINSTALL_SH
chmod u+x $UNINSTALL_SH

# Install Java 5 using OS specific package manager
InstallJava() {
	echo "Installing Java 5..."
	if [ "$OSNAME" = "ubuntu" ] ; then
		JAVA_HOME="/usr/lib/jvm/java-1.5.0-sun"
		apt-get -y install sun-java5-jdk
	# 20080926 (pc) added Debian block, I have 1.6 installed
	elif [ "$OSNAME" = "debian" ] ; then
		JAVA_HOME="/usr/lib/jvm/java-6-sun-1.6.0.07"
		apt-get -y install sun-java6-jdk
	elif [ "$OSNAME" = "redhat" ] ; then
		JAVA_HOME="/usr/lib/java"
		#up2date java
		echo "up2date java???"
		exit 1
	elif [ "$OSNAME" = "centos" ] ; then
		JAVA_HOME="/usr/lib/java"
		#yum install java
		echo "yum install java???"
		exit 1
	elif [ "$OSNAME" = "macosx" ] ; then
		JAVA_HOME="/Library/Java/Home"
	fi
	if [ $? = 0 ] ; then
		echo "export JAVA_HOME=$JAVA_HOME" >> $ENV_SH
		. $ENV_SH
		JAVA=$JAVA_HOME/bin/java
	else
		echo "ERROR: Failed to install Java!"
		exit 1
	fi
}

# Install Fedora Commons 3.0
InstallFedora() {
	# Download the Fedora Commons installer
	#TODO Checksum before downloading to verify
	FC3_JAR=$TMPDIR/fedora-3.0-installer.jar
	if [ -f $FC3_JAR ]; then
		echo "Fedora Commons installer has already been downloaded"
	else
		echo "Downlading Fedora Commons installer..."
		$GET $FC3_JAR $FEDORA_URL
		if [ ! -f $FC3_JAR ]; then
			echo "ERROR: Failed to download Fedora Installer!"
			exit 1
		fi
		$CHOWN $FC3_JAR
	fi

	# Update properties with user specified values
	echo "Installing Fedora Commons to '$FEDORA_HOME'..."
	INSTALL_PROPS=$INSTALL_HOME/install.properties
	$GET_STDOUT $INSTALLER_URL/install.properties.tmpl |\
		sed "s!\(fedora\.admin\.pass=\).*!\1$FEDORA_PASSWORD!" |\
		sed "s!\(database\.jdbcURL=.*//\)/.*\(/mckoi1\.0\.3.*\)!\1$FEDORA_HOME\2!" |\
		sed "s!\(tomcat\.home=\).*!\1$CATALINA_HOME!" |\
		sed "s!\(fedora\.home=\).*!\1$FEDORA_HOME!" > $INSTALL_HOME/install.properties
	$JAVA -jar $FC3_JAR $INSTALL_PROPS
	rm $INSTALL_PROPS
	if [ $? = 0 ]; then
		echo "Configuring Fedora Commons namespaces..."
		cd $FEDORA_HOME/server/config
		mv fedora.fcfg fedora.fcfg.backup
		cat fedora.fcfg.backup |\
			sed "s!\(<param name=\"pidNamespace\" value=\"\).*\(\">\)!\1uuid\2!" |\
			sed "s!\(<param name=\"retainPIDs\" value=\"\).*\(\">\)!\1uuid sof\2!" > fedora.fcfg
		cd -
		$CHOWN $FEDORA_HOME
	else
		echo "ERROR: Failed to install Fedora Commons!"
		exit 1
	fi
}

InstallSolr() {
	# Download the Solr distribution
	#TODO Checksum before downloading to verify
	SOLR_TGZ=$TMPDIR/apache-solr-1.2.0.tgz
	if [ -f $SOLR_TGZ ]; then
		echo "Solr has already been downloaded"
	else
		echo "Downloading Solr..."
		$GET $SOLR_TGZ $SOLR_URL
		if [ ! -f $SOLR_TGZ ]; then
			echo "ERROR: Failed to download Fedora Installer!"
			exit 1
		fi
		$CHOWN $SOLR_TGZ
	fi
	tar zxf $SOLR_TGZ -C $TMPDIR
	$CHOWN $TMPDIR/apache-solr-1.2.0

	# Create Solr home
	SOLR_DIR=$TMPDIR/apache-solr-1.2.0
	echo "Creating Solr home at '$SOLR_HOME'..."
	$MKDIR $SOLR_HOME
	cp -r $SOLR_DIR/example/solr/* $SOLR_HOME
	$CHOWN $SOLR_HOME

	# Deploy Solr web application
	SOLR_WAR=$CATALINA_HOME/webapps/solr.war
	echo "Deploying Solr web application..."
	cp $SOLR_DIR/dist/apache-solr-1.2.0.war $SOLR_WAR

	# Configure Solr authentication
	echo "Configuring Solr security..."
	TOMCAT_USERS=$CATALINA_HOME/conf/tomcat-users.xml
	$GET_STDOUT $INSTALLER_URL/tomcat-users.xml |\
		sed "s!\(<user name=\"solrAdmin\" password=\"\).*\(\" .* />\)!\1$SOLR_PASSWORD\2!" \
			> $TOMCAT_USERS
	$CHOWN $TOMCAT_USERS
	WEBINF_DIR=$SOLR_DIR/dist/WEB-INF
	$MKDIR $WEBINF_DIR
	$GET_QUIET $WEBINF_DIR/web.xml $INSTALLER_URL/solr-web.xml
	cd $SOLR_DIR/dist
	zip -qu $SOLR_WAR WEB-INF/web.xml
	$CHOWN $SOLR_WAR
	cd -
}

InstallTheFascinator() {
	# Download the distribution
	#TODO Checksum before downloading to verify
	TF_ZIP=$TMPDIR/the-fascinator.zip
	if [ -f $TF_ZIP ]; then
		echo "The Fascinator has already been downloaded"
	else
		echo "Downloading The Fascinator..."
		$GET $TF_ZIP $FASCINATOR_URL
		if [ ! -f $TF_ZIP ]; then
			echo "ERROR: Failed to download Fedora Installer!"
			exit 1
		fi
		$CHOWN $TF_ZIP
	fi
	unzip -q $TF_ZIP -d $FASCINATOR_HOME
	$CHOWN $FASCINATOR_HOME

	# Copy environment settings
	cp $ENV_SH $FASCINATOR_HOME/bin
	$CHOWN $FASCINATOR_HOME/bin/setenv.sh

	# Copy Solr schema
	echo "Installing Solr schema..."
	cp $FASCINATOR_HOME/index/solr/schema.xml $SOLR_HOME/conf

	# Configure and deploy indexer web service 
	echo "Deploying indexer web service..."
	cd $FASCINATOR_HOME/index/WEB-INF/classes
	cat indexer.properties.sample |\
		sed "s!\(registry\.pass=\).*!\1$FEDORA_PASSWORD!" |\
		sed "s!\(solr\.pass=\).*!\1$SOLR_PASSWORD!" > indexer.properties
	$CHOWN indexer.properties
	cd $FASCINATOR_HOME/index
	zip -qru indexer.war WEB-INF
	$CHOWN indexer.war
	cp indexer.war $CATALINA_HOME/webapps
	$CHOWN $CATALINA_HOME/webapps/indexer.war

	# Configure and deploy portal web application
	echo "Deploying portal web application..."
	cd $FASCINATOR_HOME/portal/WEB-INF
	cat config.properties.sample |\
		sed "s!\(solr.pass=\).*!\1$SOLR_PASSWORD!" |\
		sed "s!\(portals\.dir=\).*!\1$PORTAL_CONFIG_HOME!" > config.properties
	cat velocity.properties.sample |\
		sed "s!\(file\.resource\.loader.path = \).*!\1$PORTAL_CONFIG_HOME!" > velocity.properties
	cd $FASCINATOR_HOME/portal/WEB-INF/classes
	cp Identify.xml.sample Identify.xml
	cat proai.properties.sample |\
		sed "s!\(^proai\.db\.url = .*//\)/.*\(/proai.*\)!\1$PORTAL_CONFIG_HOME\2!" |\
		sed "s!\(fascinator\.portals\.dir=\).*!\1$PORTAL_CONFIG_HOME!" > proai.properties
	$CHOWN $FASCINATOR_HOME/portal/WEB-INF
	cd $FASCINATOR_HOME/portal
	zip -qru the-fascinator.war WEB-INF
	$CHOWN the-fascinator.war
	cp the-fascinator.war $CATALINA_HOME/webapps
	$CHOWN $CATALINA_HOME/webapps/the-fascinator.war

	# Create portal configuration directory
	echo "Creating portal configuration directory '$PORTAL_CONFIG_HOME'..."
	$MKDIR $PORTAL_CONFIG_HOME
	cp -r $FASCINATOR_HOME/portal/config/* $PORTAL_CONFIG_HOME
	$CHOWN $PORTAL_CONFIG_HOME
}

Start() {
	# Create harvest.properties file so that repository password is not in the individual properties files
	HARVEST_PROPERTIES=$FASCINATOR_HOME/harvest/config/harvest.properties
	echo "registry.pass=$FEDORA_PASSWORD" >> $HARVEST_PROPERTIES
	
	URL=http://localhost:8080/the-fascinator
	echo "Starting Tomcat server..."
	su $REAL_USER -c $FASCINATOR_HOME/bin/startup.sh
	sleep 20
	echo
	echo "Congratulations you have successfully installed The Fascinator!"
	echo "Opening a browser to '$URL'"
	echo "Use the scripts in the $FASCINATOR_HOME/bin to control the Tomcat server."
	echo
	if [ "$OSNAME" = "macosx" ]; then
		open $URL
	elif [ "$OSNAME" = "ubuntu" ]; then
		su $REAL_USER -c "firefox $URL"
	elif [ "$OSNAME" = "redhat" ]; then
		htmlview $URL
	fi
	echo "Installation complete."
}

InstallJava
InstallFedora
InstallSolr
InstallTheFascinator
Start
