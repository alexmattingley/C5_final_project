<?php
require('../mysql_connect.php');
$query = "SELECT * FROM `wind_data`";
$results = mysqli_query($conn, $query);
$weather_array = array();
if(mysqli_num_rows($results) > 0){
    while($result = mysqli_fetch_assoc($results)){
        array_push($weather_array, $result);
    }
}
$json_string = json_encode($weather_array);
print($json_string);
?>