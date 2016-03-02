<?php

function cdip_call(){
	// create curl resource
	$ch = curl_init();

	// set url
	curl_setopt($ch, CURLOPT_URL, "http://cdip.ucsd.edu/data_access/synopsis.cdip");

	//return the transfer as a string
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	// $output contains the output string
	$CDIP_string = curl_exec($ch);

	// close curl resource to free up system resources
	curl_close($ch);

	return $CDIP_string;
}

function prepare_buoy_array(){

	global $buoy_array;

	$buoy_array = explode("\n", cdip_call());
	unset($buoy_array[0], $buoy_array[1], $buoy_array[2], $buoy_array[63], $buoy_array[64]);
	$buoy_array = array_values($buoy_array);
}

function create_buoy_array(){
	global $buoy_array;
	class buoyObject {
		public function __construct($stationId, $stationName, $dayOfMonth, $readTime, $peakPeriod, $swellHeight, $swellDirection, $waterTemp){
			$this->stationId = $stationId;
			$this->stationName = $stationName;
			$this->dayOfMonth = $dayOfMonth;
			$this->readTime = $readTime;
			$this->peakPeriod = $peakPeriod;
			$this->swellHeight = $swellHeight;
			$this->swellDirection = $swellDirection;
			$this->waterTemp = $waterTemp;
		}
	}

	for ($i=0; $i < count($buoy_array); $i++) {
		$stationId = "";
		$stationName = "";
		$dayOfMonth = "";
		$readTime = "";
		$peakPeriod = "";
		$swellHeight = "";
		$swellDirection = "";
		$waterTemp = "";
		
		for ($j=0; $j <= 2; $j++) { 
		 	$stationId .= $buoy_array[$i][$j];
		}

		for ($j=4; $j <= 29; $j++) { 
		 	$stationName .= $buoy_array[$i][$j]; 
		}

		for($j = 30; $j<=31; $j++){
		 	$dayOfMonth .= $buoy_array[$i][$j];
		}

		for ($j=33; $j <= 36; $j++) { 
			$readTime .= $buoy_array[$i][$j];
		}
		for($j = 51; $j<=52; $j++){
			$peakPeriod .= $buoy_array[$i][$j];
		}

		for($j = 47; $j <= 49; $j++){
	        $swellHeight.=$buoy_array[$i][$j];
	    }
	    $swellHeight = ($swellHeight*0.39370)/12;
	    $swellHeight = round($swellHeight, 1);	

		 for($j = 54; $j <=56; $j++){
		 	$swellDirection .= $buoy_array[$i][$j];
		 }

		 for($j = 64; $j <= 67; $j++){
		 	$waterTemp .= $buoy_array[$i][$j];
		 }

		 $stationId = intval($stationId);
		 $stationName = trim($stationName);

		$buoy_array[$i] = new buoyObject($stationId, $stationName, $dayOfMonth, $readTime, $peakPeriod, $swellHeight, $swellDirection, $waterTemp);
	}
}

//This needs to be improved, if the api changes this will be a problem.
function remove_unnecessary_readings(){
	global $buoy_array;
	print_r($buoy_array);
	for ($i=0; $i <= 8; $i++) { 
		unset($buoy_array[$i]);
	}

	unset($buoy_array[17]);

	for($i=37; $i <= 57; $i++){
		unset($buoy_array[$i]);
	}

	$buoy_array = array_values($buoy_array);
}

function check_num_rows($table_name){
	global $conn;

	$query_count = "SELECT COUNT(*) FROM `$table_name`";
	$result = mysqli_query($conn, $query_count);
	$row = mysqli_fetch_row($result);
	$num_row = $row[0];
	return $num_row;
}

function create_new_row(){

	global $buoy_array;
	global $conn;

	for ($i=0; $i < count($buoy_array); $i++) {
		$query_create_row = "INSERT INTO `{$buoy_array[$i]->stationId}`(`id`, `station_num`, `station_name`, `day_of_month`, `read_time`, `peak_period`, `swell_height`, `swell_direction`, `water_temp`) VALUES (null, {$buoy_array[$i]->stationId},'{$buoy_array[$i]->stationName}','{$buoy_array[$i]->dayOfMonth}','{$buoy_array[$i]->readTime}','{$buoy_array[$i]->peakPeriod}','{$buoy_array[$i]->swellHeight}','{$buoy_array[$i]->swellDirection}','{$buoy_array[$i]->waterTemp}')";
		$results = mysqli_query($conn, $query_create_row);
		if (mysqli_affected_rows($conn) > 0) {
		   print('you created another row');
		   print("<br>");
		}else {
		   print_r($buoy_array[$i]->stationName . " doesnt exist<br>");
		}
	}
}

function delete_a_row(){

	global $buoy_array;
	global $conn;

	for ($i=0; $i < count($buoy_array); $i++) {
		
		if (check_num_rows($buoy_array[$i]->stationId) > 24) {

			$query_delete = "DELETE FROM `{$buoy_array[$i]->stationId}` LIMIT 1"; //this may be an issue: Documentation: http://stackoverflow.com/questions/733668/delete-the-first-record-from-a-table-in-sql-server-without-a-where-condition
			$results = mysqli_query($conn, $query_delete);
			if (mysqli_affected_rows($conn) > 0) {
			   print('You deleted a row');
			   print("<br>");
			}else {
			    print_r($buoy_array[$i]->stationName . " doesnt exist<br>");
			}

		}
	}
}

function delete_all_rows(){
	global $buoy_array;
	global $conn;

	for ($i=0; $i < count($buoy_array); $i++) {
		$query_delete = "DELETE FROM `{$buoy_array[$i]->stationId}`"; //this may be an issue: Documentation: http://stackoverflow.com/questions/733668/delete-the-first-record-from-a-table-in-sql-server-without-a-where-condition
		$results = mysqli_query($conn, $query_delete);
		if (mysqli_affected_rows($conn) > 0) {
		   print('You deleted all rows');
		   print("<br>");
		}else {
		    print('you tried and failed to delete all rows');
		}
	}
}

function send_buoy_info(){
	delete_a_row();
	create_new_row();
}

prepare_buoy_array();
create_buoy_array();
remove_unnecessary_readings();
require('../mysql_connect.php'); //This is so all of the functions that are called in used in the send_buoy_info can work
send_buoy_info();




