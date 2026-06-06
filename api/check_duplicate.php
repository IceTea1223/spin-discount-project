<?php
session_start();
header('Content-Type: application/json');
include '../config/database.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $tel = mysqli_real_escape_string($conn, $_POST['tel']);
    
    $response = [
        'is_duplicate' => false,
        'duplicate_name' => false,
        'duplicate_tel' => false,
        'existing_name_date' => null,
        'existing_tel_date' => null
    ];
    
    // Check for duplicate fullname
    $name_query = "SELECT fullname, created_at, payment_status FROM students WHERE fullname = '$fullname' LIMIT 1";
    $name_result = mysqli_query($conn, $name_query);
    
    if(mysqli_num_rows($name_result) > 0) {
        $name_data = mysqli_fetch_assoc($name_result);
        $response['is_duplicate'] = true;
        $response['duplicate_name'] = true;
        $response['existing_name_date'] = date('F j, Y', strtotime($name_data['created_at']));
    }
    
    // Check for duplicate telephone
    $tel_query = "SELECT tel, created_at, payment_status FROM students WHERE tel = '$tel' LIMIT 1";
    $tel_result = mysqli_query($conn, $tel_query);
    
    if(mysqli_num_rows($tel_result) > 0) {
        $tel_data = mysqli_fetch_assoc($tel_result);
        $response['is_duplicate'] = true;
        $response['duplicate_tel'] = true;
        $response['existing_tel_date'] = date('F j, Y', strtotime($tel_data['created_at']));
    }
    
    echo json_encode($response);
}
?>