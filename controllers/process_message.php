<?php 
	function process_all_values($raw_values){
		// print_r($raw_values);
		$total_message_length=iconv_strlen($raw_values['message'] , "UTF-8");
		// print_r($raw_values);
		$message_count=get_message_count($total_message_length,$raw_values['unicode']);
		if($message_count!="empty"){
			// echo "processing ! ";
			$total_phone_numbers=explode(",", $raw_values['mobile_numbers']);
			$total_message_count=count_total_messages($total_phone_numbers,$message_count);
			if(empty($total_phone_numbers)){
				echo " make sure you enter correct phone numbers ";
			}else{
				$user_sms_count=get_user_sms_count($raw_values['user_id']);
				processing_sms($total_message_count,$user_sms_count,$raw_values,$total_phone_numbers);
			}
		}else{
			echo "not able to send message due to over content";
		}
	}

	function get_message_count($length,$unicode_value){
		if($unicode_value=="checked"){
			return check_message_count_exceeds(check_code("unicode",$length));
		}else { 
			return check_message_count_exceeds(check_code("normal",$length));
		}

	}
	
	function check_code($for,$len){
		$conn = db_connect();
		if($for == "unicode"){
			$sql = "SELECT `$for` FROM `sms_count`";
		}else{
			$sql = "SELECT `$for` FROM `sms_count`";
		}
		$result = execute_query($sql, $conn);
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$selected_rows[] = $row[$for];
		}
		$i = 1;
		foreach ($selected_rows as $key => $value) {
			if($len <= $value){
				return $i; 
			}
			$i++;
		}
	}

	function check_message_count_exceeds($value){
		if(empty($value)){
			return "empty";
		}else{
			return $value;
		}
	}

	function count_total_messages(&$phone_numbers,$message_count){
		// print_r($phone_numbers);
		$phone_numbers = unset_fake_numbers($phone_numbers);
		// print_r($phone_numbers);
		$count_phone_number=count($phone_numbers);
		$total_sms=$count_phone_number*$message_count;
		return $total_sms;
	}

	function unset_fake_numbers($numbers){
		$count = count($numbers);
		for ($i=0; $i < $count; $i++) { 
			if(strlen($numbers[$i]) == 10 && $numbers[$i] > 7000000000){
				continue;
			}else{
				unset($numbers[$i]);
				continue;
			}
		}
		return $numbers;
	}


	function get_user_sms_count($id){
		$where='`id`='.$id;
		$conn=db_connect();
		$sms=select('`sms_count`','`users`',$where,$conn);
		$user_sms=$sms[0]['sms_count'];
		return $user_sms;
	}

	function processing_sms($total_message_count,$user_sms_count,$raw_values, $phone_numbers){
		if($total_message_count<=$user_sms_count){
			// echo "sms is ready to send";
			$id = $raw_values['user_id'];
			update_user_sms_count($user_sms_count, $total_message_count, $id);
			// print_r($raw_values);
			foreach ($phone_numbers as $key => $number) {
				send_message($raw_values['sender_id'], $number, $raw_values['message'], $raw_values['unicode']);
			}

		}else{
			echo "Recharge your account";
		}
	}

	function update_user_sms_count($user_sms_count, $total_message_count, $id){
		$remaining_sms_count=$user_sms_count-$total_message_count;
		$where='`id`='.$id;
		$conn=db_connect();
		$update_sms_count=array("sms_count"=>$remaining_sms_count );
		update($update_sms_count,'`users`',$where,$conn);
	}