<?php

	// include header
	include_once('header.php');

	//return to home if access not permitted
	if (!isset($_SESSION['userRole']) || $_SESSION['userRole'] != "instructor"){
        header('location: home.php');
    }

	//include crud class
	include_once('Objects/Crud.php');

	//new instance of crud
	$crud = new Crud();

	//fetch data
	$sql = "SELECT lessonblock.*, 
                instructor.id AS instructor_id, 
                instructor.first_name AS instructor_firstname, 
                instructor.last_name AS instructor_lastname,
                vehicle.license AS vehicle_license,
                vehicle.brand AS vehicle_brand,
                vehicle.type AS vehicle_type,
                student.id AS student_id,
                student.name AS student_name
        FROM (((lessonblock
        INNER JOIN instructor ON lessonblock.instructor_id = instructor.id)
        LEFT JOIN student ON lessonblock.student_id = student.id)
        INNER JOIN vehicle ON lessonblock.vehicle_license = vehicle.license);
";
	//store result
	$result = $crud->read($sql);
?>

<div class="container">
	<h2 class="page-header mt-3 mb-3">Lesblokken</h2>
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
			<button type="button" class="btn btn-sm btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#add">Toevoegen</button>
			<table class="table table-bordered table-striped table-overflow">
				<thead>
					<tr>
                        <th>Datum</th>
						<th>Begintijd</th>
						<th>Instructeur</th>
						<th>Wagen</th>
                        <th>Kenteken</th>
						<th>Leerling</th>
                        <th>Verslag</th>
					</tr>
				</thead>
				<tbody>
					<?php
					// FOR every case, create a row with data
						foreach ($result as $key => $row) {
							?>
							<tr>
                                <td><?php echo $row['date']; ?></td>
								<td><?php echo $row['timeblock']; ?></td>
								<td><?php echo $row['instructor_firstname'] . " " . $row['instructor_lastname']; ?></td>
								<td><?php echo $row['vehicle_brand'] . " " . $row['vehicle_type']; ?></td>
                                <td><?php echo $row['vehicle_license']; ?></td>
                                <td><?php if(isset($row['student_name'])){ echo $row['student_name']; }?></td>
                                <td><?php echo $row['report']; ?></td>
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

//include add modal
include("lessonblock/addModal.php");

//include footer.php
include_once('footer.php');

?>
