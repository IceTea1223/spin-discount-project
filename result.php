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

        /* Hero Background */
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

        /* Main Container */
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

        /* Back Button */
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

        /* Main Content - Horizontal Layout */
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

        /* Horizontal Card Layout */
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

        /* Left Section - Logo & Success */
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

        /* Right Section - Content */
        .card-right {
            flex: 1;
            padding: 35px 40px;
            background: #ffffff;
        }

        /* Header */
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

        /* Discount Hero */
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

        /* Info Grid - 3 columns */
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

        /* Price Summary */
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

        /* Savings Bar */
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

        /* Action Buttons */
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

        /* Confetti Animation */
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

        /* Responsive */
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
    <!-- Background Layers -->
    <div class="hero-bg"></div>
    <div class="pattern-overlay"></div>

    <!-- Back Button -->
    <a href="index.php" class="back-home">
        <span>←</span> Back to Home
    </a>
    
    <div class="poster-result">
        <div class="poster-content">
            <!-- Horizontal Card Layout -->
            <div class="horizontal-card">
                <!-- Left Section - ETEC Logo -->
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
                
                <!-- Right Section - Content -->
                <div class="card-right">
                    <div class="poster-header">
                        <h1>Congratulations</h1>
                        <p>Your registration has been successfully confirmed</p>
                    </div>
                    
                    <!-- Discount Hero -->
                    <div class="discount-hero">
                        <div class="discount-label">You Saved</div>
                        <div>
                            <span class="discount-value"><?php echo $student['spin_discount']; ?></span>
                            <span class="discount-off">% OFF</span>
                        </div>
                    </div>
                    
                    <!-- Info Grid -->
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
                    
                    <!-- Price Summary -->
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
                    
                    <!-- Savings Bar -->
                    <div class="savings-bar-container">
                        <div class="savings-label">
                            <span>Savings Achieved</span>
                            <span><?php echo round($savedPercentage, 0); ?>%</span>
                        </div>
                        <div class="savings-bar-bg">
                            <div class="savings-bar-fill" style="--width: <?php echo $savedPercentage; ?>%"></div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <a href="student_form.php" class="btn-action btn-new">
                            New Spin
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Confetti animation
        document.addEventListener('DOMContentLoaded', function() {
            const colors = ['#0b00b3', '#2b1aff', '#FFB347', '#00C853', '#667eea'];
            for(let i = 0; i < 60; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                confetti.style.left = Math.random() * 100 + '%';
                confetti.style.animationDelay = Math.random() * 2.5 + 's';
                confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.width = Math.random() * 8 + 4 + 'px';
                confetti.style.height = confetti.style.width;
                document.body.appendChild(confetti);
                
                setTimeout(() => {
                    confetti.remove();
                }, 3000);
            }
        });
    </script>
</body>
</html>