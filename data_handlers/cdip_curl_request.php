<?php
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'http://cdip.ucsd.edu/data_access/synopsis_pm.cdip');
$result = curl_exec($curl);
curl_close($curl);
print($result);
?>