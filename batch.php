<?php

include('excel_reader2.php');
$data = new Spreadsheet_Excel_Reader("test.xls");

//for($sheet=0;$sheet<3;$sheet++){

$sheet = 0; //informal

	$column = 1;
	$row = 1;
	$extracted = array();

	while($data->val($row,$column,$sheet) != ''){
		$extracted[$data->val($row,$column,$sheet)] = array();
		$column++;
	}

	$headers = array_keys($extracted);
	$row++;
	$column = 1;

	while($data->val($row,$column,$sheet) != ''){

		while($data->val($row,$column,$sheet) != ''){
			
			if(!count($extracted[$headers[$column-1]])) $extracted[$headers[$column-1]] = array();
			array_push($extracted[$headers[$column-1]], $data->val($row,$column,$sheet));
			$row++;

		}
		$row = 2;
		$column++;

	}

	print_r($extracted);
/*

	foreach($extracted as $key => $value){

		echo "insert into table daysoff () values ()" ;

	}

*/	
//}

?>
