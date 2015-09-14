<?php
require('../mysql_connect.php');
$query = "SELECT * FROM `wind_data`";
$results = mysqli_query($conn, $query);
$i = 0;
if(mysqli_num_rows($results) > 0){
    while($result = mysqli_fetch_assoc($results)){
       $json_string = json_encode($result);
    }
}

print($json_string);
?>