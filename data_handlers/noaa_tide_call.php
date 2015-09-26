<?php

/***********************
 * This is a query that calls the default station number for each location
 */

$location_id = $_POST["location_index"];
require('../mysql_connect.php');
$query = "SELECT * FROM `locations` WHERE `id`='$location_id'";
$results = mysqli_query($conn, $query);
if(mysqli_num_rows($results) > 0){
    while($result = mysqli_fetch_assoc($results)){
        $tide_query = $result['tide_query'];
    }
}

/***********************
 * This is the curl request for noaa dataset that will create our tide chart
 */
// create curl resource
$ch = curl_init();

// set url
curl_setopt($ch, CURLOPT_URL, "http://tidesandcurrents.noaa.gov/api/datagetter?begin_date=20150923&product=predictions&range=48&station=$tide_query&datum=MLLW&units=english&time_zone=lst&application=Web_Services&format=json");

//return the transfer as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// $output contains the output string
$output = curl_exec($ch);

// close curl resource to free up system resources
curl_close($ch);

print_r($output);

?>