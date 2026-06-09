<?php
session_start();
include 'config/database.php';

if(!isset($_SESSION['student_id'])) {
    header("Location: student_form.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$query = "SELECT * FROM students WHERE id = $student_id";
$result = mysqli_query($conn, $query);
$student = mysqli_fetch_assoc($result);

// Calculate discount amount
$discountAmount = $student['course_price'] * $student['spin_discount'] / 100;
$savedPercentage = ($discountAmount / $student['course_price']) * 100;

// Calculate payment amounts
$finalPrice = $student['final_price'];
$payFiftyPercent = $finalPrice * 0.5;
$payHundredPercent = $finalPrice;

// Add payment columns to database if they don't exist
$columnsToAdd = [
    "payment_status" => "VARCHAR(50) DEFAULT 'pending'",
    "amount_paid" => "DECIMAL(10,2) DEFAULT 0",
    "remaining_balance" => "DECIMAL(10,2) DEFAULT 0",
    "payment_type" => "VARCHAR(100) DEFAULT NULL",
    "payment_date" => "DATETIME DEFAULT NULL"
];

foreach ($columnsToAdd as $columnName => $columnDefinition) {
    $checkQuery = "SHOW COLUMNS FROM students LIKE '$columnName'";
    $checkResult = mysqli_query($conn, $checkQuery);
    if (mysqli_num_rows($checkResult) == 0) {
        $alterQuery = "ALTER TABLE students ADD COLUMN $columnName $columnDefinition";
        mysqli_query($conn, $alterQuery);
    }
}

// Telegram Bot Configuration
$botToken = "8455209566:AAGqXq4zAK3X2mpLzaslNvv8HoeuaAi1maw";

// Multiple Chat IDs - Added new Chat ID 236820092
$chatIds = [
    "1397865732",  // Main Admin (ហុង គីមឆាយ - HONG KIMCHHAY)
    "6960648008",  // Second Admin (គង់ជឿន ជីវ័ន្ដ- KONG CHOUERNCHYWORN)
    "236820092"    // New Admin Chat ID
];

// Function to send message to multiple Telegram chats
function sendToTelegramMultiple($botToken, $chatIds, $message) {
    $successCount = 0;
    $telegramUrl = "https://api.telegram.org/bot{$botToken}/sendMessage";
    
    foreach ($chatIds as $chatId) {
        $postData = [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML'
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $telegramUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode == 200) {
            $successCount++;
        }
    }
    
    return $successCount;
}

// Handle payment submission
$paymentMessage = '';
$paymentError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payment_action'])) {
    $paymentAction = $_POST['payment_action'];
    $paymentAmount = 0;
    $paymentType = '';
    
    if ($paymentAction === 'pay_50') {
        $paymentAmount = $payFiftyPercent;
        $paymentType = 'Pay 50%';
    } elseif ($paymentAction === 'pay_100') {
        $paymentAmount = $payHundredPercent;
        $paymentType = 'Pay 100%';
    } elseif ($paymentAction === 'pay_next_time') {
        $paymentType = 'Pay Next Time';
        $paymentAmount = 0;
    }
    
    // Prepare message for Telegram
    $message = "━━━━━━━━━━━━━━━━━━━━\n";
    $message .= "🎓 <b>NEW STUDENT PAYMENT</b> 🎓\n";
    $message .= "━━━━━━━━━━━━━━━━━━━━\n\n";
    $message .= "👤 <b>Student Information:</b>\n";
    $message .= "├ Name: {$student['fullname']}\n\n";
    $message .= "📚 <b>Course Details:</b>\n";
    $message .= "├ Course: {$student['course_name']}\n";
    $message .= "├ Schedule: {$student['course_schedule']}\n";
    $message .= "└ Original Price: $" . number_format($student['course_price'], 2) . "\n\n";
    $message .= "🎲 <b>Spin Result:</b>\n";
    $message .= "├ Discount: {$student['spin_discount']}% OFF\n";
    $message .= "├ Discount Amount: -$" . number_format($discountAmount, 2) . "\n";
    $message .= "└ Final Price: $" . number_format($finalPrice, 2) . "\n\n";
    $message .= "💰 <b>Payment Details:</b>\n";
    $message .= "├ Payment Type: {$paymentType}\n";
    $message .= "\n━━━━━━━━━━━━━━━━━━━━\n";
    $message .= "📍 ETEC Center";
    
    // Send to multiple Telegram chats
    $sentCount = sendToTelegramMultiple($botToken, $chatIds, $message);
    
    // Set payment status to 'done' for both pay_50 and pay_100
    if ($paymentAction === 'pay_100') {
        $paymentStatus = 'done';
        $amountPaid = $finalPrice;
        $remainingBalance = 0;
    } elseif ($paymentAction === 'pay_50') {
        $paymentStatus = 'done';
        $amountPaid = $payFiftyPercent;
        $remainingBalance = $finalPrice - $payFiftyPercent;
    } else {
        $paymentStatus = 'pending';
        $amountPaid = 0;
        $remainingBalance = $finalPrice;
    }
    
    $updateQuery = "UPDATE students SET 
                    payment_status = '$paymentStatus',
                    amount_paid = '$amountPaid',
                    remaining_balance = '$remainingBalance',
                    payment_type = '$paymentType',
                    payment_date = NOW()
                    WHERE id = $student_id";
    
    if (mysqli_query($conn, $updateQuery)) {
        // Clear session and redirect to student_form.php after successful payment
        session_destroy();
        
        // Store success message in session for display on student_form.php
        session_start();
        if ($sentCount > 0) {
            $_SESSION['payment_success'] = "✓ Payment of $" . number_format($paymentAmount, 2) . " recorded successfully! Notification sent to " . $sentCount . " admin(s).";
        } else {
            $_SESSION['payment_success'] = "✓ Payment of $" . number_format($paymentAmount, 2) . " recorded successfully!";
        }
        if ($paymentAction === 'pay_next_time') {
            $_SESSION['payment_success'] = "✓ You have chosen to pay later. Please visit our center to complete payment.";
        }
        
        // Redirect header
        header("Location: student_form.php");
        exit();
    } else {
        $paymentError = "⚠️ Failed to record payment: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Payment Summary - ETEC Center</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800;14..32,900&family=Khmer&family=Moul&family=Nokora:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <style>
        /* Your existing CSS remains exactly the same */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            height: 100%;
            width: 100%;
            position: fixed;
        }

        body {
            font-family: 'Nokora', 'Inter', 'Khmer', 'Segoe UI', system-ui, sans-serif;
        }

        ::-webkit-scrollbar { display: none; }
        html { scrollbar-width: none; }
        body { -ms-overflow-style: none; }

        .hero-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            opacity: 0.12;
            background-image: url('https://scontent.fpnh5-3.fna.fbcdn.net/v/t39.30808-6/718675229_1688689795712419_5978467431059090522_n.jpg?stp=dst-jpg_tt6&cstp=mx864x864&ctp=p526x296&_nc_cat=104&ccb=1-7&_nc_sid=127cfc&_nc_eui2=AeGf_umBXPfYYpsW4kfpSYG6kKA-rXk9GyyQoD6teT0bLId9yJ6ZjY6QEgNYlqnOcC05dY0_0tFP7ymk3jiRUvqR&_nc_ohc=2voHNNPM3xwQ7kNvwGjJdvz&_nc_oc=AdqAUUB_4dF5H_Kxl76uEoURV9cFeeBqAjsYk-hprlBeLpxW_rUqvi46NrLe9KeMbaU&_nc_zt=23&_nc_ht=scontent.fpnh5-3.fna&_nc_gid=oc8Ux5fk2kwUjlcdvV-bOw&_nc_ss=7b2a8&oh=00_Af9e1n7MvIlEXJxLaHTeq8vhafEiyWVr9TxHsNokCdySVw&oe=6A2991F7');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            filter: blur(3px);
        }

        .hero-bg::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(11,0,180,0.7), rgba(2,0,110,0.85));
        }

        .pattern-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
            background-image: 
                repeating-linear-gradient(45deg, rgba(255,255,255,0.02) 0px, rgba(255,255,255,0.02) 2px, transparent 2px, transparent 10px),
                repeating-linear-gradient(135deg, rgba(255,215,0,0.02) 0px, rgba(255,215,0,0.02) 3px, transparent 3px, transparent 15px);
        }

        .poster-result {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: radial-gradient(circle at 20% 30%, #0b00c4, #02006e);
            overflow-y: auto;
            overflow-x: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
        }

        .poster-result::-webkit-scrollbar {
            display: none;
        }

        .back-home {
            position: fixed;
            top: 20px;
            left: 20px;
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

        .poster-content {
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            padding: 80px 30px 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .horizontal-card {
            display: flex;
            flex-wrap: wrap;
            background: rgba(255, 255, 255, 0.98);
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
            width: 100%;
            border: 1px solid rgba(255, 215, 0, 0.4);
        }

        .card-left {
            flex: 0 0 280px;
            background: linear-gradient(145deg, #0b00b3, #09008e);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            text-align: center;
            position: relative;
        }

        .etec-logo {
            margin-bottom: 30px;
        }

        .logo-img {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 28px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
            border: 3px solid #FFD966;
        }

        .logo-text {
            font-family: 'Moul', 'Nokora', cursive;
            font-size: 1.4rem;
            font-weight: 700;
            color: #ffffff;
            margin-top: 15px;
            letter-spacing: 2px;
        }

        .success-stamp {
            margin-top: 20px;
        }

        .stamp-text {
            font-size: 0.9rem;
            font-weight: 600;
            color: #FFE484;
            letter-spacing: 2px;
            text-transform: uppercase;
            background: rgba(255,255,255,0.15);
            padding: 8px 16px;
            border-radius: 40px;
            display: inline-block;
        }

        .ribbon {
            position: absolute;
            bottom: 20px;
            left: 20px;
            background: #FFD700;
            color: #0b00b3;
            padding: 6px 18px;
            font-weight: 800;
            font-size: 0.7rem;
            border-radius: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .card-right {
            flex: 1;
            padding: 35px 40px;
            background: #ffffff;
        }

        .poster-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid rgba(11, 0, 179, 0.1);
        }

        .poster-header h1 {
            font-size: 2rem;
            font-family: 'Moul', 'Nokora', cursive;
            color: #0b00b3;
            margin-bottom: 8px;
        }

        .poster-header p {
            color: #666;
            font-size: 0.85rem;
        }

        .discount-hero {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: linear-gradient(135deg, #f8f9ff, #f0f2ff);
            border-radius: 32px;
        }

        .discount-label {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }

        .discount-value {
            font-size: 4rem;
            font-weight: 900;
            background: linear-gradient(135deg, #0b00b3, #2b1aff);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            line-height: 1;
        }

        .discount-off {
            font-size: 1.6rem;
            font-weight: 800;
            color: #FFB347;
            margin-left: 8px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }

        .info-block {
            text-align: center;
            padding: 15px 10px;
            background: #f0f2ff;
            border-radius: 20px;
            transition: transform 0.3s;
        }

        .info-block:hover {
            transform: translateY(-3px);
        }

        .block-title {
            font-size: 0.7rem;
            color: #888;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .block-value {
            font-size: 0.9rem;
            font-weight: 700;
            color: #0b00b3;
            word-break: break-word;
        }

        .price-summary {
            background: linear-gradient(135deg, #f0f2ff, #ffffff);
            border-radius: 24px;
            padding: 20px;
            margin-bottom: 25px;
            border: 1px solid rgba(11,0,179,0.1);
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            font-size: 0.9rem;
        }

        .price-row.original {
            border-bottom: 1px solid #e0e0e0;
        }

        .price-row.saved {
            color: #000000;
            font-weight: 700;
            font-size: 0.95rem;
        }

        .price-row.final {
            border-top: 2px solid #FFB347;
            margin-top: 8px;
            padding-top: 14px;
            font-size: 1.2rem;
            font-weight: 800;
            color: #0b00b3;
        }

        .savings-bar-container {
            margin-bottom: 25px;
        }

        .savings-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 0.75rem;
            color: #666;
        }

        .savings-bar-bg {
            height: 8px;
            background: #e0e0e0;
            border-radius: 20px;
            overflow: hidden;
        }

        .savings-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #000596, #000569);
            border-radius: 20px;
            width: 0;
            animation: fillBar 1s ease-out forwards;
        }

        @keyframes fillBar {
            from { width: 0; }
            to { width: var(--width); }
        }

        .payment-options {
            margin-bottom: 25px;
        }

        .payment-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: #0b00b3;
            text-align: center;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .payment-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-payment {
            flex: 1;
            min-width: 140px;
            padding: 14px 20px;
            border: none;
            border-radius: 60px;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s;
            font-family: 'Nokora', sans-serif;
        }

        .btn-pay-50 {
            background: linear-gradient(135deg, #2196F3, #1976D2);
            color: white;
        }

        .btn-pay-50:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(33, 150, 243, 0.4);
        }

        .btn-pay-100 {
            background: linear-gradient(135deg, #4CAF50, #388E3C);
            color: white;
        }

        .btn-pay-100:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(76, 175, 80, 0.4);
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .btn-action {
            flex: 1;
            padding: 14px 20px;
            border: none;
            border-radius: 60px;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s;
            text-decoration: none;
            font-family: 'Nokora', sans-serif;
        }

        .btn-new {
            background: linear-gradient(135deg, #f2ff00, #fbff00);
            color: black;
        }

        .btn-new:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 140, 66, 0.4);
        }

        .alert-message {
            position: fixed;
            top: 20px;
            right: 20px;
            left: auto;
            z-index: 2000;
            padding: 15px 25px;
            border-radius: 12px;
            font-weight: 500;
            animation: slideIn 0.3s ease-out;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            max-width: 350px;
        }

        .alert-success {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            border-left: 5px solid #FFD700;
        }

        .alert-error {
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

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(5px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 28px;
            padding: 30px;
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
            font-size: 1.5rem;
            font-weight: 700;
            color: #0b00b3;
            margin-bottom: 10px;
        }

        .modal-message {
            color: #666;
            margin-bottom: 25px;
            line-height: 1.5;
        }

        .modal-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .modal-btn {
            background: linear-gradient(135deg, #0b00b3, #09008e);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 60px;
            font-weight: 700;
            cursor: pointer;
            font-family: 'Nokora', sans-serif;
        }

        .modal-btn-cancel {
            background: #e0e0e0;
            color: #333;
        }

        .confetti {
            position: fixed;
            width: 8px;
            height: 8px;
            top: -10px;
            animation: confettiFall 3s linear forwards;
            pointer-events: none;
            z-index: 1000;
        }

        @keyframes confettiFall {
            to {
                transform: translateY(100vh) rotate(360deg);
                opacity: 0;
            }
        }

        @media (max-width: 900px) {
            .horizontal-card {
                flex-direction: column;
            }
            .card-left {
                flex: 0 0 auto;
                padding: 30px 20px;
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
                gap: 20px;
            }
            .etec-logo {
                margin-bottom: 0;
                display: flex;
                align-items: center;
                gap: 15px;
            }
            .logo-img {
                width: 70px;
                height: 70px;
            }
            .logo-text {
                margin-top: 0;
                font-size: 1.1rem;
            }
            .success-stamp {
                margin-top: 0;
            }
            .ribbon {
                bottom: 10px;
                left: 10px;
                font-size: 0.6rem;
            }
            .card-right {
                padding: 25px;
            }
        }

        @media (max-width: 600px) {
            .card-left {
                flex-direction: column;
                text-align: center;
            }
            .etec-logo {
                flex-direction: column;
            }
            .poster-header h1 {
                font-size: 1.5rem;
            }
            .discount-value {
                font-size: 3rem;
            }
            .discount-off {
                font-size: 1.2rem;
            }
            .info-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }
            .payment-buttons {
                flex-direction: column;
            }
            .btn-payment {
                width: 100%;
            }
            .action-buttons {
                flex-direction: column;
                gap: 10px;
            }
            .card-right {
                padding: 20px;
            }
            .back-home {
                top: 15px;
                left: 15px;
                padding: 7px 18px;
                font-size: 0.75rem;
            }
        }

        @media (max-height: 650px) {
            .card-right {
                padding: 20px;
            }
            .discount-hero {
                margin-bottom: 20px;
                padding: 15px;
            }
            .info-grid {
                margin-bottom: 20px;
            }
            .price-summary {
                margin-bottom: 15px;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="hero-bg"></div>
    <div class="pattern-overlay"></div>

    <a href="index.php" class="back-home">
        <span>←</span> Back to Home
    </a>
    
    <div class="poster-result">
        <div class="poster-content">
            <div class="horizontal-card">
                <div class="card-left">
                    <div class="etec-logo">
                        <img class="logo-img" src="https://scontent.fpnh5-3.fna.fbcdn.net/v/t39.30808-6/718675229_1688689795712419_5978467431059090522_n.jpg?stp=dst-jpg_tt6&cstp=mx864x864&ctp=p526x296&_nc_cat=104&ccb=1-7&_nc_sid=127cfc&_nc_eui2=AeGf_umBXPfYYpsW4kfpSYG6kKA-rXk9GyyQoD6teT0bLId9yJ6ZjY6QEgNYlqnOcC05dY0_0tFP7ymk3jiRUvqR&_nc_ohc=2voHNNPM3xwQ7kNvwGjJdvz&_nc_oc=AdqAUUB_4dF5H_Kxl76uEoURV9cFeeBqAjsYk-hprlBeLpxW_rUqvi46NrLe9KeMbaU&_nc_zt=23&_nc_ht=scontent.fpnh5-3.fna&_nc_gid=oc8Ux5fk2kwUjlcdvV-bOw&_nc_ss=7b2a8&oh=00_Af9e1n7MvIlEXJxLaHTeq8vhafEiyWVr9TxHsNokCdySVw&oe=6A2991F7" alt="ETEC Center Logo">
                        <div class="logo-text">គ្រូអាយធីចិត្តល្អ</div>
                    </div>
                    <div class="success-stamp">
                        <div class="stamp-text">PAYMENT SUMMARY</div>
                    </div>
                    <div class="ribbon">CONFIRMED</div>
                </div>
                
                <div class="card-right">
                    <div class="poster-header">
                        <h1>Congratulations <?php echo htmlspecialchars($student['fullname']); ?>!</h1>
                        <p>Your registration has been successfully confirmed</p>
                    </div>
                    
                    <div class="discount-hero">
                        <div class="discount-label">You Saved</div>
                        <div>
                            <span class="discount-value"><?php echo $student['spin_discount']; ?></span>
                            <span class="discount-off">% OFF</span>
                        </div>
                    </div>
                    
                    <div class="info-grid">
                        <div class="info-block">
                            <div class="block-title">Student</div>
                            <div class="block-value"><?php echo htmlspecialchars($student['fullname']); ?></div>
                        </div>
                        <div class="info-block">
                            <div class="block-title">Course</div>
                            <div class="block-value"><?php echo htmlspecialchars($student['course_name']); ?></div>
                        </div>
                        <div class="info-block">
                            <div class="block-title">Schedule</div>
                            <div class="block-value"><?php echo htmlspecialchars($student['course_schedule']); ?></div>
                        </div>
                    </div>
                    
                    <div class="price-summary">
                        <div class="price-row original">
                            <span>Original Price</span>
                            <span>$<?php echo number_format($student['course_price'], 2); ?></span>
                        </div>
                        <div class="price-row saved">
                            <span>Discount Applied (<?php echo $student['spin_discount']; ?>%)</span>
                            <span>-$<?php echo number_format($discountAmount, 2); ?></span>
                        </div>
                        <div class="price-row final">
                            <span>Final Payment</span>
                            <span>$<?php echo number_format($student['final_price'], 2); ?></span>
                        </div>
                    </div>
                    
                    <div class="savings-bar-container">
                        <div class="savings-label">
                            <span>Savings Achieved</span>
                            <span><?php echo round($savedPercentage, 0); ?>%</span>
                        </div>
                        <div class="savings-bar-bg">
                            <div class="savings-bar-fill" style="--width: <?php echo $savedPercentage; ?>%"></div>
                        </div>
                    </div>
                    
                    <div class="payment-options">
                        <div class="payment-title">Select Payment Method</div>
                        <div class="payment-buttons">
                            <button class="btn-payment btn-pay-50" onclick="showPaymentModal('pay_50', '<?php echo number_format($payFiftyPercent, 2); ?>')">
                                💰 Pay 50% <span style="font-size:0.7rem;">($<?php echo number_format($payFiftyPercent, 2); ?>)</span>
                            </button>
                            <button class="btn-payment btn-pay-100" onclick="showPaymentModal('pay_100', '<?php echo number_format($payHundredPercent, 2); ?>')">
                                ✅ Pay 100% <span style="font-size:0.7rem;">($<?php echo number_format($payHundredPercent, 2); ?>)</span>
                            </button>
                        </div>
                    </div>
                    
                    <div class="action-buttons">
                        <a href="student_form.php" class="btn-action btn-new">
                            🎡 New Spin
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div id="paymentModal" class="modal">
        <div class="modal-content">
            <div class="modal-icon" id="modalIcon">💰</div>
            <div class="modal-title" id="modalTitle">Confirm Payment</div>
            <div class="modal-message" id="modalMessage"></div>
            <form method="POST" id="paymentForm">
                <input type="hidden" name="payment_action" id="paymentAction">
                <div class="modal-buttons">
                    <button type="button" class="modal-btn modal-btn-cancel" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="modal-btn">Confirm</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function showPaymentModal(action, amount) {
            const modal = document.getElementById('paymentModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalMessage = document.getElementById('modalMessage');
            const modalIcon = document.getElementById('modalIcon');
            
            if (action === 'pay_50') {
                modalTitle.innerHTML = 'Confirm 50% Payment';
                modalMessage.innerHTML = `You are about to make a 50% down payment of <strong>$${amount}</strong>.<br><br>The remaining balance of <strong>$<?php echo number_format($finalPrice - $payFiftyPercent, 2); ?></strong> will be due later.<br><br>Do you want to proceed?`;
                modalIcon.innerHTML = '💰';
            } else if (action === 'pay_100') {
                modalTitle.innerHTML = 'Confirm Full Payment';
                modalMessage.innerHTML = `You are about to pay the full amount of <strong>$${amount}</strong>.<br><br>This will complete your payment.<br><br>Do you want to proceed?`;
                modalIcon.innerHTML = '✅';
            }
            
            document.getElementById('paymentAction').value = action;
            modal.style.display = 'flex';
        }
        
        function closeModal() {
            document.getElementById('paymentModal').style.display = 'none';
        }
        
        window.onclick = function(event) {
            const modal = document.getElementById('paymentModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
        
        // Confetti animation
        document.addEventListener('DOMContentLoaded', function() {
            const colors = ['#0b00b3', '#2b1aff', '#FFB347', '#00C853', '#667eea', '#4CAF50', '#FF9800'];
            for(let i = 0; i < 80; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                confetti.style.left = Math.random() * 100 + '%';
                confetti.style.animationDelay = Math.random() * 2.5 + 's';
                confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.width = Math.random() * 10 + 4 + 'px';
                confetti.style.height = confetti.style.width;
                confetti.style.borderRadius = Math.random() > 0.5 ? '50%' : '0';
                document.body.appendChild(confetti);
                
                setTimeout(() => {
                    confetti.remove();
                }, 3000);
            }
        });
    </script>
</body>
</html>