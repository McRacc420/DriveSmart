<?php
// Start session
session_start();

//include all user classes
include_once('Objects/User.php');
include_once('Objects/Instructor.php');
include_once('Objects/Student.php');

//create instances of user, instructor and student classes
$user = new User();
$instructor = new Instructor();
$student = new Student();

//if login form is submitted
if (isset($_POST['login'])) {
    //store data from form submission, use the escapeString method to prevent sql injections
    $email = $user->escapeString($_POST['email']);
    $password = $user->escapeString(md5($_POST['password']));

    //store result of determineRoleAndCheckLogin function
    $userAuth = $user->determineRoleAndCheckLogin($email, $password);

    //if returns false
    if(!$userAuth){
        $_SESSION['message'] = 'Incorrect e-mailadres of wachtwoord.';
        header('location:index.php');
        exit; 
    }

    //store essential user data in session variables
    $_SESSION['userId'] = $userAuth[0];
    $_SESSION['userRole'] = $userAuth[1];
    header('location:home.php');
    //stop further execution
    exit; 

} else {
    $_SESSION['message'] = 'Gelieve eerst in te loggen.';
    header('location:index.php');
}
?>
