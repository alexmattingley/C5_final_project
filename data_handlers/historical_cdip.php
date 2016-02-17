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

$buoy_info_array = array();

for ($i=0; $i < count($buoy_array); $i++) {
	$stationid = "";
	$stationName = "";
	for ($j=0; $j <= 2; $j++) { 
	 	$stationid .= $buoy_array[$i][$j];
	 }

	 for ($j=4; $j <= 29; $j++) { 
	 	$stationName .= $buoy_array[$i][$j]; 
	 }


	$buoy_array[$i] = array('stationid' => $stationid, 'stationName' => $stationName);
}

print_r($buoy_array);

?>