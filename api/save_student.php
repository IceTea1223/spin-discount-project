<?php
session_start();
header('Content-Type: application/json');
include '../config/database.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $tel = mysqli_real_escape_string($conn, $_POST['tel']);
    $course_name = mysqli_real_escape_string($conn, $_POST['course_name']);
    $course_price = (float)$_POST['course_price'];
    $course_schedule = mysqli_real_escape_string($conn, $_POST['course_schedule']);
    $force_save = isset($_POST['force_save']) ? true : false;
    
    // Check for duplicates if not forced
    if(!$force_save) {
        $check_query = "SELECT id FROM students WHERE fullname = '$fullname' OR tel = '$tel'";
        $check_result = mysqli_query($conn, $check_query);
        
        if(mysqli_num_rows($check_result) > 0) {
            echo json_encode([
                'success' => false, 
                'error' => 'Duplicate entry found. Please confirm to proceed.'
            ]);
            exit();
        }
    }
    
    // Insert student (created_at will be auto-set by MySQL)
    $query = "INSERT INTO students (fullname, gender, tel, course_name, course_price, course_schedule) 
              VALUES ('$fullname', '$gender', '$tel', '$course_name', $course_price, '$course_schedule')";
    
    if(mysqli_query($conn, $query)) {
        $student_id = mysqli_insert_id($conn);
        $_SESSION['student_id'] = $student_id;
        $_SESSION['course_price'] = $course_price;
        $_SESSION['course_name'] = $course_name;
        $_SESSION['course_schedule'] = $course_schedule;
        $_SESSION['fullname'] = $fullname;
        $_SESSION['gender'] = $gender;
        $_SESSION['tel'] = $tel;
        
        echo json_encode(['success' => true, 'student_id' => $student_id]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    }
}
?>