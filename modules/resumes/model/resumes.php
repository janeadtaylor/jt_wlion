<?php

/**
 * Database model for Resumes
 */

class Resumes Extends DB {

    public function __construct(){
        parent::__construct();
    }
    
    public function insert($data) {  
        //insert a new user then insert a resume using the new user id
        $user = $data['user'];
        $user_type_id = $user->getUser_type_id();
        
        $sqlUsers = "INSERT INTO users (
            user_type_id, 
            name, 
            email, 
            phone) 
          VALUES (?, ?, ?, ?)";
        
        $userTypeId = $user->getUser_type_id();
        $userName = $user->getName();
        $userEmail = $user->getEmail();
        $userPhone = $user->getPhone();
        
        $stmt = $this->mysqli->prepare($sqlUsers);
        $stmt->bind_param("isss", $userTypeId, $userName, $userEmail, $userPhone);
        $stmt->execute();
        
        $newUserId = mysqli_insert_id($this->mysqli);
        
        $resume = $data['resume'];
        
        $sqlResumes = "INSERT INTO resumes (
            job_id,
            user_id,
            name,
            file)
          VALUES (?, ?, ?, ?)";
        
        $jobId = $resume->getJob_id();
        $resumeName = $resume->getName();
        $resumeFile = $resume->getFile();
        
        $stmt = $this->mysqli->prepare($sqlResumes);
        $stmt->bind_param("iiss", $jobId, $newUserId, $resumeName, $resumeFile);
        $stmt->execute();
        
        return mysqli_insert_id($this->mysqli);
    }
}