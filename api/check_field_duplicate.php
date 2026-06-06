<?php
session_start();
header('Content-Type: application/json');
include '../config/database.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $field = mysqli_real_escape_string($conn, $_POST['field']);
    $value = mysqli_real_escape_string($conn, $_POST['value']);
    
    $response = ['is_duplicate' => false];
    
    if($field == 'fullname') {
        $query = "SELECT COUNT(*) as count FROM students WHERE fullname = '$value'";
        $result = mysqli_query($conn, $query);
        $data = mysqli_fetch_assoc($result);
        
        if($data['count'] > 0) {
            $response['is_duplicate'] = true;
        }
    } elseif($field == 'tel') {
        $query = "SELECT COUNT(*) as count FROM students WHERE tel = '$value'";
        $result = mysqli_query($conn, $query);
        $data = mysqli_fetch_assoc($result);
        
        if($data['count'] > 0) {
            $response['is_duplicate'] = true;
        }
    }
    
    echo json_encode($response);
}
?>