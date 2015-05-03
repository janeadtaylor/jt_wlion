<?php

/**
 * Database model for Jobs
 */

class Jobs Extends DB {

    public function __construct(){
        parent::__construct();
    }
    
    public function getAll() {
        $sql = "
            SELECT jobs.id, users.name as userName, users.email, jobs.name as jobName
            FROM jobs
            INNER JOIN users ON jobs.user_id = users.id
            ORDER BY userName, jobName ASC";
       
        $jobs = array();
        
        $stmt = $this->mysqli->prepare($sql);
        $stmt->execute();
        $results = $stmt->get_result();
        

        while($row = $results->fetch_array(MYSQLI_ASSOC)) {
            $newJob = new Job();
            $newJob->setId($row["id"]);
            $newJob->setUserName($row["userName"]);
            $newJob->setEmail($row["email"]);
            $newJob->setJobName($row["jobName"]);
            
            $jobs[] = $newJob;
        }
        
        return $jobs;
    }
    
    public function getUserIdByJobId($id) {
        $sql = "SELECT id, user_id from jobs WHERE id = ?";
         
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $results = $stmt->get_result();

        while($row = $results->fetch_array(MYSQLI_ASSOC)) {
            $newJob = new Job();
            $newJob->setId($row["id"]);
            $newJob->setUserId($row["user_id"]);
        }
    
        return $newJob;
    }
    
}