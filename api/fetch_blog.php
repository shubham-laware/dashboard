<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

# Including the database db name
include "database.php";

# Client ID to filter
$date = isset($_GET['date']) ? $_GET['date'] : null;

# Connecting to the Database table
$sql = "SELECT * FROM blog";
if ($date !== null) {
    $sql .= " WHERE date = " . $date;
}

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $output = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $client = array(
            'id' => $row['id'],
            'title' => $row['title'],
            'description_1' => $row['description_1'],
            'description_2' => $row['description_2'],
            'description_3' => $row['description_3'],
            'image_1' => $row['image_1'],
            'image_2' => $row['image_2'],
            'image_3' => $row['image_3'],
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
