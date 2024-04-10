<?php
include_once('User.php');

class Instructor extends User {

    // function that is used to retrieve all data from a instructor based on the passed userId
    public function details($userId) {
        $sql = "SELECT * FROM instructor WHERE id = '".$userId."'";
        $query = $this->connection->query($sql);
        $row = $query->fetch_array();
        return $row;
    }
}

?>