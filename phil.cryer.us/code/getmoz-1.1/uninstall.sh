#!/bin/bash

ROOT_UID=0                                                      # You must be root to uninstall getmoz

#
# START SCRIPT
#


echo 
echo '   getmoz uninstall'
echo 


# Check to see if user is ROOT, if not exit getmoz uninstall
if [ "$UID" -ne "$ROOT_UID" ]
then
	echo
	echo
	echo '     ERROR: You must have root privileges to uninstall getmoz.'
	echo 
	echo '   getmoz uninstall failed'
	echo
exit 1
fi


# Remove getmoz from /usr/local/bin
echo -n '   Removing getmoz from /usr/loca/bin...'
rm /usr/local/bin/getmoz
echo 'Done'


# Summarize uninstall, and exit
echo
echo '   getmoz successfully uninstalled'
echo

#
# END SCRIPT
#

exit 0 
