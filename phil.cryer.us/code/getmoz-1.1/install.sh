#!/bin/bash

ROOT_UID=0                                                      # You must be root to install getmoz

#
# START SCRIPT
#


echo 
echo '   getmoz install'
echo 


# Check to see if user is ROOT, if not exit getmoz install
if [ "$UID" -ne "$ROOT_UID" ]
then 
	echo '     ERROR: You must have root privileges to install getmoz.'
	echo 
	echo '   getmoz installation failed'
	echo
exit 1
fi


# Check for mozget and if it is found remove it from /usr/bin
echo -n '   Checking for an old mozget install in /usr/bin and removing if found...'
        if [ -e /usr/bin/mozget ]
then
        rm /usr/bin/mozget
fi
echo 'Done'



# Copying getmoz to /usr/local/bin
echo -n '   Copying getmoz to /usr/local/bin...'
cp -f getmoz /usr/local/bin
echo 'Done'


# Setting permissions for getmoz
echo -n '   Setting file permissions...'
chmod 755 /usr/local/bin/getmoz
echo 'Done'


# Summarize install, and exit
echo
echo '   getmoz successfully installed'
echo

#
# END SCRIPT
#

exit 0				    
