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
	$dayOfMonth = "";
	$peakPeriod = "";
	$swellHeight = "";
	$swellDirection = "";
	$waterTemp = "";
	for ($j=0; $j <= 2; $j++) { 
	 	$stationid .= $buoy_array[$i][$j];
	}

	for ($j=4; $j <= 29; $j++) { 
	 	$stationName .= $buoy_array[$i][$j]; 
	}

	for($j = 30; $j<=31; $j++){
	 	$dayOfMonth .= $buoy_array[$i][$j];
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

	$buoy_array[$i] = array('stationid' => $stationid, 'stationName' => $stationName, 'dayOfMonth' => $dayOfMonth, 'peakPeriod' => $peakPeriod, 'swellHeight' => $swellHeight, 'swellDirection' => $swellDirection, 'waterTemp' => $waterTemp);

	print_r($buoy_array[$i]);
	print "<br>";	
}

?>