<?php
	include_once '../controllers/common_functions.php';
	include_once '../model/db.php';
	landing_page_session_check();
	$user_id=$_SESSION['user_details']['id'];
	$conn = db_connect();
	$condition = "(`user_id`=".$user_id.") ";
	$result = select('*','`files`',$condition,$conn);
	if (isset($_GET['status'])) {
		if ($_GET['status'] == "queued") {
			echo "<div class='alert alert-success'><strong>Success!</strong> Indicates a successful or positive action.</div";
		}else{
			if ($_GET['status'] == "error") {
				echo "<div class='alert alert-danger'><strong>Sorry!</strong> set last fiels as integer</div";
			}else{
			if ($_GET['status'] == "file_exists") {
				echo "<div class='alert alert-danger'><strong>Sorry!</strong> File already exists</div";
			}
			}
		}
	}

	if($result == "empty"){
		echo "no data found";
	}else{
		foreach ($result as $value) {
			$file_name[] = $value['file_name'];
		}
	?>
	<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
	<div class="pull-right" style="padding-right: 1em;"> 
	<a href="logout.php" class="btn btn-danger">Sign Out</a>
	</div>
	<div>
	<h1 style="text-align: center">Uploaded Files</h1> 
	</div>
	<hr>
	<div>
		<h1>&#160;&#160;&#160;	Welcome <?php print_r($_SESSION['user_details']['user_name']) ?></h1>
	</div>
	<div style="text-align:center;">
	<?php  
		foreach ($result as $value) {
				echo "<h1><a href='validate_message.php?file_name=".$value['file_name']."'>".$value['file_name']."</a></h1>";
		}

	?>
	</div>
	<?php 	} ?>
	