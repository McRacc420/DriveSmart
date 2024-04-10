<?php
//start session
session_start();

//include crud object file
include_once('../Objects/Crud.php');
 
//create new instance of crud
$crud = new Crud();
 
//if 'add' form is submitted with post method
if(isset($_POST['add'])) {   
    //store data from form submission, use the escapeString method to prevent sql injections
    $date = $crud->escapeString($_POST['date']);
    $time = $crud->escapeString($_POST['time']); 
    $instructorId = $crud->escapeString($_POST['instructor-select']);
    $vehicleLicense = $crud->escapeString($_POST['vehicle-select']); 

    //check if fields are empty
    if (empty($date) || empty($time) || empty($instructorId) || empty($vehicleLicense)) {
        //send a message if one of the fields is empty
        $_SESSION['message'] = 'Lesblok kan niet worden toegevoegd, verplichte velden mogen niet leeg zijn.';
    } else {
        //insert data to database
        $sql = "INSERT INTO lessonblock (instructor_id, vehicle_license, date, timeblock) VALUES ('$instructorId','$vehicleLicense','$date','$time')";
        
        if($crud->execute($sql)){
            //if execution successful, send a success message
            $_SESSION['message'] = 'Lesblok succesvol toegevoegd.';
        }
        else{
            //if execution unsuccessful, send a fail message
            $_SESSION['message'] = 'Lesblok kan niet worden toegevoegd.';
        }
    }

    //send user back to lessonblocks page
    header('location: ../lessonblocks.php');
}
else{
    //send message to alert user to submit the form
    $_SESSION['message'] = 'Lesblok kan niet worden toegevoegd, gelieve het formulier in te vullen';
    
    //send user back to lessonblocks page
    header('location: ../lessonblocks.php');
}
?>