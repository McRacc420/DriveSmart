<?php
//start session
session_start();

//including crud class file
include_once('../Objects/Crud.php');
 
//create new instance of crud
$crud = new Crud();
 
//if 'add' form is submitted with post method
if(isset($_POST['add'])) {   
    //store data from form submission, use the escapeString method to prevent sql injections
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
    if (empty($license) || empty($brand) || empty($type) || empty($fuel) || empty($cruisecontrol)) {
        //send a message if one of the fields is empty
        $_SESSION['message'] = 'Wagen kan niet worden toegevoegd, verplichte velden mogen niet leeg zijn.';
    } else {
        //insert data to database
        $sql = "INSERT INTO vehicle (license, brand, type, fuel, has_cruise_control) VALUES ('$license','$brand','$type','$fuel','$cruisecontrol')";

        if($crud->execute($sql)){
        //if execution successful, send a success message
            $_SESSION['message'] = 'Wagen succesvol toegevoegd.';
        }
        else{
            //if execution unsuccessful, send a fail message
            $_SESSION['message'] = 'Wagen kan niet worden toegevoegd.';
        }
    }

    header('location: ../vehicles.php');
}
else{
    $_SESSION['message'] = 'Wagen kan niet worden toegevoegd, gelieve het formulier in te vullen';
    header('location: ../vehicles.php');
}
?>