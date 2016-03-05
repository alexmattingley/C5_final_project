<?php


$location_id = $_POST['location_index']; //For testing purposes only!


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
        <div class="container">
            <div class="col-lg-10 col-lg-offset-1">
                <?php include "../inc/basic_nav.php"; ?>
                <h2>Snapshot of <?php print($location_name); ?>, CA</h2>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="buoy-block container">
        <div class="col-lg-10 col-lg-offset-1">
            <h3 class="">Buoys</h3>
            <div class="buoy-charts">
                
            </div>
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
            <canvas class="center-block" id="tideChart"></canvas>
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

