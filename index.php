<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>ETEC Center - បង្វិលកងចក្រ ទទួលបាន Discount 100%</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Khmer&family=Moul&family=Nokora:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
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
            font-family: 'Nokora', 'Inter', 'Khmer', system-ui, -apple-system, sans-serif;
        }

        ::-webkit-scrollbar { display: none; }
        html { scrollbar-width: none; }
        body { -ms-overflow-style: none; }

        .poster-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            overflow: hidden;
            background: radial-gradient(circle at 20% 30%, #0b00c4, #02006e);
        }

        /* Hero Image Section */
        .hero-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            opacity: 0.15;
            background-image: url('https://scontent.fpnh5-3.fna.fbcdn.net/v/t39.30808-6/718675229_1688689795712419_5978467431059090522_n.jpg?stp=dst-jpg_tt6&cstp=mx864x864&ctp=p526x296&_nc_cat=104&ccb=1-7&_nc_sid=127cfc&_nc_eui2=AeGf_umBXPfYYpsW4kfpSYG6kKA-rXk9GyyQoD6teT0bLId9yJ6ZjY6QEgNYlqnOcC05dY0_0tFP7ymk3jiRUvqR&_nc_ohc=2voHNNPM3xwQ7kNvwGjJdvz&_nc_oc=AdqAUUB_4dF5H_Kxl76uEoURV9cFeeBqAjsYk-hprlBeLpxW_rUqvi46NrLe9KeMbaU&_nc_zt=23&_nc_ht=scontent.fpnh5-3.fna&_nc_gid=oc8Ux5fk2kwUjlcdvV-bOw&_nc_ss=7b2a8&oh=00_Af9e1n7MvIlEXJxLaHTeq8vhafEiyWVr9TxHsNokCdySVw&oe=6A2991F7');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            filter: blur(2px);
        }

        .hero-image::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(11,0,180,0.7), rgba(2,0,110,0.85));
        }

        .poster-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .gradient-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(ellipse at 30% 40%, rgba(255,200,50,0.08) 0%, rgba(0,0,0,0.4) 80%);
        }

        .pattern-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                repeating-linear-gradient(45deg, rgba(255,255,255,0.02) 0px, rgba(255,255,255,0.02) 2px, transparent 2px, transparent 10px),
                repeating-linear-gradient(135deg, rgba(255,215,0,0.02) 0px, rgba(255,215,0,0.02) 3px, transparent 3px, transparent 15px);
        }

        /* Main Content */
        .poster-content {
            position: relative;
            z-index: 15;
            text-align: center;
            color: white;
            max-width: 1000px;
            width: 90%;
            margin: 0 auto;
            padding: 30px 25px 50px;
            animation: fadeRise 0.8s ease-out;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        @keyframes fadeRise {
            0% { opacity: 0; transform: translateY(35px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* Logo / Brand */
        .brand-logo {
            margin-bottom: 20px;
        }
        
        .logo-circle {
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, #FFD966, #FFB347);
            border-radius: 16px;
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
            border-radius: 16px;
            transition: transform 0.3s ease;
        }
        
        .img:hover {
            transform: scale(1.05);
        }
        
        .brand-name {
            font-size: 1.2rem;
            letter-spacing: 3px;
            font-weight: 600;
            color: #FFE484;
        }

        .poster-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 215, 0, 0.15);
            backdrop-filter: blur(12px);
            padding: 10px 28px;
            border-radius: 60px;
            margin-bottom: 28px;
            border: 1px solid rgba(255, 215, 0, 0.45);
        }

        .badge-text {
            font-family: 'Nokora', 'Khmer', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            letter-spacing: 1.5px;
            color: #FFF2C8;
        }

        .badge-pulse {
            width: 8px;
            height: 8px;
            background: #FFD966;
            border-radius: 50%;
            animation: pulseDot 1.5s infinite;
        }

        @keyframes pulseDot {
            0% { opacity: 0.5; transform: scale(0.8); }
            100% { opacity: 1; transform: scale(1.3); }
        }

        .poster-title {
            margin-bottom: 20px;
        }

        .title-small {
            display: block;
            font-family: 'Nokora', 'Khmer', sans-serif;
            font-size: 1.5rem;
            font-weight: 500;
            letter-spacing: 2px;
            color: rgba(255,250,220,0.92);
            margin-bottom: 10px;
            padding: auto;
        }

        .title-big {
            display: block;
            font-family: 'Moul', 'Nokora', cursive;
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.25;
            letter-spacing: -0.5px;
        }

        .highlight {
            padding: 20px 20px;
            font-family: 'Moul', 'Nokora', cursive;
            background: yellow;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            display: inline-block;
        }

        .poster-description {
            font-family: 'Nokora', 'Khmer', sans-serif;
            font-size: 1.5rem;
            font-weight: 500;
            margin-bottom: 42px;
            background: rgba(0,0,0,0.25);
            display: inline-block;
            padding: 10px 32px;
            border-radius: 60px;
            backdrop-filter: blur(6px);
            line-height: 1.5;
        }

        .poster-cta {
            display: inline-flex;
            align-items: center;
            gap: 16px;
            background: linear-gradient(105deg, #FFFFFF, #FFF8E7);
            color: #0a00c4;
            padding: 18px 52px;
            border-radius: 70px;
            text-decoration: none;
            font-weight: 800;
            font-size: 1.35rem;
            font-family: 'Nokora', 'Inter', sans-serif;
            letter-spacing: 2px;
            transition: all 0.3s ease;
            box-shadow: 0 20px 35px -10px rgba(0,0,0,0.4);
            margin-bottom: 45px;
            border: 1px solid rgba(255,215,0,0.6);
            cursor: pointer;
        }

        .poster-cta:hover {
            transform: translateY(-5px);
            gap: 22px;
            background: white;
            box-shadow: 0 25px 40px -12px rgba(0,0,0,0.5);
        }

        .cta-text {
            font-size: 1.25rem;
            font-weight: 800;
        }

        .cta-icon {
            font-size: 1.6rem;
            transition: transform 0.25s;
        }

        .poster-cta:hover .cta-icon {
            transform: rotate(15deg);
        }

        .poster-features {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 35px;
            flex-wrap: wrap;
            margin-top: 8px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(0,0,0,0.35);
            backdrop-filter: blur(8px);
            padding: 8px 20px;
            border-radius: 50px;
            font-family: 'Nokora', sans-serif;
            font-weight: 600;
            font-size: 0.85rem;
            letter-spacing: 0.3px;
            border: 1px solid rgba(255,215,0,0.2);
        }

        .feature-icon {
            font-size: 1.2rem;
        }

        /* FLOATING DISCOUNT CARDS */
        .floating-discounts {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 8;
        }

        .discount-card {
            position: absolute;
            background: rgba(255, 255, 248, 0.97);
            backdrop-filter: blur(12px);
            border-radius: 24px;
            padding: 10px 16px;
            text-align: center;
            box-shadow: 0 15px 30px rgba(0,0,0,0.25);
            border: 1px solid rgba(255,200,80,0.7);
            transition: transform 0.2s ease;
            min-width: 75px;
            pointer-events: auto;
            cursor: default;
        }

        .discount-percent {
            font-size: 1.8rem;
            font-weight: 900;
            background: linear-gradient(145deg, #0b00b3, #3b2aff);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            line-height: 1;
            font-family: 'Inter', monospace;
        }

        .discount-label {
            font-family: 'Nokora', sans-serif;
            font-size: 0.6rem;
            font-weight: 700;
            color: #e67e22;
            letter-spacing: 0.5px;
        }

        /* Card positions - FIXED to not overlap center content */
     /* FLOATING DISCOUNT CARDS - CIRCULAR DISTRIBUTION */
.card-1 { top: 5%; left: 10%; animation: float1 5s ease-in-out infinite; }
.card-2 { top: 5%; right: 10%; animation: float2 5.3s ease-in-out infinite; }
.card-3 { top: 25%; left: 15%; animation: float3 4.8s ease-in-out infinite; }
.card-4 { top: 25%; right: 15%; animation: float4 5.6s ease-in-out infinite; }
.card-5 { top: 50%; left: 10%; animation: float1 5.1s ease-in-out infinite; }
.card-6 { top: 50%; right: 10%; animation: float2 4.9s ease-in-out infinite; }
.card-7 { bottom: 25%; left: 15%; animation: float3 5.4s ease-in-out infinite; }
.card-8 { bottom: 25%; right: 15%; animation: float4 5.7s ease-in-out infinite; }
.card-9 { bottom: 8%; left: 10%; animation: float1 5.2s ease-in-out infinite; }
.card-10 { bottom: 8%; right: 10%; animation: float2 5.5s ease-in-out infinite; }


        @keyframes float1 { 0%,100% { transform: translateY(0px); } 50% { transform: translateY(-12px); } }
        @keyframes float2 { 0%,100% { transform: translateY(0px); } 50% { transform: translateY(-15px); } }
        @keyframes float3 { 0%,100% { transform: translateY(0px); } 50% { transform: translateY(-10px); } }
        @keyframes float4 { 0%,100% { transform: translateY(0px); } 50% { transform: translateY(-18px); } }

        /* Decorative Wheel */
        .wheel-decoration {
            position: absolute;
            bottom: -180px;
            right: -180px;
            width: 500px;
            height: 500px;
            opacity: 0.1;
            z-index: 2;
            pointer-events: none;
        }

        .wheel-ring {
            width: 100%;
            height: 100%;
            border: 3px solid rgba(255,215,0,0.4);
            border-radius: 50%;
            position: relative;
            animation: spinWheel 22s linear infinite;
        }

        .wheel-ring::after {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            width: 2px;
            height: 50%;
            background: linear-gradient(180deg, rgba(255,215,0,0.6), rgba(255,215,0,0.1));
            transform: translateX(-50%);
        }

        @keyframes spinWheel {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .btn-subnote {
            font-size: 0.75rem;
            margin-top: 18px;
            color: #FFE6B3;
            opacity: 0.9;
        }

        /* Teacher Name Style */
        .teacher-name {
            font-family: 'Nokora', 'Khmer', 'Moul', cursive;
            font-size: 2.2rem;
            font-weight: 800;
            text-align: center;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.3);
            letter-spacing: 1px;
            background: yellow;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 15px;
        }

        /* RESPONSIVE */
        @media (max-width: 1300px) {
            .discount-card { padding: 8px 14px; min-width: 68px; }
            .discount-percent { font-size: 1.6rem; }
        }

        @media (max-width: 1100px) {
            .card-4, .card-6, .card-8, .card-9, .card-11 { display: none; }
            .card-1, .card-2, .card-3, .card-5, .card-7, .card-10 { display: flex; }
        }

        @media (max-width: 900px) {
            .teacher-name { font-size: 1.8rem; }
            .title-big { font-size: 2.4rem; }
            .title-small { font-size: 1.2rem; }
            .poster-description { font-size: 1.15rem; padding: 6px 18px; }
            .poster-cta { padding: 14px 38px; font-size: 1rem; margin-bottom: 35px; }
            .discount-card { padding: 6px 12px; min-width: 60px; }
            .discount-percent { font-size: 1.4rem; }
            .card-4, .card-6, .card-8, .card-9, .card-11 { display: none; }
            .card-1, .card-2, .card-3, .card-5, .card-7, .card-10 { display: flex; }
        }

        @media (max-width: 640px) {
            .poster-content { width: 94%; padding: 20px 15px 35px; }
            .teacher-name { font-size: 1.4rem; margin-bottom: 10px; }
            .title-big { font-size: 1.7rem; line-height: 1.3; }
            .title-small { font-size: 0.95rem; }
            .poster-description { font-size: 0.9rem; margin-bottom: 28px; padding: 6px 16px; }
            .poster-cta { padding: 12px 30px; gap: 10px; margin-bottom: 30px; }
            .cta-text { font-size: 0.9rem; }
            .feature-item { font-size: 0.65rem; padding: 5px 12px; gap: 6px; }
            .feature-icon { font-size: 1rem; }
            .poster-badge { padding: 6px 18px; margin-bottom: 20px; }
            .badge-text { font-size: 0.7rem; }
            .wheel-decoration { width: 260px; height: 260px; bottom: -90px; right: -80px; }
            .logo-circle { width: 70px; height: 70px; }
            
            .card-3, .card-5, .card-7, .card-10, .card-8, .card-4, .card-6, .card-9, .card-11 { display: none; }
            .card-1, .card-2 { display: flex; }
            .discount-card { padding: 5px 10px; min-width: 55px; }
            .discount-percent { font-size: 1.2rem; }
            .discount-label { font-size: 0.55rem; }
            .btn-subnote { font-size: 0.65rem; }
        }

        @media (max-width: 480px) {
            .teacher-name { font-size: 1.2rem; }
            .title-big { font-size: 1.45rem; }
            .poster-description { font-size: 0.8rem; }
            .card-1, .card-2 { padding: 4px 8px; }
            .discount-percent { font-size: 1.1rem; }
        }

        .khmer-text {
            font-family: 'Moul', 'Nokora', cursive;
            font-weight: 500;
            font-size: 30px;
        }
    </style>
</head>
<body>

<div class="poster-container">
    <!-- Hero Image with overlay -->
    <div class="hero-image"></div>
    
    <!-- Background layers -->
    <div class="poster-background">
        <div class="gradient-overlay"></div>
        <div class="pattern-overlay"></div>
    </div>

    <!-- ALL 11 floating discount cards -->
    <div class="floating-discounts">
        <div class="discount-card card-1">
            <div class="discount-percent">50%</div>
            <div class="discount-label">បញ្ចុះតម្លៃ</div>
        </div>
        <div class="discount-card card-2">
            <div class="discount-percent">30%</div>
            <div class="discount-label">បញ្ចុះតម្លៃ</div>
        </div>
        <div class="discount-card card-3">
            <div class="discount-percent">20%</div>
            <div class="discount-label">បញ្ចុះតម្លៃ</div>
        </div>
        <div class="discount-card card-4">
            <div class="discount-percent">10%</div>
            <div class="discount-label">បញ្ចុះតម្លៃ</div>
        </div>
        <div class="discount-card card-5">
            <div class="discount-percent">60%</div>
            <div class="discount-label">បញ្ចុះតម្លៃ</div>
        </div>
        <div class="discount-card card-6">
            <div class="discount-percent">70%</div>
            <div class="discount-label">បញ្ចុះតម្លៃ</div>
        </div>
        <div class="discount-card card-7">
            <div class="discount-percent">80%</div>
            <div class="discount-label">បញ្ចុះតម្លៃ</div>
        </div>
        <div class="discount-card card-8">
            <div class="discount-percent">90%</div>
            <div class="discount-label">បញ្ចុះតម្លៃ</div>
        </div>
        <div class="discount-card card-9">
            <div class="discount-percent">100%</div>
            <div class="discount-label">បញ្ចុះតម្លៃ</div>
        </div>
        <div class="discount-card card-10">
            <div class="discount-percent">100%</div>
            <div class="discount-label">បញ្ចុះតម្លៃ</div>
        </div>
        
    </div>

    <!-- Decorative spinning wheel -->
    <div class="wheel-decoration">
        <div class="wheel-ring"></div>
    </div>

    <!-- Main content -->
    <div class="poster-content">
        <div class="brand-logo">
            <div class="logo-circle">
                <img class="img" src="https://scontent.fpnh5-3.fna.fbcdn.net/v/t39.30808-6/718675229_1688689795712419_5978467431059090522_n.jpg?stp=dst-jpg_tt6&cstp=mx864x864&ctp=p526x296&_nc_cat=104&ccb=1-7&_nc_sid=127cfc&_nc_eui2=AeGf_umBXPfYYpsW4kfpSYG6kKA-rXk9GyyQoD6teT0bLId9yJ6ZjY6QEgNYlqnOcC05dY0_0tFP7ymk3jiRUvqR&_nc_ohc=2voHNNPM3xwQ7kNvwGjJdvz&_nc_oc=AdqAUUB_4dF5H_Kxl76uEoURV9cFeeBqAjsYk-hprlBeLpxW_rUqvi46NrLe9KeMbaU&_nc_zt=23&_nc_ht=scontent.fpnh5-3.fna&_nc_gid=oc8Ux5fk2kwUjlcdvV-bOw&_nc_ss=7b2a8&oh=00_Af9e1n7MvIlEXJxLaHTeq8vhafEiyWVr9TxHsNokCdySVw&oe=6A2991F7" alt="ETEC Center Logo">
            </div>
         <h1 class="teacher-name">គ្រូអាយធីចិត្តល្អ</h1>
        </div>

       

        <h1 class="poster-title">
            <span class="highlight">ឪកាសពិសេសបានមកដល់ហើយ</span>
            <span class="title-big">
                បង្វិលកង <span class="highlight">ដើម្បីទទួលបាន Discount 100%</span>
            </span>
        </h1>
        
        <p class="poster-description khmer-text">
            Annaverasary<span class="highlight">8 Years</span>of ETEC Center
        </p>
        
        <a href="student_form.php" class="poster-cta">
            <span class="cta-text">ចាប់ផ្ដើមបង្វិល</span>
            <span class="cta-icon">⟳</span>
        </a>
        
        
    </div>
</div>

<script>
    (function() {
        document.body.style.overflow = 'hidden';
        document.documentElement.style.overflow = 'hidden';
        
        var cards = document.querySelectorAll('.discount-card');
        for (var i = 0; i < cards.length; i++) {
            cards[i].addEventListener('mouseenter', function(e) {
                e.currentTarget.style.transform = 'scale(1.08)';
                e.currentTarget.style.transition = 'transform 0.2s ease';
                e.currentTarget.style.zIndex = '20';
            });
            cards[i].addEventListener('mouseleave', function(e) {
                e.currentTarget.style.transform = '';
                e.currentTarget.style.zIndex = '';
            });
        }
    })();
</script>
</body>
</html>