<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

# Including the database db name
include "database.php";

# Client ID to filter
$date = isset($_GET['date']) ? $_GET['date'] : null;

# Connecting to the Database table
$sql = "SELECT * FROM orders";
if ($date !== null) {
    $sql .= " WHERE date = " . $date;
}

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $output = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $client = array(
            'id' => $row['id'],
            'date' => $row['date'],
        );
        $output[] = $client;
    }
    // Count the rows
    $rows = count($output);
    // Encode the whole array
    echo json_encode(array('count' => $rows, 'data' => $output));
} else {
    echo json_encode(array('message' => 'No Records found', 'status' => false));
}
?>
