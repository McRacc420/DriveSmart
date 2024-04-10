<?php
include_once('User.php');

class Student extends User {

    // function that is used to retrieve all data from a student based on the passed userId
    public function details($userId) {
        $sql = "SELECT * FROM student WHERE id = '".$userId."'";
        $query = $this->connection->query($sql);
        $row = $query->fetch_array();
        return $row;
    }

}

?>