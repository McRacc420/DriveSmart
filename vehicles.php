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

	//fetch data, all vehicles not archived
	$sql = "SELECT * FROM vehicle WHERE archived = 0";
	$result = $crud->read($sql);
?>

<div class="container">
	<h2 class="page-header mt-3 mb-3">Wagenpark</h2>
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
						<th>Kenteken</th>
						<th>Merk</th>
						<th>Model</th>
						<th>Brandstof</th>
						<th>Cruise Control</th>
					</tr>
				</thead>
				<tbody>
					<?php
						//for each case, create a row with the relevant data
						foreach ($result as $key => $row) {
							?>
							<tr>
								<td><?php echo $row['license']; ?></td>
								<td><?php echo $row['brand']; ?></td>
								<td><?php echo $row['type']; ?></td>
								<td><?php echo $row['fuel']; ?></td>
								<td>
									<?php 
										if($row['has_cruise_control'] == true){
											echo "Ja";
										}else{
											echo "Nee";
										}
									?>
								</td>
								<td>
									<a href="vehicleUsage.php?license=<?php echo $row['license']; ?>" class="btn btn-sm btn-secondary mb-3">Wagengebruik</a>
									<button type="button" class="btn btn-sm btn-warning mb-3" data-bs-toggle="modal" data-bs-target="#edit<?php echo $row['license']; ?>">Wijzigen</button>
									<button type="button" class="btn btn-sm btn-danger mb-3" data-bs-toggle="modal" data-bs-target="#delete<?php echo $row['license']; ?>">Verwijderen</button>


								</td>
								<?php include('vehicle/actionModal.php'); ?>
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
include("vehicle/addModal.php");

//include footer
include_once('footer.php');

?>
