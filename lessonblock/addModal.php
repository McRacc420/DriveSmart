<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Lesblok toevoegen</h4>
            </div>
            <div class="modal-body">
				<div class="container-fluid">

				<!-- start of 'addlessonblockform', which sends the user to lessonblock/add.php on submission with the post method -->
				<form id="addlessonblockForm" action="lessonblock/add.php" method="post">

					<!-- date -->
					<div class="row mt-3">
						<div class="col-lg-4">
							<label class="control-label" style="position:relative; top:7px;">Datum:</label>
						</div>
						<div class="col-lg-8">
							<input type="date" class="form-control" name="date" required>
						</div>
					</div>

					<!-- time -->
					<div class="row mt-3">
						<div class="col-lg-4">
							<label class="control-label" style="position:relative; top:7px;">Begintijd: (uren)</label>
						</div>
						<div class="col-lg-8">
							<input type="time" class="form-control" name="time" required>
						</div>
						<div class="col-lg-6 mt-2">
							: 00
						</div>
					</div>

					<!-- instructor -->
					<div class="row mt-3">
						<div class="col-lg-4">
							<label class="control-label" style="position:relative; top:7px; width:10px;">Instructeur:</label>
						</div>
						<div class="col-lg-8">
							<select name="instructor-select" class="form-control" required>
								<?php
								
									//create new instance of crud
									$crud = new Crud();

									//select all intructors that are NOT archived
									$sql = "SELECT * FROM instructor WHERE archived = 0";

									//store execution result
									$result = $crud->read($sql);

									//display the result rows in select dropdown options, with the id stored as value
									foreach($result as $row){
										echo "<option value='" . $row['id'] . "'>" . $row['first_name'] . " " . $row['last_name'] . "</option>";
									}
									
								?>
							</select>
						</div>
					</div>

					<!-- vehicle -->
					<div class="row mt-3">
						<div class="col-lg-4">
							<label class="control-label" style="position:relative; top:7px;">Wagen:</label>
						</div>
						<div class="col-lg-8">
						<select name="vehicle-select" class="form-control">
								<?php
								
								//create new instance of crud
								$crud = new Crud();

								//select all vehicles that are NOT archived
								$sql = "SELECT * FROM vehicle WHERE archived = 0";

								//execute
								$result = $crud->read($sql);

								//display the result rows in select dropdown options, with the license stored as value
								foreach($result as $row){
									echo "<option value='" . $row['license'] . "'>" . $row['brand'] . " " . $row['type'] . " (" . $row['license'] . ")" . "</option>";

								}
								
								?>
							</select>
						</div>
					</div>
				</div> 
			</div>
            <div class="modal-footer">
				<!--cancel button -->
                <button type="button" class="btn btn-sm btn-default" data-bs-dismiss="modal">Annuleren</button>
				<!--submit button to submit form -->
                <button type="submit" name="add" class="btn btn-sm btn-primary">Opslaan</button>
			</form>
            </div>
			
        </div>
    </div>
</div>