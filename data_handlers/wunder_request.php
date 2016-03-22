<?php

$connect_path = '/Users/alex/Sites/greenroomhunter/mysql_connect.php';

/*********************************
 * Query which calls data base and determines what the last updated was
 */

require($connect_path); //if you are live here you need to be more specific: /var/www/html/C5_final_project/mysql_connect.php
$query = "select * from `wind_data` where last_updated = (select min(last_updated) from `wind_data`)";
$results = mysqli_query($conn, $query);
$i = 0;
if(mysqli_num_rows($results) > 0){
    while($result = mysqli_fetch_assoc($results)){
       $api_url = $result['api_url'];
    }
}

//print_r($current_data);

/********************************************
 * pulling readings.
 *
*******/
$json_string = file_get_contents("$api_url");
$parsed_json = json_decode($json_string);
$location = $parsed_json->{'location'}->{'city'};
$observation_location = $parsed_json->current_observation->observation_location->city;
$station_id = $parsed_json->current_observation->station_id;
$temp_f = $parsed_json->current_observation->temp_f;
$wind_dir = $parsed_json->current_observation->wind_dir;
$wind_mph= $parsed_json->current_observation->wind_mph;
$wind_gust = $parsed_json->current_observation->wind_gust_mph;
$weather = $parsed_json->current_observation->weather;
$last_observed = $parsed_json->current_observation->observation_time;

$line_break = '<br>';

//the print statements below are simply to make sure the request is still working
print("observation location: $observation_location $line_break");
print("station id: $station_id $line_break");
print("Located in: $location $line_break");
print("Air Temp: $temp_f $line_break");
print("Wind direction: $wind_dir $line_break");
print("Wind Speed(mph): $wind_mph $line_break");
print("Wind Gust(mph): $wind_gust $line_break");
print("Weather-description: $weather $line_break");
print("Last Reading: $last_observed $line_break");


/************************
 * Sending data to database and overwriting older data
 */


require($connect_path); //if you are live here you need to be more specific: /var/www/html/C5_final_project/mysql_connect.php

$query = "UPDATE `wind_data` SET `last_observed`='$last_observed',`temp_f`='$temp_f',`wind_dir`='$wind_dir',`wind_mph`='$wind_mph',`wind_gust_mph`='$wind_gust',`weather`='$weather',`last_updated`= UNIX_TIMESTAMP(now()) WHERE `station_id`='$station_id'";
$results = mysqli_query($conn, $query);
if (mysqli_affected_rows($conn) > 0) {
    print_r($results);
}else {
    print('something isnt working');
}



?>