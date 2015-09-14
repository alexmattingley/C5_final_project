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

/********************************************
 * pulling Goleta wind/temp readings.
 */
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
print("Located in: $goleta_location $line_break");
print("Air Temp: $goleta_temp_f $line_break");
print("Wind direction: $goleta_wind_dir $line_break");
print("Wind Speed(mph): $golelta_wind_mph $line_break");
print("Wind Gust(mph): $goleta_wind_gust $line_break");
print("Weather-description: $goleta_weather $line_break");
print("Last Reading: $goleta_last_observed $line_break");

print_r($parsed_json->current_observation);

/************************
 * Sending Goleta data to database.
 */

?>