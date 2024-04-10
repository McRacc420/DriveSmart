<?php

	// include header
	include_once('header.php');

	//return to home if access not permitted
	if (!isset($_SESSION['userRole']) || $_SESSION['userRole'] != "instructor"){
        header('location: home.php');
    }

	//include crud class
	include_once('Objects/Crud.php');

	//variables to hold the previously submitted values with post
	$startDateValue = isset($_POST['start-date']) ? $_POST['start-date'] : '';
	$endDateValue = isset($_POST['end-date']) ? $_POST['end-date'] : '';

	//if licence is passed though either get or post
	if(isset($_GET['license']) || isset($_POST['license'])){

		//create new instance of crud
		$crud = new Crud();

		//license is passed through get
		if(isset($_GET['license'])){

			//store license
			$license = $_GET['license'];
	
			//fetch data
			$sql = "SELECT vehicle.*, lessonblock.date, lessonblock.timeblock, instructor.first_name, instructor.last_name
			FROM ((vehicle
			INNER JOIN lessonblock ON vehicle.license = lessonblock.vehicle_license)
			INNER JOIN instructor ON lessonblock.instructor_id = instructor.id)
			WHERE vehicle.license = '$license' AND vehicle.archived = 0";
	
		}else if(isset($_POST['license'])){
	
    		//store data from form submission, use the escapeString method to prevent sql injections
			$license = $crud->escapeString($_POST['license']);
			$startDate = $crud->escapeString($_POST['start-date']);
			$endDate = $crud->escapeString($_POST['end-date']);
	
			//fetch data
			$sql = "SELECT vehicle.*, lessonblock.date, lessonblock.timeblock, instructor.first_name, instructor.last_name
			FROM ((vehicle
			INNER JOIN lessonblock ON vehicle.license = lessonblock.vehicle_license)
			INNER JOIN instructor ON lessonblock.instructor_id = instructor.id)
			WHERE vehicle.license = '$license' AND lessonblock.date between '$startDate' and '$endDate' AND vehicle.archived = 0";
	
		}

		$result = $crud->read($sql);

	}

?>

<div class="container">
	<h2 class="page-header mt-3 mb-3">Wagengebruik</h2>
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
			<?php
				if(isset($_SESSION['message'])){
					?>
						<div class="alert alert-info text-center">
							<?php echo $_SESSION['message']; ?>
						</div>
					<?php

					unset($_SESSION['message']);
				}
			
			?>
			<form action="vehicleUsage.php" method="post">
				<input type="text" name="license" value="<?php echo $license; ?>" hidden required>
				<div class="row mt-3">
					<div class="col-lg-4">
						Startdatum
						<input class="form-control" type="date" name="start-date" value="<?php echo $startDateValue ;?>">
					</div>t/m
					<div class="col-lg-4">
						Einddatum
						<input class="form-control" type="date" name="end-date" value="<?php echo $endDateValue ;?>">
					</div>
				</div>
			<button type="submit" class="btn btn-sm btn-primary mt-3">Filter</button>
			</form>
			<table class="table table-bordered table-striped mt-3 table-overflow">
				<thead>
					<tr>
						<th>Wagen</th>
						<th>Datum</th>
						<th>Begintijd</th>
						<th>Instructeur</th>
					</tr>
				</thead>
				<tbody>
					<?php
					// for each row of data, create the fronted rows and fill with data
						foreach ($result as $key => $row) {
							?>
							<tr>
								<td><?php echo $row['brand'] . " " . $row['type'] . " (" . $row['license'] . ")"; ?></td>
								<td><?php echo $row['date']; ?></td>
								<td><?php echo $row['timeblock']; ?></td>
								<td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
							</tr>
							<?php     
					    }
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php 

//include footer
include_once('footer.php');

?>
