<?php
#declaring the header types and access controls;
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Methods, Authorization ');

#inserting the dynamic value in JSON format;
$data = json_decode(file_get_contents("php://input"), true);

#taking input values
$first_name = $data['first_name'];
$last_name = $data['last_name'];
$email=$data['email'];
$password= $data['password'];
$phone=$data['phone'];
$address= $data['address'];
$pincode= $data['pincode'];
$city=$data['city'];
$state=$data['state'];
$gst=$data['gst'];
$panid=$data['panid'];
$account= $data['account'];
$seller_name=$data['seller_name'];
$shop_name=$data['shop_name'];
$coordinates=$data['coordinates'];
$account_name= $data['account_name'];
$ifsc=$data['ifsc'];
$agremerent =$data['agreement'];
$upi = $data['upi'];
 
#included the database db name;
include "database.php";
if (isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $fileName = $file['name'];
    $destination = $uploadFolder . $fileName;

    if (move_uploaded_file($file['tmp_name'], $destination)) {
        echo 'File uploaded successfully.';
    } else {
        echo 'Error uploading file.';
    }
} else {
    echo 'No file uploaded.';
}
#connecting to the Database table;
$sql = "INSERT INTO clients (first_name, last_name, email, password, phone, coordinates, address, pincode, city, state, gst, panid, account, account_name, ifsc, seller_name, shop_name, profilepic, upi, terms_conditions ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?,?,?,?)";
$stmt = mysqli_prepare($conn, $sql);

# Bind parameters to the prepared statement
mysqli_stmt_bind_param($stmt, "ssssssssssssssssssss", $first_name, $last_name, $email, $password, $phone, $coordinates, $address,$pincode,$city,$state,$gst,$panid,$account, $account_name, $ifsc, $seller_name,$shop_name, $profilepic, $upi, $agremerent);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(array('message' => 'Successful Entry.', 'status' => true));
} else {
    echo json_encode(array('message' => 'Error executing the query', 'status' => false));
}

# Close the statement and the connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
