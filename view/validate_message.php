<?php
	include_once '../controllers/common_functions.php';
	include_once '../model/db.php';
	include_once '../controllers/view_controller.php';
	landing_page_session_check();
	$user_details = $_SESSION['user_details'];
?>
<html>
<head>
	<title>Validate Message</title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="http://code.jquery.com/jquery-1.5.js"></script>
	<script src="../js/jquery-2.2.3.min.js"></script>
	<?php include_once 'text_view_count.php'; 
	$user_details = $_SESSION['user_details'];
	if(!empty($_GET['file_name'])){
		$file_path = "../files/".$user_details['email_id']."/".$_GET['file_name'];
		$final_excel_data = get_excel_data($file_path);
	}
	if (!isset($final_excel_data)) {
		echo "<div class='alert alert-danger'><strong>Please select a row for message ! </strong>no data</div>";
	}
	else{	
	$headers = $final_excel_data[0];
	unset($final_excel_data[0]);
	$_SESSION['headers'] = $headers;
	$raw_data = $final_excel_data;
	// print_r($raw_data);
	// print_r($headers);
	$j = 0;
	$count = count($headers)-1;
	$headers[$count] = "number";
	foreach ($raw_data as $value) {
		// $final_values = explode('|', $value);
		for ($i=0; $i < count($value); $i++) { 
			$final_data[$j][$headers[$i]] = $value[$i];
		}
		$j++;
	}
	// print_r($final_data);
	$count_final_data = count($final_data)-1;
	// print_r($count_final_data);
	$_SESSION['bulk_data'] = $final_data;
	?>
</head>
<body>
<table class="table">
	<td><a href="../index.php" class="btn btn-info" style="width: 100%">HOME</a></td>
	<td><a href="logout.php" class="btn btn-danger" style="width: 100%">Sign Out</a></td>
</table>
<div>
	<h1>Enter Your Message</h1>
	<hr style="border-top: 1px solid #191616">
</div>
<div class="container">
	<form>
					<p>Sender ID :- </p>
					<select class="form-control" id="bulk_sender_id">
						<?php
							if(is__array($user_details['sender_id'])){
								foreach ($user_details['sender_id'] as $key => $sender_id) {
									echo "<option>".$sender_id."</option>";
								} 
							}else{
								echo "<option>".$user_details['sender_id']."</option>";
							}
						 ?>
					</select><hr>
					<p>Templates :-</p>
					<select class="form-control">
						<?php 
						$conn = db_connect();
						$condition = "`user_id` =".$user_details['id']."";
						$template = select('`template_content`','`template`',$condition,$conn);
						// print_r($template);
						if ($template == "empty") {
							echo "<option><div class='form-group'><a href='template.php' class='input-group'>No Templates Present, Click to add</a></div></option>";
						}else{
							foreach ($template as  $value) {
								echo "<option><div class='form-group'><a class='input-group'>".$value['template_content']."</a></div></option>";
							} 
						}
					?>
					</select>
					<hr>
				<p>Enter Message :- </p>
				<textarea class="form-control" rows="5" id="bulk_message" name="message" onkeyup="countChar(this)" required></textarea>
				<div id="bulk_charNum">Number of SMS will Send = 1 (0)</div>
				<hr>
				<div>Use
				<?php

				foreach ($_SESSION['headers'] as $value) {
				 	echo "<b>#".$value."#</b> , ";
				 } 
				 ?> For Dynamic value representation.
				</div>
				<hr>
				<label><input type="checkbox" id="bulk_unicode" name="unicode"> Unicode</label>
				
				<hr>	<button type="button" class="btn btn-primary" id="show_schedule" style="width: 208px;">Schedule</button><hr>
				<div id="schedule">
					<input type="date" name="date" class="form-control" placeholder="Date" id="date" >
					<br/>
					<input type="time" name="time" class="form-control" placeholder="Time" id="time" >
					<br/>
					<div id="notifier"></div>
					<button type="submit" class="btn btn-success" id="schedule_sms" style="width: 208px;">Schedule Sms</button>
				</div>
				<button type="submit" class="btn btn-success" id="send_bulk_sms" style="width: 208px;">Send SMS</button>
	</form>
	</div>
</div>
<hr>
<div class="col-md-6" id="response"></div>
<?php
}
?>
</body>
</html> 
