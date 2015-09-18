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

print_r($buoy_array[0]['Buoy_name']);

for($i = 0; $i < count($buoy_array); $i++){
    print_r($buoy_array[$i]);
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
        <div class="indiv-buoy col-xs-10 col-xs-offset-1">
            <h4>Anacapa</h4>
            <p>Height: 3ft</p>
            <p>Peak Period: 14 seconds</p>
            <p>Direction: 285° (WNW)</p>
            <p>Water Temperature: 70°F</p>
        </div>
        <div class="indiv-buoy col-xs-10 col-xs-offset-1">
            <h4>Anacapa</h4>
            <p>Height: 3ft</p>
            <p>Peak Period: 14 seconds</p>
            <p>Direction: 285° (WNW)</p>
            <p>Water Temperature: 70°F</p>
        </div>
        <div class="indiv-buoy col-xs-10 col-xs-offset-1">
            <h4>Anacapa</h4>
            <p>Height: 3ft</p>
            <p>Peak Period: 14 seconds</p>
            <p>Direction: 285° (WNW)</p>
            <p>Water Temperature: 70°F</p>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="wind-data-block">
        <h3 class="col-xs-10 col-xs-offset-1">Wind</h3>
        <div class="indiv-wind col-xs-10 col-xs-offset-1">
            <h4>Santa Barabara Airport</h4>
            <p>Air Temperature: 76°F</p>
            <p>Last Reading: Last Updated on September 18, 9:53 AM PDT</p>
            <p>Weather: Clear</p>
            <p>Wind: 5 MPH from the SE</p>
            <p>Wind gusts: 0 MPH</p>
        </div>
        <div class="indiv-wind col-xs-10 col-xs-offset-1">
            <h4>Santa Barabara Airport</h4>
            <p>Air Temperature: 76°F</p>
            <p>Last Reading: Last Updated on September 18, 9:53 AM PDT</p>
            <p>Weather: Clear</p>
            <p>Wind: 5 MPH from the SE</p>
            <p>Wind gusts: 0 MPH</p>
        </div>
        <div class="indiv-wind col-xs-10 col-xs-offset-1">
            <h4>Santa Barabara Airport</h4>
            <p>Air Temperature: 76°F</p>
            <p>Last Reading: Last Updated on September 18, 9:53 AM PDT</p>
            <p>Weather: Clear</p>
            <p>Wind: 5 MPH from the SE</p>
            <p>Wind gusts: 0 MPH</p>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
