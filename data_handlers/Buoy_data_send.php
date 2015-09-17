<?php
$stationName = $_POST["stationName"];
$stationNum = $_POST["stationNum"];
$relevantData = json_encode($_POST["buoy_data"]);
//print($stationName);
//print($stationNum);
//print($relevantData);
require('../mysql_connect.php');
$query = "UPDATE `buoy_data` SET `name`='$stationName',`station_num`='$stationNum',`relevant_data`='$relevantData' WHERE `name`='$stationName'";
$results = mysqli_query($conn, $query);
if (mysqli_affected_rows($conn) > 0) {
    print_r($results);
}else {
    print('something isnt working');
}
?>