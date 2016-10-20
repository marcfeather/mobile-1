<?php
	include_once '../controllers/common_functions.php';
	include_once '../model/db.php';
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
	<div class="jumbotron text-center"><h3>Uploaded Files</h3></div>
	<div style="text-align:center;">
		<table class="table">
			<?php  
				foreach ($result as $value) {
					echo "<tr>";
						echo "<td>";
						echo "<a href='file_handle.php?file_name=".$value['file_name']."'>".$value['file_name']."</a>";
						echo "</td>";
						echo "<td>";
						echo "<a href='../view/delete_file.php?file_name=".$value['file_name']."'><button type='button' class='btn btn-danger' style='width:208px;'> Delete </button></a>";
						echo "</td>";
					echo "</tr>";
				}

			?>
		</table>
	</div>
	<?php 	} ?>
	