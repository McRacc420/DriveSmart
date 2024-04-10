<?php
include_once('DbConnection.php');
 
class Crud extends DbConnection
{
    public function __construct(){

        parent::__construct();
    }
    
    //function that is used to retrieve data from the database based on the passed parameter sql statement
    public function read($sql){

        $query = $this->connection->query($sql);
        
        if ($query == false) {
            return false;
        } 
        
        $rows = array();
        
        while ($row = $query->fetch_array()) {
            $rows[] = $row;
        }
        
        return $rows;
    }
        
    //function that is used to execute sql statements on the database through the passed sql parameter
    public function execute($sql){

        $query = $this->connection->query($sql);
        
        if ($query == false) {
            return false;
        } else {
            return true;
        }        
    }
    
    //function that is used to prevent sql injection by performing it on all user inputs
    public function escapeString($value){
        
        return $this->connection->real_escape_string($value);
    }
}