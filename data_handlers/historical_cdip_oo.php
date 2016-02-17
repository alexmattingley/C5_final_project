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

class buoyObject {
	public function __construct($stationId, $stationName){
		$this->stationId = $stationId;
		$this->stationName = $stationName;
	}
}

for ($i=0; $i < count($buoy_array); $i++) {
	$stationId = "";
	$stationName = "";
	$dayOfMonth = "";
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

	$buoy_array[$i] = new buoyObject($stationId, $stationName);
}

var_dump($buoy_array); 