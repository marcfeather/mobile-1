<?php 
	
	include_once 'curd_operations.php';
	function db_connect(){
		$connection = mysqli_connect("localhost", "root", "", "sms_api");
		if (!$connection) {
			die("Connection failed: " . mysqli_connect_error());
			exit();
		}
		return $connection;
	}
	function sms_db_connect($unicode){
		if(!empty($unicode)){
			$conn = db_connect();
			$condition = " `id` = ".$_SESSION['user_details']['id']."" ;
			if ($unicode == 1 || $unicode == "checked") {
					$credentials = select('`sms_db_credentials_unicode`', '`users`', $condition, $conn);
					$seperated_credentials = explode('|', $credentials[0]['sms_db_credentials_unicode']);
					// print_r($seperated_credentials);
					$connection = mysqli_connect($seperated_credentials[0], $seperated_credentials[1], $seperated_credentials[2], $seperated_credentials[3], $seperated_credentials[4]);
					if (!$connection) {
					    die("Connection failed: " . mysqli_connect_error());
					    exit();
					}
			}else{
				if ($unicode == 0 || $unicode == "not_checked") {
					$credentials = select('`sms_db_credentials_normal`', '`users`', $condition, $conn);
					$seperated_credentials = explode('|', $credentials[0]['sms_db_credentials_normal']);
					// print_r($seperated_credentials);
					$connection = mysqli_connect($seperated_credentials[0], $seperated_credentials[1], $seperated_credentials[2], $seperated_credentials[3], $seperated_credentials[4]);
					if (!$connection) {
					    die("Connection failed: " . mysqli_connect_error());
					    exit();
					}
				}
			}
			return $connection;
		}else{
			$connection = mysqli_connect('10.0.2.1', "smpp", "smpp1234", "smpp", 3306);
			if (!$connection) {
			    die("Connection failed: " . mysqli_connect_error());
			    exit();
			}
			return $connection;
		}
	}

	function execute_query($query, $link){
		if(!empty($link)){
			return mysqli_query($link, $query);
		}else{
			return mysqli_query(db_connect(), $query);
		}
	}

	function get_array_from_object($result){
		return mysqli_fetch_array($result, MYSQLI_ASSOC);
	}

	function sanitize($input, $con){
		return mysqli_real_escape_string($con, $input);
	}
