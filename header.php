<?php
	//start session
	session_start();

    //return to login if not logged in
	if (!isset($_SESSION['userId']) ||(trim ($_SESSION['userId']) == '')){
        header('location: index.php');
    }

    // include the student and instructor classes
    include_once('Objects/Instructor.php');
    include_once('Objects/Student.php');

    //create new instance of instructor OR student based on the userRole and get the user details with the details method
    if($_SESSION['userRole'] == 'instructor'){
        $instructor = new Instructor();
        $row = $instructor->details($_SESSION['userId']);
    }else if($_SESSION['userRole'] == 'student'){
        $student = new Student();
        $row = $student->details($_SESSION['userId']);
    }

    //if logout is triggered
    if(isset($_POST['logout'])) {
        // Unset all session variables
        $_SESSION = array();
    
        // Destroy the session
        session_destroy();
    
        // Redirect to the login page
        header("Location: index.php");
        exit();
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <title>Autorijschool DriveSmart</title>
  
    <!-- latest Bootstrap CSS version 5.3.3 as of 08/04/24 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

   <!-- latest Bootstrap Icons version 1.11.3 as of 08/04/24 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- our custom CSS -->
    <link rel="stylesheet" href="assets/styles.css" />

</head>
<body>

    <div class="drivesmart-header"></div>
    
    <!-- navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Autorijschool DriveSmart</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="home.php" class="nav-link">Home</a>
                    </li>
                    <?php
                    //if userrole is set
                    if(isset($_SESSION['userRole'])){
                        //if userrole is intructor
                        if($_SESSION['userRole'] == "instructor"){
                            ?>

                            <!-- navigation items for instructors go here -->

                            <?php
                            //if instructor is admin
                            if($row['is_admin'] == true){
                                ?>
                                <li class="nav-item">
                                    <a href="instructorAvailablity.php" class="nav-link">Beschikbaarheidsoverzicht</a>
                                </li>
                                <li class="nav-item">
                                    <a href="lessonblocks.php" class="nav-link">Lesblokken</a>
                                </li>
                                <li class="nav-item">
                                    <a href="vehicles.php" class="nav-link">Wagenpark</a>
                                </li>
                                <?php
                            }
                        //if userrole is student
                        }else if($_SESSION['userRole'] == "student"){
                            ?>

                            <!-- navigation items for students go here -->

                            <?php
                        }
                    }
                    ?>
                    <li class="nav-item">
                        <a href="contact.php" class="nav-link">Contact</a>
                    </li>
                    <li class="nav-item">
                        <form method="post">
                            <button type="submit" name="logout" class="btn btn-sm btn-link nav-link">Log uit</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>