
<?php
	//start session
	session_start();

	//redirect if logged in.
	if(isset($_SESSION['userId'])){
		header('location:home.php');
	}

?>
<!DOCTYPE html>
<html>
<head>

	<title>Autorijschool DriveSmart</title>
  
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <!-- latest Bootstrap CSS version 5.3.3 as of 08/04/24 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

   <!-- latest Bootstrap Icons version 1.11.3 as of 08/04/24 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- our custom CSS -->
    <link rel="stylesheet" href="assets/styles.css" />

</head>
<body>
<div class="drivesmart-header"></div>
<div class="container mt-5">
	<h2 class="page-header text-center">Autorijschool DriveSmart</h2>
	<div class="row">
		<div class="col-md-3 col-md-offset-4 col-center mt-5">
		    <div class="login-panel panel panel-primary">
		        <div class="panel-heading">
		            <h4 class="panel-title">Inloggen</h4>
		        </div>
		    	<div class="panel-body">
		        	<form method="POST" action="login.php">
		            	<fieldset>
		                	<div class="form-group">
		                    	<input class="form-control" placeholder="E-mailadres" type="text" name="email" autofocus required>
		                	</div>
		                	<div class="form-group">
		                    	<input class="form-control" placeholder="Wachtwoord" type="password" name="password" required>
		                	</div>
		                	<button type="submit" name="login" class="btn btn-sm btn-primary mt-3"><span class="glyphicon glyphicon-log-in"></span> Log in</button>
		            	</fieldset>
		        	</form>
		    	</div>
		    </div>
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
		</div>
	</div>
</div>

<!-- latest ajax jquery version 3.1.0 as of 08/04/24 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

<!-- latest Bootstrap js version 5.3.3 as of 08/04/24 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>