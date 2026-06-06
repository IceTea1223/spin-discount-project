<?php
include '../config/database.php';
include '../includes/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="dashboard-container">
        <h1>📊 Admin Dashboard</h1>
        
        <div class="stats-grid">
            <?php
            $total_query = "SELECT COUNT(*) as total FROM students";
            $total_result = mysqli_query($conn, $total_query);
            $total = mysqli_fetch_assoc($total_result)['total'];
            
            $pending_query = "SELECT COUNT(*) as pending FROM students WHERE payment_status='pending'";
            $pending_result = mysqli_query($conn, $pending_query);
            $pending = mysqli_fetch_assoc($pending_result)['pending'];
            
            $done_query = "SELECT COUNT(*) as done FROM students WHERE payment_status='done'";
            $done_result = mysqli_query($conn, $done_query);
            $done = mysqli_fetch_assoc($done_result)['done'];
            
            // Today's registrations
            $today_query = "SELECT COUNT(*) as today FROM students WHERE DATE(created_at) = CURDATE()";
            $today_result = mysqli_query($conn, $today_query);
            $today = mysqli_fetch_assoc($today_result)['today'];
            ?>
            
            <div class="stat-card">
                <h3>Total Students</h3>
                <p class="stat-number"><?php echo $total; ?></p>
            </div>
            <div class="stat-card">
                <h3>Today's Registrations</h3>
                <p class="stat-number"><?php echo $today; ?></p>
            </div>
            <div class="stat-card">
                <h3>Pending Payment</h3>
                <p class="stat-number pending"><?php echo $pending; ?></p>
            </div>
            <div class="stat-card">
                <h3>Completed</h3>
                <p class="stat-number success"><?php echo $done; ?></p>
            </div>
        </div>
        
        <div class="filters">
            <input type="text" id="searchInput" placeholder="Search by name or phone...">
            <select id="paymentFilter">
                <option value="all">All Students</option>
                <option value="pending">Pending Payment</option>
                <option value="done">Payment Done</option>
            </select>
            <select id="dateFilter">
                <option value="all">All Time</option>
                <option value="today">Today</option>
                <option value="week">This Week</option>
                <option value="month">This Month</option>
            </select>
        </div>
        
        <div id="studentList"></div>
    </div>
    
    <script>
    function loadStudents() {
        const search = $('#searchInput').val();
        const payment = $('#paymentFilter').val();
        const dateRange = $('#dateFilter').val();
        
        $.ajax({
            url: 'search_students.php',
            method: 'GET',
            data: {search: search, payment: payment, date_range: dateRange},
            success: function(data) {
                $('#studentList').html(data);
            }
        });
    }
    
    function updatePayment(id, status) {
        $.ajax({
            url: 'update_payment.php',
            method: 'POST',
            data: {id: id, status: status},
            success: function() {
                loadStudents();
            }
        });
    }
    
    $(document).ready(function() {
        loadStudents();
        $('#searchInput, #paymentFilter, #dateFilter').on('keyup change', function() {
            loadStudents();
        });
    });
    </script>
</body>
</html>