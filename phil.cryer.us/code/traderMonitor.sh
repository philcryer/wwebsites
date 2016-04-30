#!/bin/ksh
#
#
# 2005.03.09
# added the ability to read args passed during the command
#
#
if [ $# -ne 2 ]
then
    echo "usage: $0 <trader env script> <owner>" >&2
    exit 1
fi
#
traderEnv="$1"
owner="$2"
traderName="`basename $traderEnv .env.sh`"
traderBin=`dirname $traderEnv`
traderStartup="$traderBin/$traderName.startup.sh"
#
# Make sure we are the owner of the trader process
me=`whoami`
if [ "$me" != "$owner" ]
then 
  echo "This command must be run as user: $owner; Current user is: $me" >&2
  exit 1
fi
#
# Source the trader env script
. $traderEnv > /dev/null 2>&1
#
############################################################################
# Test to see if the trader is responsive 
############################################################################
#
$traderBin/trtest 
if [ $? -eq 0 ] 
then
   # The trader is ok
   exit 0
fi 

# trader failed, retry
maxRetries=2
retryDelay=10
tries=0
while [ $tries -lt $maxRetries ]
do
   sleep $retryDelay  
   $traderBin/trtest 
   if [ $? -eq 0 ] 
   then
      # The trader is ok now
      echo "Encountered intermittent communication failure; trader was not recycled" >&2
      exit 1
   fi 
   ((tries=$tries+1))
done
#
############################################################################
# Restart trader
############################################################################
echo "Trader is not responding; restarting..." >&2
#
# find the pid
processName="tr$TRADER_PORT"
pid=`ps -ef | fgrep $processName | fgrep -v fgrep | cut -c10-14`
#
if [ -z "$pid" ]
then
   echo "No trader $processName exists" >&2
else 
#
  # Save off the debug log if it exists 
  debugFile="/tmp/trader.debug"
  today=`date "+%Y.%m.%d-%R"`
  if [ -e "$debugFile" ]; then 
     cp $debugFile $debugFile.$today    
  fi 

   echo "Killing $pid" >&2
   kill -9 $pid
fi
#
# Restart
$traderStartup >&2
#
exit 1 	



