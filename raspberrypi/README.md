## Raspberry PI configuration

### Create bash script in /home/pi/Documents

    cd Documents
    nano sendmac.sh
Copy past the following code. Remember to change the HOST variable to your Moodle URL. Also remember to change the TOKEN variable .

    #!/bin/bash
    #Enter the host address of your moodle server
    HOST=https://yourserver.com
    
    #Enter the token from your Moodle server
    TOKEN=YOURTOKEN
    
    #######DO NOT EDIT BEYOND THIS POINT########
    MAC=$(ip -o link show dev eth0 | grep -Po 'ether \K[^ ]*')
    IP=$(hostname -I)
    echo "$MAC"
    curl "$HOST/webservice/rest/server.php" -d"wstoken=$TOKENwsfunction=sshd_get_raspberry_pi&mac=$MAC&ip=$IP"
Save and close the new file by pressing ctrl-x
Change the permissions on the file

    chmod 755 sendmac.sh
### Prepare cron

    crontab -e
If this is your first time select your preferred editor. Nano is the default.
Add the following line

    */5 * * * * /home/pi/Documents/sendmac.sh

That will run the script every five minutes. This is used as a status in the Moodle management area. If the last ping is more then five minutes, it will show the status as red (not connected.)
 

### Troubleshooting
If you created the file in Windows and then transferred to your Raspberry PI, it will probably not work. Run this command to fix the file

    sed -i -e 's/\r$//' sendmac.sh


> Written with [StackEdit](https://stackedit.io/).

