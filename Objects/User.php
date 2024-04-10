<?php
include_once('DbConnection.php');
 
class User extends DbConnection {
    public function __construct() {
        parent::__construct();
    }

    // function that is used to determine whether a user trying to login is an instructor or a student and logging them in
    public function determineRoleAndCheckLogin($email, $password) {

        $sql = "SELECT * FROM student WHERE email = '$email' AND password = '$password' AND archived = 0";
        $query = $this->connection->query($sql);

        //if user is a student
        if($query->num_rows > 0) {
            $row = $query->fetch_array();
            //return array with id and role
            return array($row['id'], 'student');

        //if user is an instructor
        } else {
            
            $sql = "SELECT * FROM instructor WHERE email = '$email' AND password = '$password' AND archived = 0";
            $query = $this->connection->query($sql);

            if($query->num_rows > 0) {
                $row = $query->fetch_array();
                //return array with id and role
                return array($row['id'], 'instructor');

            //if user credentials are not found at all
            } else {
                return false;
            }

        }

    }
    
    //function that is used to prevent sql injection by performing it on all user inputs
    public function escapeString($value) {
        return $this->connection->real_escape_string($value);
    }
}