<?php

/**
 * Base database class
 */

class DB {
    //update these value for the given environment
    private $db = 'jt_wlion';
    private $host = 'localhost';
    private $user = 'jt_wlion';
    private $pass = 'resumes1!';
    public $mysqli;
    
    //would probably use a singleton for the DB connection in most cases
    public function __construct() {        
        $this->mysqli = new mysqli($this->host, $this->user, $this->pass, $this->db);
        
        if ($this->mysqli->connect_error) {
            die('Error : ('. $this->mysqli->connect_errno .') '. $this->mysqli->connect_error);
        }
    }
    
    public function exec($sql)
    {
       return $this->mysqli->query($sql);
    }
    
}
