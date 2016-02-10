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

print($buoy_array[3] . "<br>");

print(strlen($buoy_array[3]) . "<br>");

class buoyobject {
	public function __construct($stationId){
		$this->stationId = $stationId;
	}
}

	for($i = 0; $i <= 2; $i++){
		$stationId = $stationId + $buoy_array[3][i];
	}
	echo $stationId;


//create_station_id();
// $new_buoy = new buoyobject(create_station_id());
// print_r($new_buoy);
?>