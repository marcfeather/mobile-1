<script type="text/javascript">

	function countChar(val) {
		len = val.value.length;
		if (isDoubleByte(val.value)) {
			$('#bulk_unicode').attr('checked', true);
		}
		if(document.getElementById('bulk_unicode').checked) {
			if (len <= 536) {
				<?php get_check_code("unicode"); ?>
			}else{
				document.getElementById('response').innerHTML = "<div class='alert alert-danger'><strong>Oops!</strong>not able to send message due to over content</div>";
			}
		}else{
			if (len <= 1224) {
				<?php get_check_code("normal"); ?>
			}else{
				document.getElementById('response').innerHTML = "<div class='alert alert-danger'><strong>Oops!</strong>not able to send message due to over content</div>";
			}
		}
	}
	function isDoubleByte(str) {
		for (var i = 0, n = str.length; i < n; i++) {
			if (str.charCodeAt( i ) > 255) { 
				return true; 
			}
		}
		return false;
	}
$(document).ready(function() {
$('#schedule').hide();
	$('body').on('click', "#bulk_unicode", function(){
		len = $("#bulk_message").val().length;
		message = $("#bulk_message").val();
		if (isDoubleByte(message)) {
			$('#bulk_unicode').prop('checked', true);
		}
		if(document.getElementById('bulk_unicode').checked) {
			if (len <= 536) {
				<?php get_check_code("unicode"); ?>
			}else{
				document.getElementById('response').innerHTML = "<div class='alert alert-danger'><strong>Oops!</strong>not able to send message due to over content</div>";
			}
		}else{
			if (len <= 1224) {
				<?php get_check_code("normal"); ?>
			}else{
				document.getElementById('response').innerHTML = "<div class='alert alert-danger'><strong>Oops!</strong>not able to send message due to over content</div>";
			}
		}
	});

		$('.box-body > div > a').on('click', function() {
			var data = this.innerHTML;
			// console.log(data);
			document.getElementById('bulk_message').value = data;
		});
		$('body').on('click', "#show_schedule", function(){
			$('#schedule').toggle();
			$('#send_bulk_sms').toggle();
		});

	$('body').on('click', "#schedule_sms", function(e){
		var date = $("#date").val();
		var time = $("#time").val();
		date_time = date+" "+time;
		// console.log(date_time);
		$("form").submit(function(e){
			e.preventDefault();
			bulk_sender_id = document.getElementById('bulk_sender_id').value;
			bulk_message = document.getElementById('bulk_message').value;
			if(document.getElementById('bulk_unicode').checked) {
				bulk_unicode = "checked";
			} else {
				bulk_unicode = "not_checked";
			}
				document.getElementById('response').innerHTML = "<div class='alert alert-success'><strong>Please</strong>Wait a moment we are processing your messages</div>"; 
				$('#schedule_sms').attr("disabled", true);
				// window.open("http://sms2.vefetch.com/");
			$.ajax({
				type: "POST",
				url: "send_text_view.php",
				data: {bulk_sender_id : bulk_sender_id, bulk_message : bulk_message, bulk_unicode : bulk_unicode, date_time :date_time},
				success: function(data) {  
					// console.log(data); 
					document.getElementById('response').innerHTML = "<div class='alert alert-warning'><strong>Hey!</strong>"+data+" hope it is positive or contact support</div>";          
				}
			});
		});
		document.getElementById('response').innerHTML = "<div class='alert alert-danger'><strong>Please</strong>Wait a moment we are processing your messages</div>"; 
	});
	$('body').on('click', "#send_bulk_sms", function(){
		$("form").submit(function(e){
			e.preventDefault();
			bulk_sender_id = document.getElementById('bulk_sender_id').value;
			bulk_message = document.getElementById('bulk_message').value;
			if(document.getElementById('bulk_unicode').checked) {
				bulk_unicode = "checked";
			} else {
				bulk_unicode = "not_checked";
			}
			document.getElementById('response').innerHTML = "<div class='alert alert-success'><strong>Please</strong>Wait a moment we are processing your messages</div>"; 
			$('#send_bulk_sms').attr("disabled", true);
			window.open("http://sms2.vefetch.com/");
			$.ajax({
				type: "POST",
				url: "send_text_view.php",
				data: {bulk_sender_id : bulk_sender_id, bulk_message : bulk_message, bulk_unicode : bulk_unicode},
				success: function(data) {  
					// console.log(data); 
					document.getElementById('response').innerHTML = "<div class='alert alert-warning'><strong>Hey!</strong>"+data+" hope it is positive or contact support</div>";          
				}
			});
		});
			document.getElementById('response').innerHTML = "<div class='alert alert-danger'><strong>Please</strong>Wait a moment we are processing your messages</div>"; 
	});
});

	function isNumber(evt) {
		var theEvent = evt || window.event;
		var key = theEvent.keyCode || theEvent.which;
		key = String.fromCharCode(key);
		var regex = /^[0-9,]+$/;
		if (!regex.test(key)) {
			theEvent.returnValue = false;
		if (theEvent.preventDefault) theEvent.preventDefault();
		}
	}
	function isDoubleByte(str) {
		for (var i = 0, n = str.length; i < n; i++) {
			if (str.charCodeAt( i ) > 255) { 
				return true; 
			}
		}
		return false;
	}
	</script>
<?php 
	function get_check_code($for){
		include_once '../model/db.php';
		$conn = db_connect();
		if($for == "unicode"){
			$sql = "SELECT `$for` FROM `sms_count`";
		}else{
			$sql = "SELECT `$for` FROM `sms_count`";
		}
		$result = execute_query($sql, $conn);
		while($row = mysqli_fetch_array($result)) {
			$selected_rows[] = $row[$for];
		}
		
		$i = 1;
		$condition="";
		foreach ($selected_rows as $key => $value) {
			if($i == 1){
				$condition = $condition."if(len <".$value."){document.getElementById('bulk_charNum').innerHTML = 'Number of SMS will Send = ".$i." ('+ len + ')'; }";
			} else{
				$condition = $condition."else if(len <".$value."){document.getElementById('bulk_charNum').innerHTML = 'Number of SMS will Send = ".$i." ('+ len + ')'; }";
			}
			$i++;
		}
		echo $condition;
	}
?>