<?php
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

$buoy_array = explode("\n", $CDIP_string);

unset($buoy_array[0], $buoy_array[1], $buoy_array[2], $buoy_array[63], $buoy_array[64]);

$buoy_array = array_values($buoy_array);

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

create_buoy_array();

//print_r($buoy_array[0]);

// for ($i=0; $i < count($buoy_array); $i++) { 
	
// 	require('../mysql_connect.php');
// 	$query = "INSERT INTO `$buoy_array[$i]->station_num`(`id`, `station_num`, `station_name`, `day_of_month`, `read_time`, `peak_period`, `swell_height`, `swell_direction`, `water_temp`) VALUES (null,$buoy_array[$i]->station_num,'$buoy_array[$i]->stationName',[value-4],[value-5],[value-6],[value-7],[value-8],[value-9])";
// 	$results = mysqli_query($conn, $query);
// 	if (mysqli_affected_rows($conn) > 0) {
// 	    print_r($stationNum);
// 	    print_r($relevantData);
// 	}else {
// 	    print_r($query);
// 	}

// }

// require('../mysql_connect.php');
// $query = "INSERT INTO `$buoy_array[0]->station_num`(`id`, `station_num`, `station_name`, `day_of_month`, `read_time`, `peak_period`, `swell_height`, `swell_direction`, `water_temp`) VALUES (null,$buoy_array[0]->station_num,'$buoy_array[0]->stationName','$buoy_array[0]->dayOfMonth','$buoy_array[0]->readTime','$buoy_array[0]->peakPeriod','$buoy_array[0]->swellHeight','$buoy_array[0]->swellDirection','$buoy_array[0]->waterTemp'";
// $results = mysqli_query($conn, $query);
// if (mysqli_affected_rows($conn) > 0) {
//     print_r($stationNum);
//     print_r($relevantData);
// }else {
//     print_r($query);
// }




