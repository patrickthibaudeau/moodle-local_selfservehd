# Self Serve Helpdesk
The system will be used a York University Glendon Campus. There are two modules to the system.

 1. Classroom support kiosk
 2. Self serve kiosk

## Classroom support kiosk
The class room support kiosk will be built using Touchscreen Raspberry Pi's that will communicate through web services to a server.  When a professor requires assistance, they will click the request assistance button. They will then be provided help in the form of an FAQ for the technology within the room. If that help does not work, there will be a button to call for help. When pressed, it will send a call to the server which will then dispatch a notification to an app or web application so that a technician can go to the room and help. There is an interactive PDF Mockup (classroomsupport.pdf) of the kiosk in the mockup folder of the project.
## Self serve kiosk
The self serve kiosk will be an app/web site that will be available on tablets throughout the institution. Similar to the Classroom support kiosk, it will have button to request help. However, it will also have a chat bot, knowledge base and area to create tickets. I am also thinking of adding a campus map way finder. That might be in a future release.
### Technologies used
The server portion of the app is developed in Moodle as a local plugin. I use Moodle as a framework. It has everything built-in: Authentication, Roles, Capabilities, Security, DB API, Webservice API and so much more.
The Classroom support kiosks are Raspberry Pi with a Touchscreen.
The Classroom support notification for agents will be an Android app.
The Self serve Kiosks will be an Android app. 

I'm sure this can be done for IOS devices too, however, because this is to be used locally, Android makes it much easier without having the need to publish in the online store. We can simply add the apk to the device.    

 ### Installation
 I am presuming that you already have a Moodle server installed. If not, follow [these instructions](https://docs.moodle.org/36/en/Installing_Moodle)
 
 Download the repository and unzip in the *moodle_root*/local/ folder. Rename the folder to selfservehd.
 Login to your Moodle instance as an adminsitrator. The plugin installation should start. Press the install button.

The plugin should now be installed. But you're not done yet.

 #### Setting up the Web service
##### Enable web services
1. In the nav drawer, click Site administration
2. Click on Advanced features
3. If not checked, click "Enable web services"
4. Save changes

##### Enabled Web services authentication

 1. In the nav drawer, click Site administration
 2. Click on the "Plugins" tab
 3. Scroll down to Authentication
 4. Click on Manage authentication
 5. Click the closed eye for Web services authentication
 
 ##### Create a user for the web service 

 1. Go to Site administrations and click the Users tab
 2. Click add a new user
 3. Enter a username
 4. Select Web services authentication from the "Choose an authentication method" drop down.
 5. Password field is disabled. (Web services use tokens)
 6. Enter First name, Surname and email (The email can be a fake address)
 7. Click on the "Create user" button

##### Create a role for the web service

 1. In the nav drawer, click Site administration
 2. Click the users tab
 3. Click "Define roles"
 4. Click "Add a new role"
 5. Do not select anything, simply click "Continue"
 6. Enter a short name : sshd
 7. Enter a Custom full name: Self Serve Help Desk
 8. Click on the checkbox for System for the "Context types where this role may be assigned"
 9. Scroll down to the filter field and enter selfeserve.
 10. Click the Allow checkbox for Raspberry PI access
 11. Click the "Create this role" button

#####  Add newly created user to new role

 1. In the nav drawer, click Site administration
 2. Click the users tab
 3. Click "Assign system roles
 4. Click "Self Serve Help Desk"
 5. Select the user you created above from Potential users and click the "Add" button

##### Create an external service

  1. In the nav drawer, click Site administration
 2. Click on the "Plugins" tab
 3. Scroll down to Web services ( at the bottom)
 4. Click External services. (I usually right-click and open in a new tab as I will need to return to this exact page for the next few steps)
 5. Click "add"
 6. Enter a name and short name. (I use the same as the role.)
 7. Click enable
 8. Click Authorised users only
 9. Click the "Add service" button.
 10. In the new page, click "Add functions"
 11. In the search field type sshd_
 12. Click on sshd_get_raspberry_pi:Set MAC Address
 13. Click the "Add functions" button

##### Add authorized user to external service
  1. In the nav drawer, click Site administration
 2. Click on the "Plugins" tab
 3. Scroll down to Web services ( at the bottom)
 4. Click External services. 
 5. Click Authorized users for the External service you just created (Should be called Slef Serve Help Desk)
 6. Select the user you created previously from the Not authorised users box
 7. Click "Add"

##### Enable REST protocol
 1. In the nav drawer, click Site administration
 2. Click on the "Plugins" tab
 3. Scroll down to Web services ( at the bottom)
 4. Click "Manage protocols"
 5. Click the closed eye for REST protocol to enable.

#####  Create a Token
 1. In the nav drawer, click Site administration
 2. Click on the "Plugins" tab
 3. Scroll down to Web services ( at the bottom)
 4. Click "Manage tokens"
 5. Click "Add"
 6. Select the user you created previously.
 7. Select "Self Serve Help Desk" from the drop down menu for the service field
 8. Click "Save changes"
 9. Copy the Token. You will need to add it to your Raspberry Pi's

All web service calls are done to the following address
https://your_moodle.server/webservice/rest/server.php?wstoken=your_token&wsfunction=your_function
You will also need to add any other query parameters required by the function.
Optionally, you can add &moodlewsrestformat=json to receive the reply in json format. Otherwise XML is used.
Example

    https://localhost/moodle/webservice/rest/server.php?wstoken=d766a1dbaea861cf7934088dfea065b6&wsfunction=sshd_get_raspberry_pi&mac=00:BB:00:00:00&ip=192.168.5.5

