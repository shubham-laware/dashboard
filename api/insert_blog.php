<?php
// Declaring the header types and access controls
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
error_reporting(0);

// Include the database connection
include "database.php";

// Inserting the dynamic value in JSON format
$data = json_decode(file_get_contents("php://input"), true);

// Taking input values
$title = $data['title'] ?? '';
$description1 = $data['description1'] ?? '';
$description2 = $data['description2'] ?? '';
$description3 = $data['description3'] ?? '';
$img1 = $data['img1'] ?? '';
$img2 = $data['img2'] ?? '';
$img3 = $data['img3'] ?? '';

// Insert data into the database table
$sql = "INSERT INTO blog (title, description_1, description_2, description_3, image_1, image_2, image_3) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

// Bind parameters to the prepared statement
mysqli_stmt_bind_param($stmt, "sssssss", $title, $description1, $description2, $description3, $img1, $img2, $img3);

// Execute the query
if (mysqli_stmt_execute($stmt)) {
    $response = array('message' => 'Data inserted successfully.', 'status' => true);
    
    // Check if files were uploaded
    if (!empty($_FILES['file']['name'])) {
        $file = $_FILES['file'];
        $fileName = $file['name'];
        $destination = $uploadFolder . $fileName;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            $response['file_message'] = 'File uploaded successfully.';
        } else {
            $response['file_message'] = 'Error uploading file.';
        }
    }
    echo json_encode($response);
} else {
    // Capture the MySQL error message
    echo json_encode(array('message' => 'Error executing the query: ' . mysqli_error($conn), 'status' => false));
}

// Close the statement and the connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
