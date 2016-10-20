<?php 
	session_start();
	function send_message($sender_id, $phone_number, $message_content, $unicode){
		$conn = sms_db_connect($unicode);
		$sql = "INSERT INTO `MessageOut` (`MessageFrom`, `MessageTo` , `MessageText`) VALUES ('$sender_id', '$phone_number', '$message_content')";
		// echo $sql;
		mysqli_set_charset($conn, 'utf8mb4'); 
		if(execute_query($sql, $conn)){
			// echo "SMS Sent";
		}else{
			echo "not sent";
		}
	}

	function create_folder($folder_name){
		$path = "../../files/$folder_name";
		if (!mkdir($path, 777, true)) {
			header('location: ../view/404.php?status=folder_not_created');
		}else{
			echo "folder created!";
		}
	}

	function is__array($value){
		return is_array($value);
	}

	function emptty($value){
		return empty($value);
	}

		

	function landing_page_session_check(){
		if(!isset($_SESSION["user_details"]) || empty($_SESSION["user_details"])){
			header('location:login.php');
		}
	}

	function login_page_session_check(){
		if(isset($_SESSION["user_details"])){
			header('location:home.php');
		}
	}

	function log_out(){
		session_destroy();   
	}
	function delete_file($path){
		if (!unlink($path))
		{
		  echo ("Error deleting $path");
		}
		else
		{
		  // echo ("Deleted $path");
		}
	}