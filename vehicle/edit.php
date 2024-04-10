<?php
//start session
session_start();

//including crud class file
include_once('../Objects/Crud.php');

//create new instance of crud
$crud = new Crud();

//if 'edit' form is submitted with post method
if(isset($_POST['edit'])) {   
    $license = $crud->escapeString($_POST['license']);
    $brand = $crud->escapeString($_POST['brand']);
    $type = $crud->escapeString($_POST['type']);
    $fuel = $crud->escapeString($_POST['fuel']);
    //convert booleans to 1 and 0
    if (isset($_POST['cruisecontrol'])) {
        if ($_POST['cruisecontrol'] == 'true') {
            $cruisecontrol = 1;
        } else {
            $cruisecontrol = 0;
        }
    } else {
        $cruisecontrol = 0;
    }
    
    //check if fields are empty
    if (empty($license) || empty($brand) || empty($type) || empty($fuel)) {
        // send error message when one of the fields is empty
        $_SESSION['message'] = 'Wagen kan niet worden toegevoegd, verplichte velden mogen niet leeg zijn.';
    } else {
        //insert data to database
        $sql = "UPDATE vehicle SET brand = '$brand', type = '$type', fuel = '$fuel', has_cruise_control = '$cruisecontrol' WHERE license = '$license' AND archived = 0";

        if($crud->execute($sql)){
            $_SESSION['message'] = 'Wagen succesvol gewijzigd.';
        }
        else{
            $_SESSION['message'] = 'Wagen kan niet worden gewijzigd.';
        }
    }

    header('location: ../vehicles.php');
}
else{
    $_SESSION['message'] = 'Wagen kan niet worden gewijzigd, gelieve het formulier in te vullen';
    header('location: ../vehicles.php');
}
?>