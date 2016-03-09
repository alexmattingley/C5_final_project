<?php

/**
 * Globals
 */
$location_id = $_POST['location_index'];
$buoy_data_before_organize;
$error_message = array();

/**
 *  @FName: get_buoy_data_from_db()
 *  @purpose query for the buoys which are relevant to the location choosen, then query for the data for the relevant buoys
 *  @global $location_id, $buoy_data_before_organize, $error_message
 *  @param 
 *  @return
 */

function get_buoy_data_from_db(){
    global $location_id;
    global $buoy_data_before_organize;
    global $error_message;
    $location_relevant_buoys = array();
    require('../mysql_connect.php');

    $get_loc_query = "SELECT * FROM `historical_location_buoy_relations` WHERE historical_location_buoy_relations.location_id = '$location_id'";
    $results = mysqli_query($conn, $get_loc_query);
    if(!mysqli_error($conn)){
        if(mysqli_num_rows($results) > 0){
           while ($result = mysqli_fetch_assoc($results)){
              array_push($location_relevant_buoys, $result);  
            }
        }else{
            $error_message['error'] = 'whoops! there are no buoys associated with that location, try refreshing the page';
        }
    }else{
        $error_message['error'] = 'There appears to be a problem with the sql query $get_loc_query, if you refresh this page and see this message again, email me';
    }

    $buoy_data_before_organize = array();
    for($i = 0; $i < count($location_relevant_buoys); $i++){
        $get_buoy_query = "SELECT * FROM `{$location_relevant_buoys[$i]['buoy_id']}`";
        $results = mysqli_query($conn, $get_buoy_query);
        if(mysqli_num_rows($results) > 0){
           while ($result = mysqli_fetch_assoc($results)){
              array_push($buoy_data_before_organize, $result); 
            }
        }
   }
}

get_buoy_data_from_db();

/**
 *  @FName organize_buoy_data()
 *  @purpose organizes raw buoy data into buoy_base_array which is then returned as a json object
 *  @global $buoy_data_before_organize
 *  @param 
 *  @return $buoy_base_array
 */

function organize_buoy_data(){
    global $buoy_data_before_organize;
    for($i = 0; $i < count($buoy_data_before_organize); $i++){
        if($i == 0){
            $station_num = $buoy_data_before_organize[$i]['station_num'];
            $buoy_base_array = array(
                $station_num =>  array($buoy_data_before_organize[$i])
            );
        }elseif ($i != 0 && $buoy_data_before_organize[$i]['station_num'] != $buoy_data_before_organize[$i-1]['station_num']) {
           $buoy_base_array[$buoy_data_before_organize[$i]['station_num']] = array($buoy_data_before_organize[$i]);
        }elseif ($i != 0 ) {
             array_push($buoy_base_array[$buoy_data_before_organize[$i]['station_num']], $buoy_data_before_organize[$i]);
        }

    }

    $buoy_base_array = json_encode($buoy_base_array);
    return $buoy_base_array;
}

/**
 *  @FName: create_return_message()
 *  @purpose create the return message for the javascript file. It either generates an error message or the organized buoy data
 *  @global $error_message
 *  @param 
 *  @return
 */

function create_return_message(){
    global $error_message;
    if($error_message){
        $error_message = json_encode($error_message);
        print $error_message;
    }else {
        print organize_buoy_data();
    }
}

create_return_message();

?>