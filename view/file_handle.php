<?php 

	include_once '../controllers/view_controller.php';
	include_once '../controllers/common_functions.php';
	landing_page_session_check();
	$user_details = $_SESSION['user_details'];
	if(!empty($_GET['file_name'])){
		$file_path = "../files/".$user_details['email_id']."/".$_GET['file_name'];
		$final_excel_data = get_excel_data($file_path);
	}
	
?>
<!-- <html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<form action="validate_message.php" method="post">
<table class="table">
	<td><a href="../index.php" class="btn btn-info" style="width: 100%">HOME</a></td>
	<td><a href="logout.php" class="btn btn-danger" style="width: 100%">Sign Out</a></td>
</table>
<div>
	<input type="submit" id="next" value="Go" class="btn btn-primary" style="width: 100%">
</div>
 <div>
 <table class="table table-hover">
 	<thead> -->
 			<?php 
					$heading_val = "";
					foreach ($final_excel_data[0] as $key => $heading) {
						echo "<th class='col-md-2'>".$heading."</th>";
						if($heading_val==""){
							$heading_val = $heading;
						}else{
							$heading_val = $heading_val.'|'.$heading;
						}
					} 
					unset($final_excel_data[0]);
			?>
<!-- 				<th class="col-md-2"><input type="checkbox" id="checkAll" /> Check All</th>
	</thead>
	<input type="hidden" name="hidden_format_name" value="
	<!-- <?php //echo $heading_val; ?> -->
	">
	<tbody class="record_table"> -->
			<?php
					$td_values = "";
					$checkbox_value = "";
					foreach ($final_excel_data as $key => $excel_data_array) {
						foreach ($excel_data_array as $key => $value) {
							$td_values = $td_values."<td class='col-sm-3'>".$value."</td>";
							if($checkbox_value==""){
								$checkbox_value = $value;
							}else{
								$checkbox_value = $checkbox_value.'|'.$value;
							}
						}
						echo '<tr>'.$td_values.'<td><input type="checkbox" name="user_data[]" value="'.$checkbox_value.'"/></td></tr>';
						$td_values = "</form>";
						$checkbox_value = "";
					}
				?>
<!-- 	</tbody>
	</table>
	</div>
</form>

	<script type="text/javascript">
		$(document).ready(function() {
			$('.record_table tr').click(function(event) {
				if (event.target.type !== 'checkbox') {
					$(':checkbox', this).trigger('click');
				}
			});
			
			$('body').on('change', '#checkAll', function(){
				$("input:checkbox").prop('checked', $(this).prop("checked"));
			});
			$('body').on('click', "#next", function(){
				$('#form').submit();
			});
		});
	</script>
</body>
</html> -->