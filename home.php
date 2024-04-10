<?php

	// include header
	include_once('header.php');

?>

<div class="container">
	<?php 

	//if userrole is set
	if(isset($_SESSION['userRole'])){
		//if user is instructor
		if($_SESSION['userRole'] == "instructor"){
			echo "<h3 class='page-header text-center mt-3'>Welkom, " . $row['first_name'] . " " . $row['last_name'] . "</h3>";
			//if instructor is admin
			if($row['is_admin'] == true){
				echo "<h6 class='page-header text-center mt-3'>Je bent ingelogd als instructeur met adminrechten.</h6>";
			}else{
				echo "<h6 class='page-header text-center mt-3'>Je bent ingelogd als instructeur.</h6>";
			}
		//if user is student
		}else if($_SESSION['userRole'] == "student"){
			echo "<h3 class='page-header text-center mt-3'>Welkom, " . $row['name'] . "</h3>";
			echo "<h6 class='page-header text-center mt-3'>Je bent ingelogd als student.</h6>";
		}
	}

	// include footer
	include_once('footer.php');

	?>
	