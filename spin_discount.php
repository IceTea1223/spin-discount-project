<?php
session_start();

if(!isset($_SESSION['student_id'])) {
    header("Location: student_form.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Spin the Wheel - ETEC Center</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800;14..32,900&family=Khmer&family=Moul&family=Nokora:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            height: 100vh;
            width: 100%;
            position: fixed;
        }

        body {
            font-family: 'Nokora', 'Inter', 'Khmer', 'Segoe UI', system-ui, sans-serif;
            background: radial-gradient(circle at 20% 30%, #0b00c4, #02006e);
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
        .spin-full-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 2;
        }

        .spin-full-container::-webkit-scrollbar { display: none; }

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

        /* Content */
        .spin-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px 20px 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        /* Header */
        .spin-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .spin-title {
            font-size: 2.5rem;
            font-family: 'Moul', 'Nokora', cursive;
            font-weight: 500;
            color: white;
            text-shadow: 0 4px 20px rgba(0,0,0,0.3);
            margin-bottom: 10px;
            margin-top: 0px;
        }

        /* BIGGER Student Card - Premium Large Design */
        .student-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
    border-radius: 32px;
    padding: 20px 22px;
    width: 100%;
    max-width: 400px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
    border: 2px solid rgba(255, 215, 0, 0.4);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.student-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
    border-color: rgba(255, 215, 0, 0.7);
}

/* Card Header - Compact */
.card-header {
    display: flex;
    align-items: center;
    gap: 18px;
    margin-bottom: 20px;
    padding-bottom: 18px;
    border-bottom: 2px solid rgba(11, 0, 179, 0.12);
}

.avatar-circle {
    width: 70px;
    height: 70px;
    background: linear-gradient(145deg, #0b00b3, #2b1aff);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 34px;
    font-weight: 800;
    color: white;
    font-family: 'Moul', cursive;
    box-shadow: 0 8px 18px rgba(0, 0, 0, 0.15);
    border: 2px solid #FFD966;
}

.student-title {
    flex: 1;
}

.student-title h3 {
    font-size: 1.6rem;
    font-weight: 800;
    color: #0b00b3;
    margin-bottom: 5px;
    font-family: 'Nokora', sans-serif;
}

.student-title p {
    font-size: 0.7rem;
    color: #888;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    gap: 6px;
}

/* Info Grid - Compact */
.info-grid-card {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
    margin-bottom: 20px;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    background: #f0f2ff;
    border-radius: 20px;
    transition: all 0.2s ease;
}

.info-item:hover {
    background: #e8eaff;
    transform: translateX(3px);
}

.info-icon {
    width: 42px;
    height: 42px;
    background: linear-gradient(135deg, rgba(11, 0, 179, 0.12), rgba(43, 26, 255, 0.08));
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
}

.info-content {
    flex: 1;
}

.info-label {
    font-size: 0.65rem;
    color: #888;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 3px;
}

.info-value {
    font-size: 0.95rem;
    font-weight: 700;
    color: #0b00b3;
    word-break: break-word;
}

/* Price Section - Compact */
.price-section {
    background: linear-gradient(135deg, #0b00b3, #2b1aff);
    border-radius: 20px;
    padding: 14px 22px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.price-label {
    color: rgba(255, 255, 255, 0.85);
    font-size: 0.85rem;
    letter-spacing: 1px;
    font-weight: 500;
}

.price-amount {
    font-size: 1.8rem;
    font-weight: 900;
    color: #FFD966;
    letter-spacing: 1px;
}

/* Responsive adjustments */
@media (max-width: 600px) {
    .student-card {
        padding: 16px 18px;
        max-width: 100%;
    }
    
    .avatar-circle {
        width: 55px;
        height: 55px;
        font-size: 26px;
    }
    
    .student-title h3 {
        font-size: 1.3rem;
    }
    
    .info-grid-card {
        grid-template-columns: 1fr;
        gap: 10px;
    }
    
    .info-item {
        padding: 10px 14px;
    }
    
    .info-icon {
        width: 36px;
        height: 36px;
        font-size: 1.2rem;
    }
    
    .info-value {
        font-size: 0.85rem;
    }
    
    .price-section {
        padding: 12px 18px;
    }
    
    .price-amount {
        font-size: 1.4rem;
    }
    
    .price-label {
        font-size: 0.75rem;
    }
}
        /* Wheel Section */
        .wheel-section {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .wheel-wrapper {
            position: relative;
            display: inline-block;
        }

        .wheel-center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 20;
        }

        .spin-btn {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: #ffffff;
            border: none;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            position: relative;
            overflow: hidden;
        }

        .spin-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #FFB347, #FF6B35);
            border-radius: 50%;
            z-index: -1;
        }

        .spin-btn:hover {
            transform: scale(1.06);
        }

        .spin-btn.spinning {
            animation: pulseSpin 0.5s ease;
        }

        @keyframes pulseSpin {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .spin-btn-inner {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .spin-text {
            font-size: 28px;
            font-weight: 900;
            background: black;
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            font-family: 'Moul', cursive;
        }

        .wheel-pointer {
            position: absolute;
            top: -38px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 25;
            filter: drop-shadow(0 10px 15px rgba(0,0,0,0.3));
        }

        .pointer {
            width: 0;
            height: 0;
            border-left: 26px solid transparent;
            border-right: 26px solid transparent;
            border-top: 100px solid #FFC107;
        }

        canvas {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            height: 800px;
            border-radius: 50%;
            box-shadow: 0 30px 50px rgba(0, 0, 0, 0.5);
            background: rgba(45,31,158,0.05);
        }

        /* Modal */
        .result-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.88);
    backdrop-filter: blur(20px);
    z-index: 2000;
    align-items: center;
    justify-content: center;
}

.modal-card {
    background: linear-gradient(145deg, #ffffff, #f8f9ff);
    border-radius: 56px;
    padding: 35px 35px 40px;
    max-width: 520px;
    width: 90%;
    text-align: center;
    animation: modalGlide 0.45s cubic-bezier(0.2, 0.9, 0.4, 1.2);
    box-shadow: 0 40px 70px rgba(0, 0, 0, 0.5);
    position: relative;
    border: 1px solid rgba(255, 215, 0, 0.4);
}

@keyframes modalGlide {
    from {
        opacity: 0;
        transform: scale(0.85) translateY(40px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

.modal-close {
    position: absolute;
    top: 22px;
    right: 26px;
    background: rgba(0, 0, 0, 0.05);
    border: none;
    font-size: 32px;
    cursor: pointer;
    color: #999;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: 0.2s;
    font-weight: 300;
}

.modal-close:hover {
    background: rgba(0, 0, 0, 0.1);
    color: #0b00b3;
}

/* Logo Section */
.modal-logo {
    margin-bottom: 20px;
}

.modal-logo-img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    margin-bottom: 10px;
}

.modal-logo-text {
    font-family: 'Nokora', 'Khmer', 'Moul', cursive;
            font-size: 2.2rem;
            font-weight: 800;
            text-align: center;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.3);
            letter-spacing: 1px;
            background: linear-gradient(135deg, #FFE484, #FFB347);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 15px;
    font-size: 1rem;
    font-weight: 700;
    background: linear-gradient(135deg, #0b00b3, #2b1aff);
    background-clip: text;
    -webkit-background-clip: text;
    color: transparent;
    letter-spacing: 2px;
}

.modal-header {
    margin-bottom: 20px;
}

.modal-header h2 {
    font-size: 2rem;
    color: #0b00b3;
    font-weight: 800;
    font-family: 'Moul', cursive;
    margin: 0;
}

.discount-badge {
    background: linear-gradient(135deg, #0b00b3, #2b1aff);
    border-radius: 70px;
    padding: 28px 20px;
    margin-bottom: 28px;
}

.discount-badge div:first-child {
    color: rgba(255, 245, 180, 0.9);
    font-size: 1rem;
    letter-spacing: 2px;
}

.discount-number {
    font-size: 5rem;
    font-weight: 900;
    color: #FFD966;
    display: inline-block;
    text-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.discount-symbol-lg {
    font-size: 2.5rem;
    font-weight: 800;
    color: #FFD966;
}

.price-breakdown {
    margin-bottom: 30px;
}

.price-row {
    display: flex;
    justify-content: space-between;
    padding: 12px 5px;
    font-size: 1rem;
    border-bottom: 1px dashed #ddd;
    font-weight: 500;
}

.price-row.discount {
    color: #00a86b;
    font-weight: 700;
}

.price-row.final {
    font-size: 1.35rem;
    font-weight: 800;
    color: #0b00b3;
    border-top: 2px solid #fcff47;
    margin-top: 8px;
    padding-top: 15px;
    border-bottom: none;
}

.claim-btn {
    width: 100%;
    padding: 16px;
    background: yellow;
    color: black;
    border: none;
    border-radius: 70px;
    font-size: 1.2rem;
    font-weight: 800;
    font-family: 'Nokora', sans-serif;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all 0.3s;
}

.claim-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 28px rgba(0, 200, 83, 0.4);
}

.claim-btn:active {
    transform: translateY(0);
}

@media (max-width: 550px) {
    .modal-card {
        padding: 30px 22px 35px;
    }
    
    .modal-header h2 {
        font-size: 1.5rem;
    }
    
    .discount-number {
        font-size: 3.5rem;
    }
    
    .discount-symbol-lg {
        font-size: 2rem;
    }
    
    .discount-badge {
        padding: 20px 15px;
    }
    
    .price-row {
        font-size: 0.85rem;
    }
    
    .price-row.final {
        font-size: 1.1rem;
        color:black;

    }
    
    .claim-btn {
        font-size: 1rem;
        padding: 14px;
    }
    
    .modal-logo-img {
        width: 65px;
        height: 65px;
    }
}
        /* Flex Container */
        .flex-container {
            display: flex;
            flex-wrap: wrap;
            gap: 60px;
            justify-content: center;
            align-items: center;
        }

        .brand-logo {
            margin-bottom: 20px;
            text-align: center;
        }
        
        .logo-circle {
            width: 180px;
            height: 180px;
            background: linear-gradient(135deg, #ffed66, #FFB347);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        
        .img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 20px;
            transition: transform 0.3s ease;
        }
        
        .img:hover {
            transform: scale(1.05);
        }
        
        .teacher-name {
            font-family: 'Nokora', 'Khmer', 'Moul', cursive;
            font-size: 2rem;
            font-weight: 800;
            text-align: center;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.3);
            letter-spacing: 1px;
            background:  #000000;
            -webkit-background-clip: text;
            background-clip: text;
            color: black;
            margin-bottom: 10px;
        }

        /* Responsive */
        @media (max-width: 1100px) {
            .flex-container {
                gap: 40px;
            }
            .student-card {
                max-width: 580px;
                padding: 30px 28px;
            }
            .avatar-circle {
                width: 80px;
                height: 80px;
                font-size: 38px;
            }
            .student-title h3 {
                font-size: 2rem;
            }
            .info-value {
                font-size: 1.1rem;
            }
            .price-amount {
                font-size: 2rem;
            }
        }

        @media (max-width: 900px) {
            .flex-container {
                flex-direction: column;
                gap: 30px;
            }
            .student-card {
                max-width: 100%;
            }
            .spin-title {
                font-size: 1.8rem;
            }
            .teacher-name {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 600px) {
            .student-card {
                padding: 24px 20px;
            }
            .avatar-circle {
                width: 65px;
                height: 65px;
                font-size: 32px;
            }
            .student-title h3 {
                font-size: 1.5rem;
            }
            .info-grid-card {
                grid-template-columns: 1fr;
                gap: 12px;
            }
            .info-item {
                padding: 14px 18px;
            }
            .price-amount {
                font-size: 1.6rem;
            }
            .spin-btn {
                width: 100px;
                height: 100px;
            }
            .spin-text {
                font-size: 22px;
            }
            .pointer {
                border-left: 20px solid transparent;
                border-right: 20px solid transparent;
                border-top: 45px solid #ffee00;
            }
            .wheel-pointer {
                top: -32px;
            }
        }

        button:disabled {
            opacity: 0.7;
            cursor: not-allowed;
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
    
    <div class="spin-full-container">
        <div class="spin-content">
            
           <div style="display: flex;">

            <div class="spin-header">
                <h1 class="spin-title">សូមស្វាគមន៍មកកាន់ កងនាំសំណាង!</h1>
            </div>
              
                 
           </div>

            <!-- Flex Container with BIGGER Student Card -->
            <div class="flex-container">
              <!-- BIGGER Student Card - Premium Design -->
                <div class="student-card">
                    <div class="brand-logo">
                <div class="logo-circle">
                    <img class="img" src="https://scontent.fpnh5-3.fna.fbcdn.net/v/t39.30808-6/718675229_1688689795712419_5978467431059090522_n.jpg?stp=dst-jpg_tt6&cstp=mx864x864&ctp=p526x296&_nc_cat=104&ccb=1-7&_nc_sid=127cfc&_nc_eui2=AeGf_umBXPfYYpsW4kfpSYG6kKA-rXk9GyyQoD6teT0bLId9yJ6ZjY6QEgNYlqnOcC05dY0_0tFP7ymk3jiRUvqR&_nc_ohc=2voHNNPM3xwQ7kNvwGjJdvz&_nc_oc=AdqAUUB_4dF5H_Kxl76uEoURV9cFeeBqAjsYk-hprlBeLpxW_rUqvi46NrLe9KeMbaU&_nc_zt=23&_nc_ht=scontent.fpnh5-3.fna&_nc_gid=oc8Ux5fk2kwUjlcdvV-bOw&_nc_ss=7b2a8&oh=00_Af9e1n7MvIlEXJxLaHTeq8vhafEiyWVr9TxHsNokCdySVw&oe=6A2991F7" alt="ETEC Center Logo">
                </div>
                <h1 class="teacher-name">គ្រូអាយធីចិត្តល្អ</h1>
            </div>
                    <div class="card-header">
                        <div class="avatar-circle">
                            <?php 
                            $firstLetter = strtoupper(substr($_SESSION['fullname'], 0, 1));
                            echo htmlspecialchars($firstLetter);
                            ?>
                        </div>
                        <div class="student-title">
                            <h3><?php echo htmlspecialchars($_SESSION['fullname']); ?></h3>
                            <p><i class="fas fa-id-card"></i> Student Information</p>
                        </div>
                    </div>
                    
                    <div class="info-grid-card">
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Course Enrolled</div>
                                <div class="info-value"><?php echo htmlspecialchars($_SESSION['course_name']); ?></div>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Schedule</div>
                                <div class="info-value"><?php echo htmlspecialchars($_SESSION['course_schedule']); ?></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="price-section">
                        <span class="price-label"><i class="fas fa-tag"></i> Course Price</span>
                        <span class="price-amount">$<?php echo number_format($_SESSION['course_price'], 2); ?></span>
                    </div>
                </div>
                <!-- Wheel Section -->
                <div class="wheel-section">
                    <div class="wheel-wrapper">
                        <canvas id="wheelCanvas" width="480" height="480"></canvas>
                        <div class="wheel-center">
                            <button id="spinBtn" class="spin-btn">
                                <div class="spin-btn-inner">
                                    <span class="spin-text">SPIN</span>
                                </div>
                            </button>
                        </div>
                        <div class="wheel-pointer">
                            <div class="pointer"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Result Modal -->
    <div id="resultModal" class="result-modal">
    <div class="modal-card">
        <button class="modal-close" onclick="$('#resultModal').fadeOut()">×</button>
        
        <!-- ETEC Logo Section -->
        <div class="modal-logo">
            <img src="https://scontent.fpnh5-3.fna.fbcdn.net/v/t39.30808-6/718675229_1688689795712419_5978467431059090522_n.jpg?stp=dst-jpg_tt6&cstp=mx864x864&ctp=p526x296&_nc_cat=104&ccb=1-7&_nc_sid=127cfc&_nc_eui2=AeGf_umBXPfYYpsW4kfpSYG6kKA-rXk9GyyQoD6teT0bLId9yJ6ZjY6QEgNYlqnOcC05dY0_0tFP7ymk3jiRUvqR&_nc_ohc=2voHNNPM3xwQ7kNvwGjJdvz&_nc_oc=AdqAUUB_4dF5H_Kxl76uEoURV9cFeeBqAjsYk-hprlBeLpxW_rUqvi46NrLe9KeMbaU&_nc_zt=23&_nc_ht=scontent.fpnh5-3.fna&_nc_gid=oc8Ux5fk2kwUjlcdvV-bOw&_nc_ss=7b2a8&oh=00_Af9e1n7MvIlEXJxLaHTeq8vhafEiyWVr9TxHsNokCdySVw&oe=6A2991F7" alt="ETEC Center Logo" class="modal-logo-img">
            <div class="modal-logo-text">គ្រូអាយធីចិត្តល្អ</div>
        </div>
        
        <div class="modal-header">
            <h2>Congratulations!</h2>
        </div>
        
        <div class="discount-badge">
            <div style="font-family: serif;">You Got</div>
            <div>
                <span class="discount-number" id="discountPercent">0</span>
                <span class="discount-symbol-lg">%</span>
            </div>
            <div style="font-family: serif;">OFF</div>
        </div>
        
        <div class="price-breakdown">
            <div class="price-row">
                <span>Original Price</span>
                <span id="originalPrice">$0</span>
            </div>
            <div class="price-row discount">
                <span>Discount Amount</span>
                <span id="discountAmount">-$0</span>
            </div>
            <div class="price-row final" style="color: black;">
                <span>Final Price</span>
                <span id="finalPrice">$0</span>
            </div>
        </div>
        
        <button id="claimBtn" class="claim-btn">
            <span>Claim My Discount</span>
            <span>→</span>
        </button>
    </div>
</div>
    
   <script>
    // ===============================
// PRIZES
// ===============================
const WEIGHTED_DISCOUNTS = [
    100,
    "អាយធីស្មោះ",
    30,
    60,
    80,
    "អាយធីស្រឡាញ់គេម្នាក់ឯង",
    100,
    50,
    30,
    90,
    100,
    "អាយធីសាវ៉ា",
    70,
    90,
    80
];

const SEGMENTS = [...WEIGHTED_DISCOUNTS];

const COLOR_PALETTE = [
    '#FFD700', // Gold
    '#003366', // Navy Blue
    '#FFD700',
    '#003366',
    '#FFD700',
    '#003366',
    '#FFD700',
    '#003366',
    '#FFD700',
    '#003366',
    '#FFD700',
    '#003366',
    '#FFD700',
    '#003366',
    '#FFD700'
];

let currentRotation = 0;
let spinning = false;
let animFrame = null;

const canvas = document.getElementById('wheelCanvas');
const ctx = canvas.getContext('2d');

const centerX = canvas.width / 2;
const centerY = canvas.height / 2;
const radius = 215;

// ===============================
// RANDOM PRIZE
// ===============================
function getRandomSegmentValue() {
    return SEGMENTS[
        Math.floor(Math.random() * SEGMENTS.length)
    ];
}

// ===============================
// DRAW WHEEL
// ===============================
function drawWheel() {

    ctx.clearRect(
        0,
        0,
        canvas.width,
        canvas.height
    );

    // Outer Ring
    ctx.beginPath();
    ctx.arc(
        centerX,
        centerY,
        radius + 12,
        0,
        Math.PI * 2
    );
    ctx.strokeStyle = '#FFD700';
    ctx.lineWidth = 12;
    ctx.stroke();

    ctx.beginPath();
    ctx.arc(
        centerX,
        centerY,
        radius + 24,
        0,
        Math.PI * 2
    );
    ctx.strokeStyle = '#FFF4B0';
    ctx.lineWidth = 4;
    ctx.stroke();

    const angleStep =
        (Math.PI * 2) / SEGMENTS.length;

    for (
        let i = 0;
        i < SEGMENTS.length;
        i++
    ) {

        const start =
            i * angleStep +
            currentRotation;

        const end =
            (i + 1) * angleStep +
            currentRotation;

        const gradient =
            ctx.createLinearGradient(
                centerX - radius,
                centerY - radius,
                centerX + radius,
                centerY + radius
            );

        gradient.addColorStop(
            0,
            COLOR_PALETTE[
                i % COLOR_PALETTE.length
            ]
        );

        gradient.addColorStop(
            1,
            '#ffffff22'
        );

        ctx.beginPath();
        ctx.fillStyle = gradient;
        ctx.moveTo(
            centerX,
            centerY
        );
        ctx.arc(
            centerX,
            centerY,
            radius,
            start,
            end
        );
        ctx.fill();

        ctx.strokeStyle = '#FFFFFF';
        ctx.lineWidth = 3;
        ctx.stroke();

        ctx.save();

        ctx.translate(
            centerX,
            centerY
        );

        ctx.rotate(
            start + angleStep / 2
        );

        ctx.fillStyle = '#FFFFFF';

        ctx.font =
            'bold 16px "Kantumruy Pro", sans-serif';

        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';

        ctx.shadowColor =
            'rgba(0,0,0,0.6)';

        ctx.shadowBlur = 0;

        let text =
            typeof SEGMENTS[i] ===
            'number'
                ? SEGMENTS[i] + '%'
                : SEGMENTS[i];

        if (text.length > 12) {
            text =
                text.substring(
                    0,
                    12
                ) + '...';
        }

        ctx.fillText(
            text,
            radius * 0.62,
            0
        );

        ctx.restore();
    }

    // Center White Circle
    ctx.beginPath();
    ctx.arc(
        centerX,
        centerY,
        65,
        0,
        Math.PI * 2
    );
    ctx.fillStyle = '#fff';
    ctx.fill();

    ctx.strokeStyle =
        '#FFD700';

    ctx.lineWidth = 5;
    ctx.stroke();

    // Blue Circle
    const centerGradient =
        ctx.createRadialGradient(
            centerX,
            centerY,
            5,
            centerX,
            centerY,
            60
        );

    centerGradient.addColorStop(
        0,
        '#60A5FA'
    );

    centerGradient.addColorStop(
        1,
        '#1E3A8A'
    );

    ctx.beginPath();
    ctx.arc(
        centerX,
        centerY,
        52,
        0,
        Math.PI * 2
    );
    ctx.fillStyle =
        centerGradient;
    ctx.fill();

    // Center Dot
    ctx.beginPath();
    ctx.arc(
        centerX,
        centerY,
        12,
        0,
        Math.PI * 2
    );
    ctx.fillStyle =
        '#FFD700';
    ctx.fill();
}

// ===============================
// DETECT RESULT
// ===============================
function getCurrentSegmentValue() {

    const pointerAngle =
        -Math.PI / 2;

    let adjusted =
        pointerAngle -
        currentRotation;

    adjusted =
        (
            (
                adjusted %
                (Math.PI * 2)
            ) +
            Math.PI * 2
        ) %
        (Math.PI * 2);

    const angleStep =
        (Math.PI * 2) /
        SEGMENTS.length;

    const idx =
        Math.floor(
            adjusted /
            angleStep
        ) %
        SEGMENTS.length;

    return SEGMENTS[idx];
}

// ===============================
// SPIN
// ===============================
function spinWheel(callback) {

    if (spinning) return;

    spinning = true;

    const duration = 4000;

    const startTime =
        performance.now();

    const startRotation =
        currentRotation;

    const targetPrize =
        getRandomSegmentValue();

    const targetIndex =
        SEGMENTS.indexOf(
            targetPrize
        );

    const angleStep =
        (Math.PI * 2) /
        SEGMENTS.length;

    const targetAngle =
        (
            targetIndex *
            angleStep
        ) +
        angleStep / 2;

    const fullRotations =
        10 +
        Math.floor(
            Math.random() * 5
        );

    const finalRotation =
        startRotation +
        (
            fullRotations *
            Math.PI *
            2
        ) +
        targetAngle +
        Math.PI / 2;

    function animate(now) {

        const elapsed =
            now -
            startTime;

        const progress =
            Math.min(
                elapsed /
                duration,
                1
            );

        const ease =
            1 -
            Math.pow(
                1 - progress,
                4
            );

        currentRotation =
            startRotation +
            (
                finalRotation -
                startRotation
            ) *
            ease;

        drawWheel();

        if (
            progress < 1
        ) {
            animFrame =
                requestAnimationFrame(
                    animate
                );
        } else {

            spinning = false;

            callback(
                getCurrentSegmentValue()
            );
        }
    }

    requestAnimationFrame(
        animate
    );
}

// ===============================
// INITIAL DRAW
// ===============================
drawWheel();

// ===============================
// BUTTON EVENTS
// ===============================
$(document).ready(function () {

    $('#spinBtn').click(function () {

        if (spinning) return;

        const $btn =
            $(this);

        $btn.prop(
            'disabled',
            true
        );

        spinWheel(
            function (prize) {

                const originalPrice =
                    parseFloat(
                        <?php echo json_encode($_SESSION['course_price']); ?>
                    );

                const discount =
                    typeof prize ===
                    'number'
                        ? prize
                        : 0;

                const discountAmount =
                    (
                        originalPrice *
                        discount
                    ) / 100;

                const finalPrice =
                    originalPrice -
                    discountAmount;

                $('#discountPercent')
                    .text(
                        discount
                    );

                $('#originalPrice')
                    .text(
                        '$' +
                        originalPrice.toFixed(
                            2
                        )
                    );

                $('#discountAmount')
                    .text(
                        '-$' +
                        discountAmount.toFixed(
                            2
                        )
                    );

                $('#finalPrice')
                    .text(
                        '$' +
                        finalPrice.toFixed(
                            2
                        )
                    );

                $('#prizeName')
                    .text(
                        prize
                    );

                $('#resultModal')
                    .css(
                        'display',
                        'flex'
                    )
                    .hide()
                    .fadeIn(
                        300
                    );

                window.selectedPrize =
                    prize;

                window.selectedDiscount =
                    discount;

                $btn.prop(
                    'disabled',
                    false
                );
            }
        );
    });

    $('#claimBtn').click(function () {

        $.ajax({

            url:
                'api/process_spin.php',

            type:
                'POST',

            dataType:
                'json',

            data: {
                prize:
                    window.selectedPrize,
                discount:
                    window.selectedDiscount
            },

            success:
                function (
                    resp
                ) {

                    if (
                        resp.success
                    ) {

                        window.location.href =
                            'result.php';

                    } else {

                        alert(
                            resp.error ||
                            'Error'
                        );
                    }
                },

            error:
                function () {

                    alert(
                        'Network Error'
                    );
                }
        });
    });
});
   </script>
</body>
</html>