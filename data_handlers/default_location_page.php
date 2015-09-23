<?php

/***************************
 * This block is the query call for the buoy data
 */

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

/***************************
 * This block is the query call for the wind data
 */
$weather_array = array();
require('../mysql_connect.php');
$query = "SELECT * FROM location_wind_relations LEFT JOIN wind_data on wind_data.id = location_wind_relations.wind_id WHERE location_wind_relations.location_id = '$location_id'";
$results = mysqli_query($conn, $query);
if(mysqli_num_rows($results) > 0){
    while($result = mysqli_fetch_assoc($results)){
        array_push($weather_array,$result);
    }
}


require('../mysql_connect.php');
$query = "SELECT * FROM `locations` WHERE `id`='$location_id'";
$results = mysqli_query($conn, $query);
if(mysqli_num_rows($results) > 0){
    while($result = mysqli_fetch_assoc($results)){
        $location_name = $result['location_name'];
    }
}



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

        if($i == 0 || $i % 3 == 0){; ?>

        <div class="indiv-buoy col-xs-10 col-xs-offset-1 col-sm-3 col-sm-offset-0">

        <?php } else {; ?>

        <div class="indiv-buoy indiv-wind col-xs-10 col-xs-offset-1 col-sm-3">

        <?php }; ?>
            <h4><?php print($buoy_array[$i]['Buoy_name']); ?></h4>
            <p>Height: <?php print($relevant_data_object->swellHeight); ?> ft</p>
            <p>Peak Period: <?php print($relevant_data_object->peakPeriod); ?> seconds</p>
            <p>Swell Direction: <?php print($relevant_data_object->swellDirection); ?>°</p>
            <p>Water Temp: <?php print($relevant_data_object->waterTemp); ?>°F</p>
        </div>
        <?php
    }
}


/**********************
 * function_name: create_indiv_wind
 * @purpose: This function creates each of the individual html code blocks for each wind point
 * @param: N/A
 * @globals:$weather_array
 */


function create_indiv_wind(){
    global $weather_array;
    for($i = 0; $i < count($weather_array); $i++){
        if($i == 0 || $i % 3 == 0){; ?>

        <div class="indiv-wind col-xs-10 col-xs-offset-1 col-sm-3 col-sm-offset-0">

        <?php } else {; ?>

        <div class="indiv-wind col-xs-10 col-xs-offset-1 col-sm-3">

        <?php }; ?>

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
        <div class="container-fluid col-lg-10 col-lg-offset-1">
            <?php include "../inc/basic_nav.php"; ?>
            <h2>Snapshot of <?php print($location_name); ?>, CA</h2>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="buoy-block">
        <div class="container-fluid col-lg-10 col-lg-offset-1">
            <h3 class="col-xs-10 col-xs-offset-1 col-lg-12 col-sm-offset-0">Buoys</h3>
            <?php create_indiv_buoys(); ?>
            <p class="credit col-xs-10 col-xs-offset-1 col-sm-3 col-sm-offset-0">Buoy Data provided by <a href="http://cdip.ucsd.edu/">CDIP</a></p>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="wind-data-block">
        <div class="container-fluid col-lg-10 col-lg-offset-1">
            <h3 class="col-xs-10 col-xs-offset-1 col-lg-12 col-sm-offset-0">Wind</h3>
            <?php create_indiv_wind(); ?>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

