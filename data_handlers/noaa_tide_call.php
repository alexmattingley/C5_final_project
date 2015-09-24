<?php
// create curl resource
$ch = curl_init();

// set url
curl_setopt($ch, CURLOPT_URL, "http://tidesandcurrents.noaa.gov/api/datagetter?begin_date=20150923&product=predictions&range=48&station=9411406&datum=MLLW&units=english&time_zone=lst&application=Web_Services&format=json");

//return the transfer as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// $output contains the output string
$output = curl_exec($ch);

// close curl resource to free up system resources
curl_close($ch);

print_r($output);
?>