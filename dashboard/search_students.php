<?php
include '../config/database.php';
include '../includes/functions.php';

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$payment = isset($_GET['payment']) ? mysqli_real_escape_string($conn, $_GET['payment']) : 'all';
$date_range = isset($_GET['date_range']) ? mysqli_real_escape_string($conn, $_GET['date_range']) : 'all';

$query = "SELECT * FROM students WHERE (fullname LIKE '%$search%' OR tel LIKE '%$search%')";

// Payment status filter
if($payment != 'all') {
    $query .= " AND payment_status = '$payment'";
}

// Date range filter
if($date_range == 'today') {
    $query .= " AND DATE(created_at) = CURDATE()";
} elseif($date_range == 'week') {
    $query .= " AND YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)";
} elseif($date_range == 'month') {
    $query .= " AND MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
}

$query .= " ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0) {
    echo "<table class='data-table'>";
    echo "<thead><tr>
            <th>ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Course</th>
            <th>Schedule</th>
            <th>Original Price</th>
            <th>Discount</th>
            <th>Final Price</th>
            <th>Registered On</th>
            <th>Status</th>
            <th>Action</th>
            </tr></thead><tbody>";
    
    while($row = mysqli_fetch_assoc($result)) {
        $discountAmount = $row['course_price'] * $row['spin_discount'] / 100;
        $registered_date = date('M d, Y g:i A', strtotime($row['created_at']));
        
        echo "<tr>
                <td>{$row['id']}</td>
                <td><strong>{$row['fullname']}</strong></td>
                <td>{$row['tel']}</td>
                <td>{$row['course_name']}</td>
                <td><small>{$row['course_schedule']}</small></td>
                <td>\${$row['course_price']}</td>
                <td>{$row['spin_discount']}% <span style='color:green'>(-$" . number_format($discountAmount, 2) . ")</span></td>
                <td><strong>\$" . number_format($row['final_price'], 2) . "</strong></td>
                <td><small>{$registered_date}</small></td>
                <td>" . getPaymentStatusBadge($row['payment_status']) . "</td>
                <td>";
        
        if($row['payment_status'] == 'pending') {
            echo "<button onclick='updatePayment({$row['id']}, \"done\")' class='btn-pay'>✓ Mark Paid</button>";
        } else {
            echo "<span class='paid-badge'>✓ Completed</span>";
        }
        
        echo "</td></tr>";
    }
    
    echo "</tbody>}</table>";
} else {
    echo "<p class='no-data'>No students found</p>";
}
?>