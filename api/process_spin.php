<?php
session_start();
header('Content-Type: application/json');
include '../config/database.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_SESSION['student_id'];
    $discount = (int)$_POST['discount'];
    $course_price = $_SESSION['course_price'];
    $final_price = $course_price * (1 - $discount/100);
    
    // Update student with spin result (created_at remains unchanged)
    $query = "UPDATE students SET spin_discount = $discount, final_price = $final_price WHERE id = $student_id";
    
    if(mysqli_query($conn, $query)) {
        echo json_encode([
            'success' => true, 
            'discount' => $discount,
            'final_price' => $final_price
        ]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    }
}
?>