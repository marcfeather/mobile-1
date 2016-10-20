<?php
	include_once '../controllers/common_functions.php';
	include_once '../model/db.php';
	include_once '../controllers/process_message.php';
	// echo "<pre>";
	// print_r($_SESSION['numbers']);
	// print_r($_POST);
	$message = $_POST['bulk_message'];
	$numbers = $_SESSION['numbers'];
	$count = $_SESSION['user_details']['sms_count'];
	// print_r($numbers);
	// print_r(count($numbers));
	// print_r($count);
	if ($count >= count($numbers)) {
		$i = 0;
		foreach ($numbers as  $value) {
			$raw_values['message'] = $message;
			$raw_values['mobile_numbers'] = $value;
			$raw_values['unicode'] = $_POST['bulk_unicode'];
			$raw_values['user_id'] = $_SESSION['user_details']['id'];
			$raw_values['sender_id'] = $_POST['bulk_sender_id'];
			process_all_values($raw_values);
			$i++;
		}
		unset($_SESSION['numbers']);
		echo "SMS sent successfully";
	}
	else{
		echo "Recharge your account";
	}

	// print_r($test_msg);
 ?>