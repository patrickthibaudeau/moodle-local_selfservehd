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

I'm sure this canbe done for IOS devices too, however, because this is to be used locally, Android makes it much easier without having the need to publish in the online store. We can simply add the apk to the device.    