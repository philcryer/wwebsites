#!/bin/sh
clear
echo "======================================================="
echo " Zimbra dev-install"
echo "======================================================="
echo ""
echo " Ensure that you have the following installed:"
echo " 		sudo"    
echo "		gcc"
echo "		rpm"
echo "		rpm-build"
echo "		libidn"
echo "		curl"
echo "		fetchmail"
echo "		ant-1.6.5"
echo "		Sun Java Development Kit 1.5.0_04"
echo ""
echo "======================================================="
echo ""; sleep 5
echo " Starting..."; echo ""
mkdir ~/zcs-src
cd ~/zcs-src
curl -O http://downloads.zimbra.com/3.0_M1/zcs-3.0.M1_21-src.tgz
tar -zxf zcs-3.0.M1_21-src.tgz
mkdir /opt/zimbra
useradd zimbra
chown -R zimbra:users /opt/zimbra
which java > java_dir
ln -s `cat java_dir` /usr/local/java
rm java_dir
cd ~/zcs-src/ZimbraBuild
make dev-install
echo "/opt/zimbra/lib" >> /etc/ld.so.conf
echo "/opt/zimbra/sleepycat/lib" >> /etc/ld.so.conf
echo "/opt/zimbra/openldap/lib" >> /etc/ld.so.conf
echo "/opt/zimbra/cyrus-sasl/lib" >> /etc/ld.so.conf 
ldconfig
echo "zimbra   ALL=NOPASSWD:/opt/zimbra/openldap/libexec/slapd" >> /etc/sudoers
echo "zimbra   ALL=NOPASSWD:/opt/zimbra/postfix/sbin/postfix" >> /etc/sudoers
echo "zimbra   ALL=NOPASSWD:/opt/zimbra/postfix/sbin/postalias" >> /etc/sudoers
groupadd postdrop
groupadd postfix
useradd -d /opt/zimbra/postfix -g postfix postfix
/opt/zimbra/postfix/sbin/postfix set-permissions
chmod 775 /opt/zimbra/postfix/conf
/opt/zimbra/bin/zmmyinit
/opt/zimbra/bin/zmldapinit
/opt/zimbra/bin/zmmtainit localhost
/opt/zimbra/bin/zmmtaconfig mta
/opt/zimbra/bin/zmldappasswd zimbra
/opt/zimbra/bin/zmldappasswd --root zimbra
/opt/zimbra/bin/zmmypasswd zimbra
/opt/zimbra/bin/zmmypasswd --root zimbra
echo ""
echo "======================================================="
echo ""
echo " Zimbra should be up and running, in a browser, try hitting:"
echo " 		http://localhost:7070/zimbra/mail"
echo " 		or substitute your hostname/url in place of localhost"
echo ""
echo " Login with account 'user1'"
echo " and with password 'test123'"
echo ""
exit 0

