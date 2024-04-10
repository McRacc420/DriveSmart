<?php
//start session
session_start();

//including crud class file
include_once('../Objects/Crud.php');

//if the license is set and passed through get method
if(isset($_GET['license'])){

    //store license
    $license = $_GET['license'];
     
    //create new instance of crud
    $crud = new Crud();

    //delete data
    $sql = "UPDATE vehicle SET archived = '1' WHERE license = '$license'";

    if($crud->execute($sql)){
        $_SESSION['message'] = 'Wagen succesvol verwijderd.';
    }
    else{
        $_SESSION['message'] = 'Wagen kan niet verwijderd worden.';
    }
        
    header('location: ../vehicles.php');
}
else{
    $_SESSION['message'] = 'Kies eerst een wagen om te verwijderen.';
    header('location: ../vehicles.php');
}
?>