<?php

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
        echo "this is not working: <br>";
    }

    $tfh_buoy_data = array();
    for($i = 0; $i < count($location_relevant_buoys); $i++){
    //$location_relevant_buoys[$i] - this is the array value that is returned by the first query in this function. buoy id is the just the station number which is used to identify the table to pull from the db.
        //print("<h1>" . $location_relevant_buoys[$i]['buoy_id'] . "</h1>");
        $get_buoy_query = "SELECT * FROM `{$location_relevant_buoys[$i]['buoy_id']}`";
        $results = mysqli_query($conn, $get_buoy_query);
        if(mysqli_num_rows($results) > 0){
           while ($result = mysqli_fetch_assoc($results)){
              array_push($tfh_buoy_data, $result); 
            }
        }else{
            //nothing here so if it breaks I dont have a complete breakdown
        }
   }
}

get_buoy_data_from_db();

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

    $buoy_base_array = json_encode($buoy_base_array);
    print($buoy_base_array);
}

organize_buoy_data();

?>