<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

# Including the database db name
include "database.php";

# Connecting to the Database table
$sql = "SELECT * FROM product";
 

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $output = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $product = array(
            'product_id' => $row['product_id'],
            'product_name' => $row['product_name'],
            'category' => $row['category'],
            'offers' => $row['offers'],
            'client_id' => $row['client_id'],
            'client_name' => $row['client_name'],
            'product_description' => $row['product_description'],
            'product_image1' => $row['product_image1'],
            'product_image2' => $row['product_image2'],
            'product_image3' => $row['product_image3'],

            // Add other columns as needed
        );
        $output[] = $product;
    }
    // Count the rows
    $rows = count($output);
    // Encode the whole array
    echo json_encode(array('count' => $rows, 'data' => $output));
} else {
    echo json_encode(array('message' => 'No Records found', 'status' => false));
}
?>
