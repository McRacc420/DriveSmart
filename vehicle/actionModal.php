
<!-- delete modal-->
<div class="modal fade" id="delete<?php echo $row['license']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Wagen verwijderen</h4>
            </div>
            <div class="modal-body">
			<div class="container-fluid text-center">
				<h5>Weet je zeker dat je <br><b>"<?php echo $row['brand'] . " " . $row['type']  . " (" . $row['license'] . ")"?>"</b><br> wilt verwijderen?</h5>
            </div> 
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default" data-bs-dismiss="modal">Annuleren</button>
                <a href="vehicle/delete.php?license=<?php echo $row['license']; ?>" class="btn btn-sm btn-danger">Ja, verwijderen</a>
            </div>
        </div>
    </div>
</div>

<!-- edit modal-->
<div class="modal fade" id="edit<?php echo $row['license']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Wagen wijzigen</h4>
            </div>
            <div class="modal-body">
			<div class="container-fluid">
			<!-- start of vehicle edit form, which sends the user to vehicle/edit.php on submission with the post method -->
			<form action="vehicle/edit.php" method="post">

				<!--license-->
				<div class="row mt-3">
					<div class="col-lg-4">
						<label class="control-label" style="position:relative; top:7px;">Kenteken:</label>
					</div>
					<div class="col-lg-8">
					<input type="text" class="form-control" name='license' maxlength="6" value="<?php echo $row['license']; ?>" hidden required>
						<input type="text" class="form-control" maxlength="6" value="<?php echo $row['license']; ?>" disabled required>
					</div>
				</div>

				<!--brand-->
				<div class="row mt-3">
					<div class="col-lg-4">
						<label class="control-label" style="position:relative; top:7px;">Merk:</label>
					</div>
					<div class="col-lg-8">
						<input type="text" class="form-control" name="brand" maxlength="30" value="<?php echo $row['brand']; ?>" required>
					</div>
				</div>

				<!--type-->
				<div class="row mt-3">
					<div class="col-lg-4">
						<label class="control-label" style="position:relative; top:7px;">Model:</label>
					</div>
					<div class="col-lg-8">
						<input type="text" class="form-control" name="type" maxlength="50" value="<?php echo $row['type']; ?>" required>
					</div>
				</div>

				<!--fuel-->
				<div class="row mt-3">
					<div class="col-lg-4">
						<label class="control-label" style="position:relative; top:7px;">Brandstof:</label>
					</div>
					<div class="col-lg-8">
						<input type="text" class="form-control" name="fuel" maxlength="30" value="<?php echo $row['fuel']; ?>" required>
					</div>
				</div>

				<!--cruise control-->
				<div class="row mt-3">
					<div class="col-lg-4">
						<label class="control-label" style="position:relative; top:7px;">Cruise Control:</label>
					</div>
					<div class="col-lg-8">
						<input class="form-check-input" type="radio" name="cruisecontrol" value="true" id="radio-cruisecontrol-true" <?php if($row['has_cruise_control'] == 1){echo "checked";} ?> required>
						<label class="form-check-label" for="radio-cruisecontrol-true">Ja</label>
						<input class="form-check-input" type="radio" name="cruisecontrol" value="false" id="radio-cruisecontrol-false" <?php if($row['has_cruise_control'] == 0){echo "checked";} ?> required>
						<label class="form-check-label" for="radio-cruisecontrol-false">Nee</label>
					</div>
				</div>
            </div> 
			</div>
            <div class="modal-footer">
				<!--cancel button -->
                <button type="button" class="btn btn-sm btn-default" data-bs-dismiss="modal">Annuleren</button>
				<!--submit button to submit form -->
                <button type="submit" name="edit" class="btn btn-sm btn-primary">Opslaan</button>
			</form>
            </div>
			
        </div>
    </div>
</div>