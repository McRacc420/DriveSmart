<?php

	//include header
	include_once('header.php');

	//return to home if access not permitted
	if (!isset($_SESSION['userRole']) || $_SESSION['userRole'] != "instructor"){
        header('location: home.php');
    }

    include_once('Objects/Crud.php');

	//variables to hold the previously submitted values with post
	$instructorSelectValue = isset($_POST['instructor-select']) ? $_POST['instructor-select'] : '';
	$dateSelectValue = isset($_POST['date-select']) ? $_POST['date-select'] : '';
	$viewSelectValue = isset($_POST['view-select']) ? $_POST['view-select'] : '';

?>

<div class="container">
	<h2 class="page-header mt-3 mb-3">Beschikbaarheidsoverzicht</h2>
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
            <!-- start of instructorAvailablity form, which sends the user to instructorAvailablity.php on submission with the post method -->
			<form action="instructorAvailablity.php" method="post">		

                <!-- instructor -->
                <div class="row mt-3">
					<div class="col-lg-4">
						<label class="control-label" style="position:relative; top:7px;">Instructeur:</label>
					</div>
					<div class="col-lg-8">
						<select name="instructor-select" class="form-control" required>
							<?php
							
                                //create new instance of crud
                                $crud = new Crud();

                                //select all instrcutors not archived
								$sql = "SELECT * FROM instructor WHERE archived = 0";

                                //store execution result
								$result = $crud->read($sql);

                                //display the result rows in select dropdown options, with the id stored as value
								foreach($result as $row){
                                    //display the previusly submitted option by default
									$selected = ($row['id'] == $instructorSelectValue) ? 'selected' : '';
                                    echo "<option value='" . $row['id'] . "' $selected>" . $row['first_name'] . " " . $row['last_name'] . "</option>";
								}
								
							?>
						</select>
					</div>
				</div>

                <!-- date -->
                <div class="row mt-3">
					<div class="col-lg-4">
						<label class="control-label" style="position:relative; top:7px;">Datum:</label>
					</div>
					<div class="col-lg-8">
						<input class="form-control" type="date" name="date-select" value="<?php echo $dateSelectValue; ?>" required>
					</div>
				</div>

                <!-- view -->
                <div class="row mt-3">
					<div class="col-lg-4">
						<label class="control-label" style="position:relative; top:7px;">Weergave:</label>
					</div>
					<div class="col-lg-8">
						<select name="view-select" class="form-control" required>
							<option value="day" <?php echo ($viewSelectValue == 'day') ? 'selected' : ''; ?>>Dag</option>
                            <option value="week" <?php echo ($viewSelectValue == 'week') ? 'selected' : ''; ?>>Week</option>
						</select>
					</div>
				</div>
            <!-- submit button-->
			<button type="submit" class="btn btn-sm btn-primary mt-3">Filter</button>
			</form>
            <?php

                // translating daynames to dutch
                $weekdays = array(
                    'Monday' => 'Maandag',
                    'Tuesday' => 'Dinsdag',
                    'Wednesday' => 'Woensdag',
                    'Thursday' => 'Donderdag',
                    'Friday' => 'Vrijdag',
                    'Saturday' => 'Zaterdag',
                    'Sunday' => 'Zondag'
                );

                // translating months to dutch
                $months = array(
                    'January' => 'januari',
                    'February' => 'februari',
                    'March' => 'maart',
                    'April' => 'april',
                    'May' => 'mei',
                    'June' => 'juni',
                    'July' => 'juli',
                    'August' => 'augustus',
                    'September' => 'september',
                    'October' => 'oktober',
                    'November' => 'november',
                    'December' => 'december'
                );

                //if all submission fields have been set
                if(isset($_POST['instructor-select']) && isset($_POST['view-select']) && isset($_POST['date-select'])){

                    //create new instance of crud
                    $crud = new Crud();

                    //store data from form submission, use the escapeString method to prevent sql injections
                    $instructorId = $crud->escapeString($_POST['instructor-select']);
                    $selectedDate = $crud->escapeString($_POST['date-select']);
                    $viewType = $crud->escapeString($_POST['view-select']);

                    //if viewtype is day
                    if($viewType == "day"){

                        //display a single table for the selected day
                        $sql = "SELECT lessonblock.*, instructor.first_name, instructor.last_name
                                FROM (lessonblock
                                INNER JOIN instructor ON lessonblock.instructor_id = instructor.id)
                                WHERE instructor_id = '$instructorId' AND date = '$selectedDate'";
                        
                        echo "<h4 class='mt-3'>" . translateDate($selectedDate) . "</h4>";
                        displayLessonBlockTable($crud->read($sql));

                    //if viewtype is week
                    }elseif($viewType == "week"){

                        //calculate the start and end dates for the week
                        $startOfWeek = date('Y-m-d', strtotime('monday this week', strtotime($selectedDate)));
                        $endOfWeek = date('Y-m-d', strtotime('sunday this week', strtotime($selectedDate)));

                        //loop throguh all the weekdays and display the lessonblocks per day
                        $currentDate = $startOfWeek;
                        while($currentDate <= $endOfWeek){
                            $sql = "SELECT lessonblock.*, instructor.first_name, instructor.last_name
                                    FROM (lessonblock
                                    INNER JOIN instructor ON lessonblock.instructor_id = instructor.id)
                                    WHERE instructor_id = '$instructorId' AND date = '$currentDate'";
                            
                            //display a table for each day
                            echo "<h4 class='mt-3'>" . translateDate($currentDate) . "</h4>";
                            displayLessonBlockTable($crud->read($sql));

                            //go to next day
                            $currentDate = date('Y-m-d', strtotime($currentDate . ' + 1 day'));
                        }
                    }
                }

                //function that translates our dates
                function translateDate($date) {
                    global $weekdays, $months;
                    $day = date('l', strtotime($date));
                    $month = date('F', strtotime($date));
                    return $weekdays[$day] . ' ' . date('j', strtotime($date)) . ' ' . $months[$month] . ' ' . date('Y', strtotime($date));
                }

                //function that displays the lessonblocktable
                function displayLessonBlockTable($result){
                    ?>
                    <table class="table table-bordered table-striped mt-3 table-overflow">
                        <thead>
                            <tr>
                                <th>Instructeur</th>
                                <th>Datum</th>
                                <th>Begintijd</th>
                                <th>Beschikbaarheid</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // for every case, create a row with the respective data
                            foreach ($result as $key => $row) {
                                ?>
                                <tr>
                                    <td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
                                    <td><?php echo $row['date']; ?></td>
                                    <td><?php echo $row['timeblock']; ?></td>
                                    <td><?php 
                                        //if there is NO student assigned to the lessonblock
                                        if($row['student_id'] == NULL){
                                            echo "Beschikbaar";

                                        //if there is a student assigned to the lessonblock
                                        }else{
                                            echo "Bezet";
                                        }

                                    ?></td>
                                </tr>
                                <?php     
                            }
                            ?>
                        </tbody>
                    </table>
                <?php
            }
			?>
		</div>
	</div>
</div>
<?php 

//include footer
include_once('footer.php');

?>
