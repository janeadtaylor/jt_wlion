<?php

/**
 * Database model for Resumes
 */

class Resumes Extends DB {

    public function __construct(){
        parent::__construct();
    }
    
    public function insert($data) {
        
        //@todo: insert a new user then insert a resume using the new user id

        $user = $data['user'];
        $user_type_id = $user->getUser_type_id();

        $insertUserSql = "INSERT INTO users (
            user_type_id, 
            name, 
            email, 
            phone) 
          VALUES (
            '". $user->getUser_type_id() ."',
            '". $user->getName() ."',
            '". $user->getEmail() ."',
            '". $user->getPhone() ."'
        )";
        
        $this->exec($insertUserSql);
        
        $newUserId = mysqli_insert_id($this->mysqli);
        
        $resume = $data['resume'];
        $resume->setUser_id($newUserId);
        
        var_dump($resume);
         
        //return $this->exec($sql);
    }
}