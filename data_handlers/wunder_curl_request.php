<?php
//$output = array();
//
//// create curl resource
//$curl_one = curl_init();
//
//// set url
//curl_setopt($curl_one, CURLOPT_URL, "http://api.wunderground.com/api/b249567299fad989/geolookup/conditions/q/CA/goleta.json");
//
////return the transfer as a string
////curl_setopt($curl_one, CURLOPT_RETURNTRANSFER, 1);
//
//
//// $output contains the output string
//$curl_response = curl_exec($curl_one);
//array_push($output, $curl_response);
//
//// close curl resource to free up system resources
//curl_close($curl_one);
//
////$json_encode_output = json_code($output[0]);
////print_r($json_encode_output);
//
//$json_decode = json_decode($curl_response);
//print_r($json_decode);



//depending on the last updated field in the database, that should be what determines which api to call.

/*********************************
 * Query which calls data base and determines what the last updated was
 */

$current_data = array();

require('../mysql_connect.php');
$query = "SELECT * FROM `wind_data`";
$results = mysqli_query($conn, $query);
$i = 0;
if(mysqli_num_rows($results) > 0){
    while($result = mysqli_fetch_assoc($results)){
       array_push($current_data, $result);
    }
}

print_r($current_data);

/********************************************
 * pulling Goleta wind/temp readings.
*put the closing comment here when you are ready to make the call
$json_string = file_get_contents("http://api.wunderground.com/api/b249567299fad989/geolookup/conditions/q/CA/goleta.json");
$parsed_json = json_decode($json_string);
$goleta_location = $parsed_json->{'location'}->{'city'};
$goleta_temp_f = $parsed_json->current_observation->temp_f;
$goleta_wind_dir = $parsed_json->current_observation->wind_dir;
$golelta_wind_mph= $parsed_json->current_observation->wind_mph;
$goleta_wind_gust = $parsed_json->current_observation->wind_gust_mph;
$goleta_weather = $parsed_json->current_observation->weather;
$goleta_last_observed = $parsed_json->current_observation->observation_time;

$line_break = '<br>';

//the print statements below are simply to make sure the request is still working
print("Located in: $goleta_location $line_break");
print("Air Temp: $goleta_temp_f $line_break");
print("Wind direction: $goleta_wind_dir $line_break");
print("Wind Speed(mph): $golelta_wind_mph $line_break");
print("Wind Gust(mph): $goleta_wind_gust $line_break");
print("Weather-description: $goleta_weather $line_break");
print("Last Reading: $goleta_last_observed $line_break");


/************************
 * Sending Goleta data to database and overwriting older data
 */


?>