<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

# Including the database db name
include "database.php";

# Client ID to filter
$client_id = isset($_GET['client_id']) ? $_GET['client_id'] : null;

# Connecting to the Database table
$sql = "SELECT * FROM orders";
if ($client_id !== null) {
    $sql .= " WHERE client_id = " . $client_id;
}

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $output = array();
    $totalAmount = 0; // Initialize total amount
    
    while ($row = mysqli_fetch_assoc($result)) {
        $client = array(
            'id' => $row['id'],
            'client_id' => $row['client_id'],
        );
        $output[] = $client;
        
        // Accumulate the amount
        $totalAmount += $row['product_price'];
    }
    // Count the rows
    $rows = count($output);
   
    // Encode the whole array along with the total amount
    echo json_encode(array('count' => $rows, 'total_amount' => $totalAmount, 'data' => $output));
} else {
    echo json_encode(array('message' => 'No Records found', 'status' => false));
}
?>
