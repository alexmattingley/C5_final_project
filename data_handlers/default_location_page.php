<?php

$location_id = $_POST['location_index'];
$buoy_array = array();
require('../mysql_connect.php');
$query = "SELECT * FROM location_buoy_relations LEFT JOIN buoy_data on buoy_data.id = location_buoy_relations.buoy_id WHERE location_buoy_relations.location_id = '$location_id'";
$results = mysqli_query($conn, $query);
if(mysqli_num_rows($results) > 0){
    while($result = mysqli_fetch_assoc($results)){
        array_push($buoy_array,$result);
    }
}


$weather_array = array();
require('../mysql_connect.php');
$query = "SELECT * FROM location_wind_relations LEFT JOIN wind_data on wind_data.id = location_wind_relations.wind_id WHERE location_wind_relations.location_id = '$location_id'";
$results = mysqli_query($conn, $query);
if(mysqli_num_rows($results) > 0){
    while($result = mysqli_fetch_assoc($results)){
        array_push($weather_array,$result);
    }
}

print_r($weather_array);

/**********************
 * function_name: create_indiv_buoys
 * @purpose: This function creates each of the individual html code blocks for each buoy
 * @param: N/A
 * @globals:$buoy_array
 */

function create_indiv_buoys(){
    global $buoy_array;
    for($i = 0; $i < count($buoy_array); $i++) {
        $relevant_data_object = json_decode($buoy_array[$i]["relevant_data"]);

        ?>
        <div class="indiv-buoy col-xs-10 col-xs-offset-1">
            <h4><?php print($buoy_array[$i]['Buoy_name']); ?></h4>
            <p>Height: <?php print($relevant_data_object->swellHeight); ?> ft</p>
            <p>Peak Period: <?php print($relevant_data_object->peakPeriod); ?> seconds</p>
            <p>Swell Direction: <?php print($relevant_data_object->swellDirection); ?>°</p>
        </div>
        <?php
    }
}


function create_indiv_wind(){
    global $weather_array;
    for($i = 0; $i < count($weather_array); $i++){
        ?>

        <div class="indiv-wind col-xs-10 col-xs-offset-1">
            <h4><?php print($weather_array[$i]['wind_point_name']); ?> </h4>
            <p>Air Temperature: <?php print($weather_array[$i]['temp_f']); ?>°F</p>
            <p><?php print($weather_array[$i]['last_observed']); ?></p>
            <p>Weather: <?php print($weather_array[$i]['weather']); ?></p>
            <p>Wind: <?php print($weather_array[$i]['wind_mph']); ?> MPH from the <?php print($weather_array[$i]['wind_dir']); ?></p>
            <p>Wind gusts: <?php print($weather_array[$i]['wind_gust_mph']); ?> MPH</p>
        </div>
        <?php
    }
}

?>


<div class="default-location">
    <div class="header-page">
        <div class="container-fluid">
            <?php include "../inc/basic_nav.php"; ?>
            <h2>Snapshot of Santa Barbara, CA</h2>
        </div>
    </div>
    <div class="buoy-block">
        <h3 class="col-xs-10 col-xs-offset-1">Buoys</h3>
        <?php create_indiv_buoys(); ?>
        <div class="clearfix"></div>
    </div>
    <div class="wind-data-block">
        <h3 class="col-xs-10 col-xs-offset-1">Wind</h3>
        <?php create_indiv_wind(); ?>
        <div class="clearfix"></div>
    </div>
</div>

