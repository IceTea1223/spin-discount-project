<?php
include '../config/database.php';
include '../includes/functions.php';

// Handle mark as paid action via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_paid_id'])) {
    $studentId = intval($_POST['mark_paid_id']);
    $updateQuery = "UPDATE students SET payment_status = 'done' WHERE id = $studentId";
    if (mysqli_query($conn, $updateQuery)) {
        echo json_encode(['success' => true, 'message' => 'Payment marked as done!']);
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Admin Dashboard - ETEC Center</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800;14..32,900&family=Khmer&family=Moul&family=Nokora:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Nokora', 'Inter', 'Khmer', 'Segoe UI', system-ui, sans-serif;
            background: radial-gradient(circle at 20% 30%, #0b00c4, #02006e);
            min-height: 100vh;
            padding: 20px;
        }

        /* Hero Background */
        .hero-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            opacity: 0.08;
            background-image: url('https://scontent.fpnh5-3.fna.fbcdn.net/v/t39.30808-6/718675229_1688689795712419_5978467431059090522_n.jpg?stp=dst-jpg_tt6&cstp=mx864x864&ctp=p526x296&_nc_cat=104&ccb=1-7&_nc_sid=127cfc&_nc_eui2=AeGf_umBXPfYYpsW4kfpSYG6kKA-rXk9GyyQoD6teT0bLId9yJ6ZjY6QEgNYlqnOcC05dY0_0tFP7ymk3jiRUvqR&_nc_ohc=2voHNNPM3xwQ7kNvwGjJdvz&_nc_oc=AdqAUUB_4dF5H_Kxl76uEoURV9cFeeBqAjsYk-hprlBeLpxW_rUqvi46NrLe9KeMbaU&_nc_zt=23&_nc_ht=scontent.fpnh5-3.fna&_nc_gid=oc8Ux5fk2kwUjlcdvV-bOw&_nc_ss=7b2a8&oh=00_Af9e1n7MvIlEXJxLaHTeq8vhafEiyWVr9TxHsNokCdySVw&oe=6A2991F7');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .dashboard-container {
            position: relative;
            z-index: 2;
            max-width: 1400px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.98);
            border-radius: 28px;
            padding: 30px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 215, 0, 0.4);
        }

        h1 {
            font-family: 'Moul', 'Nokora', cursive;
            color: #0b00b3;
            margin-bottom: 30px;
            text-align: center;
            font-size: 2rem;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, #f0f2ff, #ffffff);
            padding: 20px;
            border-radius: 20px;
            text-align: center;
            border: 1px solid rgba(11, 0, 179, 0.1);
            transition: all 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .stat-card h3 {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #0b00b3, #2b1aff);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .stat-number.pending {
            background: linear-gradient(135deg, #FF9800, #F57C00);
            -webkit-background-clip: text;
            background-clip: text;
        }

        .stat-number.success {
            background: linear-gradient(135deg, #4CAF50, #388E3C);
            -webkit-background-clip: text;
            background-clip: text;
        }

        /* Filters */
        .filters {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .filters input, .filters select {
            padding: 12px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 60px;
            font-size: 0.85rem;
            font-family: 'Nokora', sans-serif;
            flex: 1;
            min-width: 150px;
            background: white;
            transition: all 0.3s;
        }

        .filters input:focus, .filters select:focus {
            outline: none;
            border-color: #0b00b3;
            box-shadow: 0 0 0 3px rgba(11, 0, 179, 0.1);
        }

        /* Table */
        .student-table {
            width: 100%;
            overflow-x: auto;
            border-radius: 20px;
        }

        .student-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .student-table th {
            background: linear-gradient(135deg, #0b00b3, #09008e);
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .student-table th:first-child { border-radius: 20px 0 0 0; }
        .student-table th:last-child { border-radius: 0 20px 0 0; }

        .student-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 0.8rem;
        }

        .student-table tr:hover {
            background: #f8f9ff;
        }

        /* Payment Badges */
        .payment-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 60px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .badge-pending {
            background: #FFF3E0;
            color: #FF9800;
        }

        .badge-paid {
            background: #E8F5E9;
            color: #4CAF50;
        }

        /* Buttons */
        .btn-mark-paid {
            background: linear-gradient(135deg, #4CAF50, #388E3C);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 60px;
            cursor: pointer;
            font-size: 0.7rem;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-mark-paid:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
        }

        .btn-paid {
            background: #9E9E9E;
            cursor: not-allowed;
        }

        .no-data {
            text-align: center;
            padding: 60px;
            color: #999;
            font-size: 0.9rem;
        }

        /* Back Button */
        .back-home {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: rgba(255, 255, 240, 0.2);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 215, 0, 0.5);
            color: white;
            padding: 10px 24px;
            border-radius: 60px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            z-index: 100;
            text-decoration: none;
            font-family: 'Nokora', sans-serif;
        }

        .back-home:hover {
            background: rgba(255, 215, 0, 0.3);
            transform: translateX(-6px);
            gap: 14px;
        }

        /* Toast Message */
        .toast-message {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 2000;
            padding: 15px 25px;
            border-radius: 12px;
            font-weight: 500;
            animation: slideIn 0.3s ease-out;
            max-width: 350px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .toast-success {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            border-left: 5px solid #FFD700;
        }

        .toast-error {
            background: linear-gradient(135deg, #f44336, #d32f2f);
            color: white;
            border-left: 5px solid #FFD700;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Confirmation Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 28px;
            padding: 35px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            animation: modalPop 0.3s ease-out;
        }

        @keyframes modalPop {
            from {
                transform: scale(0.8);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .modal-icon {
            font-size: 4rem;
            margin-bottom: 15px;
        }

        .modal-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #0b00b3;
            margin-bottom: 10px;
        }

        .modal-message {
            color: #666;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .modal-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .modal-btn {
            padding: 10px 25px;
            border-radius: 60px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            font-family: 'Nokora', sans-serif;
            transition: all 0.3s;
        }

        .modal-btn-confirm {
            background: linear-gradient(135deg, #4CAF50, #388E3C);
            color: white;
        }

        .modal-btn-confirm:hover {
            transform: translateY(-2px);
        }

        .modal-btn-cancel {
            background: #e0e0e0;
            color: #333;
        }

        .modal-btn-cancel:hover {
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .dashboard-container {
                padding: 20px;
            }
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }
            .stat-number {
                font-size: 1.8rem;
            }
            .filters {
                flex-direction: column;
            }
            .student-table td, .student-table th {
                padding: 8px;
                font-size: 0.7rem;
            }
            .btn-mark-paid {
                padding: 5px 12px;
                font-size: 0.6rem;
            }
            .back-home {
                bottom: 15px;
                right: 15px;
                padding: 8px 18px;
                font-size: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="hero-bg"></div>
    
    <a href="../index.php" class="back-home">
        <span>←</span> Back to Home
    </a>
    
    <div class="dashboard-container">
        <h1>📊 ETEC Center Admin Dashboard</h1>
        
        <div class="stats-grid">
            <?php
            $total_query = "SELECT COUNT(*) as total FROM students";
            $total_result = mysqli_query($conn, $total_query);
            $total = mysqli_fetch_assoc($total_result)['total'];
            
            $pending_query = "SELECT COUNT(*) as pending FROM students WHERE payment_status='pending' OR payment_status IS NULL";
            $pending_result = mysqli_query($conn, $pending_query);
            $pending = mysqli_fetch_assoc($pending_result)['pending'];
            
            $done_query = "SELECT COUNT(*) as done FROM students WHERE payment_status='done'";
            $done_result = mysqli_query($conn, $done_query);
            $done = mysqli_fetch_assoc($done_result)['done'];
            
            $today_query = "SELECT COUNT(*) as today FROM students WHERE DATE(spin_date) = CURDATE()";
            $today_result = mysqli_query($conn, $today_query);
            $today = mysqli_fetch_assoc($today_result)['today'];
            
            $revenue_query = "SELECT SUM(final_price) as total FROM students WHERE payment_status='done'";
            $revenue_result = mysqli_query($conn, $revenue_query);
            $revenue = mysqli_fetch_assoc($revenue_result)['total'];
            ?>
            
            <div class="stat-card">
                <h3>👨‍🎓 Total Students</h3>
                <p class="stat-number"><?php echo $total; ?></p>
            </div>
            <div class="stat-card">
                <h3>📅 Today's Registrations</h3>
                <p class="stat-number"><?php echo $today; ?></p>
            </div>
            <div class="stat-card">
                <h3>⏳ Pending Payment</h3>
                <p class="stat-number pending"><?php echo $pending; ?></p>
            </div>
            <div class="stat-card">
                <h3>✅ Completed</h3>
                <p class="stat-number success"><?php echo $done; ?></p>
            </div>
            <div class="stat-card">
                <h3>💰 Total Revenue</h3>
                <p class="stat-number success">$<?php echo number_format($revenue ? $revenue : 0, 2); ?></p>
            </div>
        </div>
        
        <div class="filters">
            <input type="text" id="searchInput" placeholder="🔍 Search by name or phone...">
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
    
    <!-- Confirmation Modal -->
    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <div class="modal-icon">✅</div>
            <div class="modal-title">Confirm Payment</div>
            <div class="modal-message" id="modalMessage">Are you sure you want to mark this payment as completed?</div>
            <div class="modal-buttons">
                <button class="modal-btn modal-btn-cancel" onclick="closeModal()">Cancel</button>
                <button class="modal-btn modal-btn-confirm" onclick="confirmMarkPaid()">Confirm</button>
            </div>
        </div>
    </div>
    
    <script>
    let selectedStudentId = null;
    let selectedStudentName = null;
    
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
            },
            error: function() {
                $('#studentList').html('<div class="no-data">Error loading students</div>');
            }
        });
    }
    
    function markAsPaid(id, name) {
        selectedStudentId = id;
        selectedStudentName = name;
        document.getElementById('modalMessage').innerHTML = `Are you sure you want to mark <strong>${name}</strong> as paid?`;
        document.getElementById('confirmModal').style.display = 'flex';
    }
    
    function confirmMarkPaid() {
        if (selectedStudentId) {
            $.ajax({
                url: 'index.php',
                method: 'POST',
                data: {mark_paid_id: selectedStudentId},
                dataType: 'json',
                success: function(response) {
                    closeModal();
                    if (response.success) {
                        showToast(response.message, 'success');
                        loadStudents();
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        showToast(response.message, 'error');
                    }
                },
                error: function() {
                    closeModal();
                    showToast('Error updating payment status', 'error');
                }
            });
        }
    }
    
    function closeModal() {
        document.getElementById('confirmModal').style.display = 'none';
        selectedStudentId = null;
        selectedStudentName = null;
    }
    
    function showToast(message, type) {
        const toast = document.createElement('div');
        toast.className = `toast-message toast-${type}`;
        toast.innerHTML = message;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 3000);
    }
    
    $(document).ready(function() {
        loadStudents();
        $('#searchInput, #paymentFilter, #dateFilter').on('keyup change', function() {
            loadStudents();
        });
    });
    
    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('confirmModal');
        if (event.target == modal) {
            closeModal();
        }
    }
    </script>
</body>
</html>