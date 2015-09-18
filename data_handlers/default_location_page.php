<?php
$location_id = $_POST['location_index'];
require('../mysql_connect.php');
$query = "SELECT * FROM location_buoy_relations LEFT JOIN buoy_data on buoy_data.id = location_buoy_relations.buoy_id WHERE location_buoy_relations.location_id = '$location_id'";
$results = mysqli_query($conn, $query);
$i = 0;
if(mysqli_num_rows($results) > 0){
    while($result = mysqli_fetch_assoc($results)){
        //print_r($result);
    }
}
?>
<?php include "../inc/basic_nav.php"; ?>

</div>
