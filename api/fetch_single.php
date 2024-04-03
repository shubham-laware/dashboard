<?php
#declaring the header types and access controls;
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

#inserting the dynamic value in JSON format;
$data = json_decode(file_get_contents("php://input"), true);

$input = $data['id'];

#included the database db name;
include "database.php";

#connecting to the Database table;
$sql = "SELECT * FROM client_register WHERE id = '{$input}'";
$result = mysqli_query($conn, $sql);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $output = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode($output);
    } else {
        echo json_encode(array('message' => 'No records found', 'status' => false));
    }
} else {
    echo json_encode(array('message' => 'Error executing the query', 'status' => false));
}

mysqli_close($conn);
?>
