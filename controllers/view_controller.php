<?php 

	require('../lib/php_excel/php-excel-reader/excel_reader2.php');
	require('../lib/php_excel/SpreadsheetReader.php');

	function get_excel_data($path){
		$Reader = new SpreadsheetReader($path);
		$temp = 'temp';
		foreach ($Reader as $Row)
		{
			$total_array[] = $Row;
		}
		return $total_array;
	}