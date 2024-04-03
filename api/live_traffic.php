<?php

 extract($_POST);
error_reporting(0);
 include 'database.php';
 
 $sql = "INSERT INTO live_traffic (url, timestamp, device, location) VALUES('$url', '$timestamp', '$userAgent', '$location' )";
mysqli_query( $conn, $sql ); 
?>