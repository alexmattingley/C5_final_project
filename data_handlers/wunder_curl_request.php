<?php
$curl_url = $_POST['curl_url'];
// create curl resource
$ch = curl_init();

// set url
curl_setopt($ch, CURLOPT_URL, $curl_url);

//return the transfer as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// $output contains the output string
$output = curl_exec($ch);

// close curl resource to free up system resources
curl_close($ch);

$json_encoded_output = json_encode($output);
print_r($json_encoded_output);
?>