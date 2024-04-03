<?php 
# Declaring the header types and access controls
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

# Including the database db name                  
include "database.php";

# Connecting to the Database table
$sql = "SELECT * FROM client_register";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $output = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $client = array(
            'id' => $row['id'],
            'first_name' => $row['first_name'],
             
        );
        $output[] = $client;
    }
    echo json_encode($output);
} else {
    echo json_encode(array('message' => 'No Records found', 'status' => false));
}
?>
