<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

# Including the database db name
include "database.php";
$client_id = isset($_GET['client_id']) ? $_GET['client_id'] : null;

# Connecting to the Database table
$sql = "SELECT * FROM orders ";
if ($client_id !== null) {
    $sql .= " WHERE (product_status = 'away' OR product_status = 'arriving') AND client_id =" . $client_id;
}
$result = mysqli_query($conn, $sql);

$output = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $client = array(
            'id' => $row['id'],
            'product_id' => $row['product_id'],
            'order_id' => $row['order_id'],
            'product_name' => $row['product_name'],
            'quantity' => $row['quantity'],
            'product_color' => $row['product_color'],
            'product_price' => $row['product_price'],
            'payment_mode' => $row['payment_mode'],
            'product_status' => $row['product_status'],
            'date' => $row['date'],
            'time' => $row['time']
        );
        $output[] = $client;
    }
} else {
    // No records found
    $output = array('message' => 'No Records found', 'status' => false);
}

echo json_encode($output);
?>
