<?php
$output = array();

// create curl resource
$curl_one = curl_init();

// set url
curl_setopt($curl_one, CURLOPT_URL, "http://api.wunderground.com/api/b249567299fad989/geolookup/conditions/q/CA/goleta.json");

//return the transfer as a string
//curl_setopt($curl_one, CURLOPT_RETURNTRANSFER, 1);


// $output contains the output string
$curl_response = curl_exec($curl_one);
array_push($output, $curl_response);

// close curl resource to free up system resources
curl_close($curl_one);

//$json_encode_output = json_code($output[0]);
//print_r($json_encode_output);

$json_decode = json_decode($curl_response);
print_r($json_decode);
?>