#!/usr/bin/ksh
# Author:       Phil Cryer
# Created:      08/01/06
# Features:     backs up files/directories for DR (defined by the ARCHIEVED_PATHS variable)
#               rotates existing backup files on remote server
#               copies current backup to remote server
#		duplicates effort from remote server, to copy files over
#			(syncs DR files to/from both hosts)
#		uses/relies on shared SSH keys between boxes
#               rinses sparkly clean
# Filename:     dr_backup.sh
# Usage:        dr_backup.sh REMOTE_SEV
# Usage sample: drbackup.sh server2
# Cron sample:  15 0 * * 0 /home/prodops/bin/dr_backup.sh server2 >/dev/null 2>&1
#
umask 027
USAGE="usage:  dr_backup.sh REMOTE_SERVERNAME"
if [ $# -ne 1 ]; then
        echo $USAGE
        exit 1
fi
#
# Variables
ARCHIEVED_PATHS="/opt/foo /home/foobar"
REMOTE_SER=$1
LOCAL_SER=`hostname`
PATH=/usr/bin:/bin:/usr/sbin:/sbin:/usr/local/bin
TARNAME=`date +%Y%m%d`_${LOCAL_SER}_dr.tar
#
# Summary
echo " dr_backup : backup critical files for disaster recovery"
echo "           -> Creating tarfile of dr files..."
# Make tarfile backup
if [ ! -d ~/tmp ]; then
        mkdir ~/tmp
fi
cd ~/tmp
tar -cf ${TARNAME} ${ARCHIEVED_PATHS}
#
# Rotate backup dirs on remote server
echo "	-> Rotating backup directories on ${REMOTE_SER}..."
ssh ${REMOTE_SER} 'if ! [ -d ~/dr_backups -a -r ~/dr_backups -a -w !/dr_backups ]; then; mkdir -p 

~/dr_backups';fi'
ssh ${REMOTE_SER} 'rm -rf ~/dr_backups/04'
ssh ${REMOTE_SER} 'mv ~/dr_backups/03 ~/dr_backups/04'
ssh ${REMOTE_SER} 'mv ~/dr_backups/02 ~/dr_backups/03'
ssh ${REMOTE_SER} 'mv ~/dr_backups/01 ~/dr_backups/02'
ssh ${REMOTE_SER} 'mkdir ~ /dr_backups/01 >/dev/null 2>&1'
#
# Scp the tarfile to the remote server in the 01 dir
echo "           -> Copying ${TARNAME} to ${REMOTE_SER}..."
scp ${TARNAME} ${REMOTE_SER}:~/dr_backups/01 >/dev/null 2>&1
#
# Remove tarfile from local server
echo "           -> Removing local tarfile..."
rm  ~/tmp/${TARNAME}
#
# Done
echo "           -> Done"
#
echo "	-> Rotating backup directories on ${LOCAL_SER}..."
ssh ${REMOTE_SER} '~/bin/dr_backup.sh ${LOCAL_SER}'
echo "	-> Complete"
exit 0
