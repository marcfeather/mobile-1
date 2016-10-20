<?php
	include_once '../controllers/common_functions.php';
	include_once '../model/db.php';

?>
<html>
<head>
	<title>Validate Message</title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="http://code.jquery.com/jquery-1.5.js"></script>
	<script src="../js/jquery-2.2.3.min.js"></script>
	<?php include_once 'text_view_count.php'; ?>
</head>
<body>
<?php 
// print_r($_POST['user_data']);
	 if (!isset($_POST['user_data'])) {
		echo "<div class='alert alert-danger'><strong>Please select a row for message ! </strong>no data</div>";
	}
	else{
	$_SESSION['numbers']= $_POST['user_data']; 
	// print_r($_SESSION);
?>


<div>
	<h1>Enter Your Message</h1>
	<hr style="border-top: 1px solid #191616">
</div>
<form>
	<table class="table">
		<tr>
			<td>
				<p>Sender ID : </p>
			</td>
			<td>
				<select class="form-control" id="bulk_sender_id">
					<?php 
						if(is__array($_SESSION['user_details']['sender_id'])){
							foreach ($_SESSION['user_details']['sender_id'] as $key => $sender_id) {
								echo $sender_id;
							} 
						}else{
							echo "<option>".$_SESSION['user_details']['sender_id']."</option>";
						}
					 ?>
				</select>
			</td>
		</tr>
		<tr>
			<td>
			<p>Enter Message : </p>
			</td>
			<td>
			<textarea class="form-control" rows="5" id="bulk_message" name="message" onkeypress="countChar(this)" onmousedown="countChar(this)" required></textarea>
				<div id="bulk_charNum">Number of SMS will Send = 1 (0)</div>
				</td>
		</tr>
		<tr>
			<td>
			</td>
			<td>
			<label><input type="checkbox" id="bulk_unicode" name="unicode"> Unicode</label>
			</td>
		</tr>
			<tr>
			<td>
			</td>
			<td>
			<button type="submit" class="btn btn-success" id="send_bulk_sms" style="width: 208px;">Send SMS</button>
			</td>
		</tr>
	</table>
</form>
<div id="response"></div>
<?php
}?>
</body>
</html> 
