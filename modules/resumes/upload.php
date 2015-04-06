<?php
require_once '../../core/db.php';
require_once '../../core/functions.php';
require_once '../../modules/resumes/data/resume.php';
require_once '../../modules/users/model/users.php';
require_once '../../modules/users/data/user.php';
require_once '../../modules/jobs/model/jobs.php';
require_once '../../modules/jobs/data/job.php';
require_once 'model/resumes.php';

/* NOTE
 This is not ideal for organizing business logic but it's a quick way 
 to solve the problem without routers/controllers using a direct AJAX call
*/

//do some basic server-side validation
if($_POST['email'] == '') {
    echo "<br />Error: You must enter an email address.";
} else if ($_POST['title'] == '') {
    echo "<br />Error: You must enter a resume title.";
} else {
    if (isset($_FILES["myfile"])) {
        
        //santize the post data for security purposes
        $postData = sanitize($_POST);

        //create the new user and resume objects using the data submitted from the form
        $user = new User();
        $user->setUser_type_id(User::$USER_TYPE_APPLICANT);
        $user->setName($postData['name']);
        $user->setEmail($postData['email']);
        $user->setPhone($postData['phone']);
        
        $resume = new Resume();
        $resume->setJob_id($postData['jobId']);
        $resume->setName($postData['title']);
        $resume->setFile($_FILES["myfile"]["name"]);
        
        $data['user'] = $user;
        $data['resume'] = $resume;
        
        //insert the user and resume data into the database
        $resumeDb = new Resumes();
        $resumeDb->insert($data);
        
        //upload the file
        if ($_FILES["myfile"]["error"] > 0) {
            echo "Error: " . $_FILES["file"]["error"] . "<br>";
        } else {
            $upload_dir = "../../public/uploads/";
            move_uploaded_file($_FILES["myfile"]["tmp_name"], $upload_dir . $_FILES["myfile"]["name"]);
    
            echo "<br />Your resume has been successfully submitted.";
    
//             echo "<pre>";
//             print_r(sanitize($_POST));
//             print_r($_FILES);
        }

        //get the client email address for the select job id
        $jobsDb = new Jobs();
        $job = $jobsDb->getByUserIdByJobId($postData['jobId']);
        
        $clientDb = new Users();
        $client = $clientDb->getById($job->getUserId());

        $clientEmail = $client->getEmail();
        
        //email the file to the client
        emailFile($clientEmail, "New Resume Submission", "A new resume has been submitted. See the attached document.", $_FILES["myfile"]["name"]);

    } else {
        echo "<br />Error: You must select a file to upload.";
    }
}

?>