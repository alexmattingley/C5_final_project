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

require('../mysql_connect.php');
$query = "select * from `wind_data` where last_updated = (select min(last_updated) from `wind_data`)";
$results = mysqli_query($conn, $query);
$i = 0;
if(mysqli_num_rows($results) > 0){
    while($result = mysqli_fetch_assoc($results)){
       $api_url = $result['api_url'];
       print($api_url);
    }
}

//print_r($current_data);

/********************************************
 * pulling Goleta wind/temp readings.
 *
*******/
$json_string = file_get_contents("$api_url");
$parsed_json = json_decode($json_string);
$location = $parsed_json->{'location'}->{'city'};
$temp_f = $parsed_json->current_observation->temp_f;
$wind_dir = $parsed_json->current_observation->wind_dir;
$wind_mph= $parsed_json->current_observation->wind_mph;
$wind_gust = $parsed_json->current_observation->wind_gust_mph;
$weather = $parsed_json->current_observation->weather;
$last_observed = $parsed_json->current_observation->observation_time;

$line_break = '<br>';

//the print statements below are simply to make sure the request is still working
print("Located in: $location $line_break");
print("Air Temp: $temp_f $line_break");
print("Wind direction: $wind_dir $line_break");
print("Wind Speed(mph): $wind_mph $line_break");
print("Wind Gust(mph): $wind_gust $line_break");
print("Weather-description: $weather $line_break");
print("Last Reading: $last_observed $line_break");


/************************
 * Sending Goleta data to database and overwriting older data
 */

//query statement = UPDATE `wind_data` SET `last_observed`='2015',`temp_f`='9000',`wind_dir`='wnw',`wind_mph`='100',`wind_gust_mph`='110',`weather`='hell on earth',`location`='Goleta',`last_updated`= UNIX_TIMESTAMP(now()) WHERE `location`='Goleta'

?>