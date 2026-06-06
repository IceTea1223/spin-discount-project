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
?>