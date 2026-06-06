<?php
include '../config/database.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    $query = "UPDATE students SET payment_status = '$status' WHERE id = $id";
    
    if(mysqli_query($conn, $query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>