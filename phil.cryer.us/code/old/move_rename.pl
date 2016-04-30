#!/usr/bin/perl
#
# this script moves the Silktest results file (/home/pcryer/tmp/master.rex)
# to the webservers log directory (/var/www/html/logs) and then renames the 
# file with the date (ie 20020208) and makes it into a text (.txt) file.
#
#


# Variable
$NEWNAME = `date +%Y%m%d.txt`;

# Functions
&MOVE;  
&DATE;     


sub MOVE
{
    print "   Moving file...\n";
    if  ( `mv /home/pcryer/tmp/master.rex /var/www/html/logs/` == 0 )
    {
        print "Done\n";
    }
    else
    {
        print "\n";
        print "     ERROR: there was an error moving the file.\n";
        print "\n";
        exit ;
    }
}


sub DATE
{
    	print "   Changing the name of the file...\n";
if  ( `mv /var/www/html/logs/master.rex /var/www/html/logs/$NEWNAME` == 0 )
    {
        print "Done\n";
    }
    else
    {
        print "\n";
        print "     ERROR: there changing the name of the file.\n";
        print "\n";
        exit ;
    }
}
