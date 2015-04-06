# jt_wlion

This is a simple resume submission application that saves an uploaded document and emails the client. The form uses AJAX to submit the form and upload the attached document. The application emails the attached document to the client email address for the selected job. Note, for mail to work sendmail must be enabled on the server. If email is not working, check to make sure the call to the emailFile() method in modules/resumes/upload.php is uncommented. 

There is a db.sql file that contains a SQL script to create the required database.  The config values in the core/db.php file will need to be updated for the given environment. Also, the public/uploads directory should be writeable. 

The code is split out into data objects and models for database integration. Typically I would create a front controller and controllers for each module then route to the appropriate controller based on the URI values but for time's sake, I've kept it simple and have all of the logic combined into a single index.php. Also, I would typically separate out the view content from the business logic, but since there's really only one view I just put it in the main index.php file. 



