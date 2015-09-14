<?php
require('../mysql_connect.php');
$query = "SELECT * FROM `wundgeround_ajax_time`";
$results = mysqli_query($conn, $query);
$i = 0;
//date_default_timezone_set('America/Los_Angeles');
if(mysqli_num_rows($results) > 0){
    while($result = mysqli_fetch_assoc($results)){
       $json_string = json_encode($result);
    }
}

print($json_string);
?>