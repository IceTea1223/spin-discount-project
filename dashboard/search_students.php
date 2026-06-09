<?php
include '../config/database.php';

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$payment = isset($_GET['payment']) ? $_GET['payment'] : 'all';
$dateRange = isset($_GET['date_range']) ? $_GET['date_range'] : 'all';

$whereConditions = [];

if (!empty($search)) {
    $whereConditions[] = "(fullname LIKE '%$search%' OR tel LIKE '%$search%')";
}

if ($payment === 'pending') {
    $whereConditions[] = "(payment_status = 'pending' OR payment_status IS NULL)";
} elseif ($payment === 'done') {
    $whereConditions[] = "payment_status = 'done'";
}

if ($dateRange === 'today') {
    $whereConditions[] = "DATE(spin_date) = CURDATE()";
} elseif ($dateRange === 'week') {
    $whereConditions[] = "YEARWEEK(spin_date) = YEARWEEK(CURDATE())";
} elseif ($dateRange === 'month') {
    $whereConditions[] = "MONTH(spin_date) = MONTH(CURDATE()) AND YEAR(spin_date) = YEAR(CURDATE())";
}

$whereSql = !empty($whereConditions) ? "WHERE " . implode(" AND ", $whereConditions) : "";
$query = "SELECT * FROM students $whereSql ORDER BY spin_date DESC";
$result = mysqli_query($conn, $query);
?>

<div class="student-table">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Student Name</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Course</th>
                <th>Schedule</th>
                <th>Original Price</th>
                <th>Discount</th>
                <th>Final Price</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): 
                    $finalPrice = $row['final_price'];
                    $statusClass = ($row['payment_status'] == 'done') ? 'badge-paid' : 'badge-pending';
                    $statusText = ($row['payment_status'] == 'done') ? '✓ Paid' : '⏳ Pending';
                ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><strong><?php echo htmlspecialchars($row['fullname']); ?></strong></td>
                        <td><?php echo htmlspecialchars($row['tel']); ?></td>
                        <td><?php echo htmlspecialchars($row['gender']); ?></td>
                        <td><?php echo htmlspecialchars($row['course_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['course_schedule']); ?></td>
                        <td>$<?php echo number_format($row['course_price'], 2); ?></td>
                        <td><?php echo $row['spin_discount']; ?>%</td>
                        <td><strong>$<?php echo number_format($finalPrice, 2); ?></strong></td>
                        <td><span class="payment-badge <?php echo $statusClass; ?>"><?php echo $statusText; ?></span></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($row['spin_date'])); ?></td>
                        <td>
                            <?php if ($row['payment_status'] != 'done'): ?>
                                <button class="btn-mark-paid" onclick="markAsPaid(<?php echo $row['id']; ?>, '<?php echo addslashes($row['fullname']); ?>')">
                                    ✅ Mark Paid
                                </button>
                            <?php else: ?>
                                <button class="btn-mark-paid btn-paid" disabled>✓ Completed</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="12" class="no-data">📭 No students found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>