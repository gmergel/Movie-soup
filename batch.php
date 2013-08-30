<?php

include('excel_reader2.php');
$data = new Spreadsheet_Excel_Reader("test.xls");

//for($sheet=0;$sheet<3;$sheet++){

$sheet = 0; //informal

	$column = 1;
	$row = 2;
	
	while($data->val($row,$column,$sheet) != ''){

		while($data->val($row,$column,$sheet) != ''){
			
			//if(!count($extracted[$headers[$column-1]])) $extracted[$headers[$column-1]] = array();
			//array_push($extracted[$headers[$column-1]], $data->val($row,$column,$sheet));
			
			switch($column){
				case 1:
					$inumber = $data->val($row,$column,$sheet);
					if(!count($extracted[$inumber])){
						$extracted[$inumber] = array();
						$extracted[$inumber]['dates'] = array();
						$extracted[$inumber]['midturns'] = array();
					}
				break;				
				
				case 2:
					$dayoff = $data->val($row,$column,$sheet);
					array_push($extracted[$inumber]['dates'],$dayoff);
				break;

				case 3:
					$midturn = (strtolower($data->val($row,$column,$sheet)) == 'yes')? 1 : 0;
					array_push($extracted[$inumber]['midturns'],$midturn);
				break;
			}

			$column++;

		}
		$column = 1;
		$row++;

	}

	//print_r($extracted);
	$counter = 1;

	foreach($extracted as $key => $value){

		$tbiinumber = $key;
		$tbidates = $value['dates'];
		$tbimidturns = $value['midturns'];

		echo "<br><hr>".$counter."<hr>insert into requests (person_idperson, tag, approved, sent, date_sent, date_approved) values ((Select idperson from person where LOWER(inumber) = LOWER('".$tbiinumber."')),'fix',1,1,NOW(),NOW());<br>";

		$sqldates = "insert into daysoff (requests_idrequests, person_idperson, date, midturn) values ";

		foreach($tbidates as $idx => $date){
			if($idx != 0) $sqldates .= ',';
			$sqldates .= "((SELECT max( idrequests ) FROM requests), (Select idperson from person where LOWER(inumber) = LOWER('".$tbiinumber."')), '".$date."', ".$tbimidturns[$idx].")" ;
		}
		$sqldates .= ';';
		echo $sqldates;

		$counter++;
	}

	
//}

?>
