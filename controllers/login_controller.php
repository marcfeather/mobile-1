<?php 
	include_once 'common_functions.php';
	include_once '../model/db.php';

	
	$con = db_connect();
	$email = sanitize($_POST['email'], $con);
	$password = sanitize($_POST['password'], $con);
	$raw_data = get_raw_data($email, $password, $con);
	if($raw_data!="empty"){
		// print_r($raw_data);
		create_session($raw_data);
		header('Location: ../view/view.php');
	}else{
		echo "no data";
		// header('Location: ../view/login.php?type=login_error');
	}

	
	function get_raw_data($email, $password, $con){
		$selected_row = select('*', 'users', array("email_id"=>$email, "password"=>$password), $con);
		return $selected_row;
	}

	function create_session($data){
		session_start();
		$user_details = $data['0'];
		$_SESSION["user_details"] = $user_details;
		$_SESSION['check_value'] = 1;
		if(isset($_SESSION['user_details'])){
			return true;
		}
		return false;
	}

