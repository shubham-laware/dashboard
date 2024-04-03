<?php 
 header('Content-Type: application/json');
 header('Access-Control-Allow-Origin: *');
# Including the database db name
include "database.php";
$client_id = isset($_GET['client_id']) ? $_GET['client_id'] : null;
# Connecting to the Database table
$sql = "SELECT * FROM orders ";
 
if ($client_id !== null) {
    $sql .= " WHERE product_status = 'recived' And client_id =" . $client_id;
}
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $output = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $client = array(
            'id' => $row['id'],
           'product_id' => $row['product_id'],
           'order_id'=> $row['order_id'] ,
           'product_name' => $row['product_name'],
           'quantity' => $row['quantity'],
            'product_color' =>$row['product_color'],
            'product_price' =>$row[ 'product_price'],
           'payment_mode'=> $row['payment_mode'],
           'product_status'=> $row['product_status'],
           'date' => $row['date'],
           'time' => $row['time']

        );
        $output[] = $client;
    }
    echo json_encode($output);
} else {
    echo json_encode(array('message' => 'No Records found', 'status' => false));
}
?>
