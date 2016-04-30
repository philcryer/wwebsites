echo -n "New username: "
read REPLY
username=$REPLY
echo "Adding $username"
temp_password="qwerty"
mkpasswd  $temp_password > pass
password=`cat pass`
echo The password is: $password
useradd -g users -p $password -d /home/$username -p $password -s /bin/bash $username
echo "useradd -g users -p $password -d /home/$username -p $password -s /bin/bash $username"
mkdir /home/$username
echo "mkdir /home/$username"
chown -R $username:users /home/$username
echo "chown -R $username:users /home/$username"
                                                                                
echo "Newuser $username added.\n";
rm pass

