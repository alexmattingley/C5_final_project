<?php
// create curl resource
$ch = curl_init();

// set url
curl_setopt($ch, CURLOPT_URL, "http://cdip.ucsd.edu/data_access/synopsis.cdip");

//return the transfer as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// $output contains the output string
$output = curl_exec($ch);

if (curl_exec($ch) === FALSE) {
    die("Curl Failed: " . curl_error($ch));
} else {
    $output = curl_exec($ch);
}

// close curl resource to free up system resources
curl_close($ch);

print_r($output);

?>