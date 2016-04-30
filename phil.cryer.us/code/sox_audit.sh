#!/bin/sh

## define variables
EMAIL_1="phil@someemailaddress.com"
HOSTNAME=`uname -n`
PATH=$PATH:/usr/bin:/bin:/usr/sbin:/sbin:/usr/local/bin
USAGE="usage:  sox_audit.sh [ cm | prod ]"

## explain usage
if [ $# -ne 1 ]; then
        echo $USAGE
        exit 1
fi

## define what directory or path we need to search
if [ ${1} = "cm" ]; then
        prog_name="PaymentAgent"
elif [ ${1} = "prod" ]; then
        prog_name="LiveProcessor"
else
        echo $USAGE
        exit 1
fi

## set beacon files to define time
touch -t `date +%Y%m%d%H%M` /tmp/end; touch -t `TZ=EST30EDT date +%Y%m%d%H%M` /tmp/start

## find any changed files within directory or path
find /$1 \( -newer /tmp/start -a \! -newer /tmp/end \) >/dev/null 2>&1 -ls > /tmp/raw

## grep out expected results
grep -v cache /tmp/raw | grep -v test | grep -v lost\+found | grep -v prod\/fifo | grep -v prod\/lock >> /tmp/${HOSTNAME}-${prog_name}_results

## everybody likes email
if [ -s ${HOSTNAME}-${prog_name}_results ]; then
        awk '{print $0 "\r"}' /tmp/${HOSTNAME}-${prog_name}_results | uuencode `date +%Y-%m-%d`-${HOSTNAME}-${prog_name}_audit.txt | mailx -s "$prog_name No Changed Files ${HOSTNAME} `date '+%m%d%y'`" $EMAIL_1,$EMAIL_2,$EMAIL_3,$EMAIL_4,$EMAIL_5
else
        awk '{print $0 "\r"}' /tmp/${HOSTNAME}-${prog_name}_results | uuencode `date +%Y-%m-%d`-${HOSTNAME}-${prog_name}_audit.txt | mailx -s "$prog_name Changed Files ${HOSTNAME} `date '+%m%d%y'`" $EMAIL_1,$EMAIL_2,$EMAIL_3,$EMAIL_4,$EMAIL_5
fi

## cleanup on aisle 5
#rm /tmp/raw /tmp/start /tmp/end /tmp/${HOSTNAME}-${prog_name}_results

## big exit
exit 0
