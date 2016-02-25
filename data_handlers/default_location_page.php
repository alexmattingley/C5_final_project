<?php

/***************************
 * This block is the query call for the buoy data
 */

$location_id = $_POST['location_index']; //For testing purposes only!
$buoy_array = array();
$tfh_buoy_data;

function get_buoy_data_from_db(){
    global $buoy_array;
    global $location_id;
    global $tfh_buoy_data;
    $location_relevant_buoys = array();
    require('../mysql_connect.php');

    $get_loc_query = "SELECT * FROM `historical_location_buoy_relations` WHERE historical_location_buoy_relations.location_id = '$location_id'";
    $results = mysqli_query($conn, $get_loc_query);
    if(mysqli_num_rows($results) > 0){
       while ($result = mysqli_fetch_assoc($results)){
          array_push($location_relevant_buoys, $result);  
        }
    }else{
        echo "not working";
    }
   //print_r($location_relevant_buoys);
    $tfh_buoy_data = array();
   for($i = 0; $i < count($location_relevant_buoys); $i++){
    //print("<h1>" . $location_relevant_buoys[$i]['buoy_id'] . "</h1>");
    $get_buoy_query = "SELECT * FROM `{$location_relevant_buoys[$i]['buoy_id']}`";
    $results = mysqli_query($conn, $get_buoy_query);
        if(mysqli_num_rows($results) > 0){
           while ($result = mysqli_fetch_assoc($results)){
              array_push($tfh_buoy_data, $result);  
            }
        }else{
            echo "<div>not working</div>";
        }
   }
}

get_buoy_data_from_db();

//print_r($tfh_buoy_data);

function organize_buoy_data(){
    global $tfh_buoy_data;
    $organize_buoy_data = array();
    //print_r($tfh_buoy_data[0]['station_num']);
    for($i = 0; $i < count($tfh_buoy_data); $i++){
        if($i == 0){
            $station_num = $tfh_buoy_data[$i]['station_num'];
            $buoy_base_array = array(
                $station_num =>  array($tfh_buoy_data[$i])
            );
        }elseif ($i != 0 && $tfh_buoy_data[$i]['station_num'] != $tfh_buoy_data[$i-1]['station_num']) {
           $buoy_base_array[$tfh_buoy_data[$i]['station_num']] = array($tfh_buoy_data[$i]);
        }elseif ($i != 0 ) {
             array_push($buoy_base_array[$tfh_buoy_data[$i]['station_num']], $tfh_buoy_data[$i]);
        }

    }

    print_r($buoy_base_array);

   // print_r($organized_buoy_data);
}

organize_buoy_data();

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
        $default_buoy_predictions = $result['default_prediction_graph'];
        $local_nowcast = $result['nowcast_url'];
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
        $time = "$relevant_data_object->readTime";
        if ($time > 1200){
            $am_or_pm = "PM";
        }else {
            $am_or_pm = "AM";
        }

        if($i == 0 || $i % 3 == 0){; ?>

        <div class="indiv-buoy col-xs-10 col-xs-offset-1 col-sm-3 col-sm-offset-0">

        <?php } else {; ?>

        <div class="indiv-buoy indiv-wind col-xs-10 col-xs-offset-1 col-sm-3">

        <?php }; ?>
            <h4><?php print($buoy_array[$i]['Buoy_name']); ?></h4>
            <p>Last Updated: <?php print(date('M') . " $relevant_data_object->datePST, " . date('Y') . " at " . $time . " $am_or_pm"); ?> </p>
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

        <div class="indiv-wind first-fourth col-xs-10 col-xs-offset-1 col-sm-3 col-sm-offset-0">

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
        <div class="container-fluid col-lg-8 col-lg-offset-2">
            <?php include "../inc/basic_nav.php"; ?>
            <h2>Snapshot of <?php print($location_name); ?>, CA</h2>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="buoy-block">
        <div class="container-fluid col-lg-8 col-lg-offset-2">
            <h3 class="col-xs-10 col-xs-offset-1 col-lg-12 col-sm-offset-0">Buoys</h3>
            <?php create_indiv_buoys(); ?>
            <p class="credit col-xs-10 col-xs-offset-1 col-sm-3 col-sm-offset-0">Buoy Data provided by <a href="http://cdip.ucsd.edu/">CDIP</a></p>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="wind-data-block">
        <div class="container-fluid col-lg-8 col-lg-offset-2">
            <h3 class="col-xs-10 col-xs-offset-1 col-lg-12 col-sm-offset-0">Wind</h3>
            <?php create_indiv_wind(); ?>
            <p class="credit col-xs-10 col-xs-offset-1 col-sm-3 col-sm-offset-0">Weather Data provided by <a href="http://www.wunderground.com/">Wunderground</a></p>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="buoy-predictions">
        <div class="text-container col-xs-10 col-xs-offset-1 col-lg-6 col-lg-offset-3">
            <h3>Buoy Predictions</h3>
            <p>(The image below scrolls right and left.)</p>
        </div>
        <div class="container-fluid col-xs-10 col-xs-offset-1 col-lg-6 col-lg-offset-3">
          <img class="center-block" src="<?php print($default_buoy_predictions); ?>" alt="" />
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="now-cast container-fluid">
        <h3>Pt. Conception Deep Water Swell</h3>
        <img class="center-block" src="http://cdip.ucsd.edu/recent/model_images/socal_now.png" alt="">
        <h3><?php print($location_name); ?> deep water swell model</h3>
        <img class="center-block" src="<?php print($local_nowcast); ?>" alt="">
        <h3>Offshore Surface Winds</h3>
        <img class="center-block" src="http://www.sccoos.org/data/coamps/analyses/searange/wshr00.png" alt="">
    </div>
    <div class="tidal-predictions">
        <div class="tide-chart hidden-xs container-fluid col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
            <h3>Tides for today and tomorrow</h3>
            <canvas class="center-block" id="myChart"></canvas>
        </div>
        <div class="tide-text-chart hidden-sm hidden-lg container-fluid">
            <h3>Tides for today and tomorrow</h3>
            <table class="table table-striped tide-table">
                <thead>
                <tr>
                    <th>Time</th>
                    <th>Tide (ft)</th>
                </tr>
                </thead>
                <tbody>
                <!--Insert mobile tide chart data here-->
                </tbody>
            </table>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

