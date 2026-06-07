<?php
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function calculateDiscount($price, $discountPercent) {
    $discountAmount = $price * $discountPercent / 100;
    return [
        'discount_amount' => $discountAmount,
        'final_price' => $price - $discountAmount
    ];
}

function getPaymentStatusBadge($status) {
    if($status == 'done') {
        return '<span class="badge badge-success">✓ Paid</span>';
    }
    return '<span class="badge badge-warning">⏳ Pending</span>';
}

// Function to get course data from JSON (if passed from JS)
function getCoursesFromJson($jsonData) {
    return json_decode($jsonData, true);
}

// Function to calculate total price for enrollment
function calculateEnrollmentTotal($courseId, $scheduleIndex, $discountPercent = 0) {
    // This would typically fetch from database
    // Example implementation:
    $price = getCoursePriceFromDB($courseId, $scheduleIndex);
    
    if($discountPercent > 0) {
        $discountInfo = calculateDiscount($price, $discountPercent);
        return $discountInfo['final_price'];
    }
    
    return $price;
}

// Example usage in PHP
function displayCourseSchedule($course) {
    $html = '<div class="course-schedule">';
    $html .= '<h3>' . htmlspecialchars($course['course']) . '</h3>';
    $html .= '<ul>';
    
    foreach($course['schedules'] as $schedule) {
        $html .= '<li>';
        $html .= $schedule['day'] . ' - ' . $schedule['time'] . ' - ';
        $html .= '<strong>$' . $schedule['price'] . '</strong>';
        $html .= '</li>';
    }
    
    $html .= '</ul></div>';
    return $html;
}
?>