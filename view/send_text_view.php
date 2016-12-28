<?php
	include_once '../controllers/common_functions.php';
	include_once '../model/db.php';
	include_once '../controllers/process_message.php';
	// echo "<pre>";
	// print_r($_SESSION['bulk_data']);
	// print_r($_POST);
	$message = $_POST['bulk_message'];
	$headers = $_SESSION['headers'];
	foreach ($headers as $value) {
		$modified_headers[] = "#".$value."#";
	}
	$date_time = (isset($_POST['date_time']) ? $_POST['date_time'] : NULL);
	$count = $_SESSION['user_details']['sms_count'];
	$bulk_data = $_SESSION['bulk_data'];
	if ($count >= count($_SESSION['bulk_data'])) {
		$i = 0;
		foreach ($bulk_data as  $value) {
			$raw_values['message'] = str_replace($modified_headers,$bulk_data[$i],$message);
			$raw_values['mobile_numbers'] = $bulk_data[$i]['number'];
			$raw_values['unicode'] = $_POST['bulk_unicode'];
			$raw_values['user_id'] = $_SESSION['user_details']['id'];
			$raw_values['sender_id'] = $_POST['bulk_sender_id'];
			$raw_values['date_time'] = $date_time;
			process_all_values($raw_values);
			$i++;
		}
		unset($_SESSION['bulk_data']);
		echo "SMS sent successfully";
	}else{
		echo "Recharge your account";
	}
	// print_r($test_msg);
 ?>