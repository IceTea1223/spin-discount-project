<?php
session_start();
// No header include - we'll create custom minimal HTML
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Student Registration - Spin Discount</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            font-family: 'Nokora', 'Inter', 'Khmer', 'Segoe UI', system-ui, sans-serif;
        }

        ::-webkit-scrollbar { display: none; }
        html { scrollbar-width: none; }
        body { -ms-overflow-style: none; }

        /* Main container */
        .form-container-full {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
            background: radial-gradient(circle at 20% 30%, #0b00c4, #02006e);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            z-index: 2;
        }

        .form-container-full::-webkit-scrollbar { display: none; }

        /* Hero background image */
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
            background: linear-gradient(135deg, rgba(11,0,180,0.6), rgba(2,0,110,0.8));
        }

        /* Pattern overlay */
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

        /* Form Card */
        .form-card {
            max-width: 550px;
            width: 100%;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-radius: 48px;
            padding: 40px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.5s ease-out;
            position: relative;
            z-index: 10;
            border: 1px solid rgba(255, 215, 0, 0.3);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Back Button */
        .back-button {
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

        .back-button:hover {
            background: rgba(255, 215, 0, 0.3);
            transform: translateX(-6px);
            gap: 14px;
        }

        /* Header */
        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-header h2 {
            font-size: 2rem;
            font-family: 'Moul', 'Nokora', cursive;
            background: linear-gradient(135deg, #0b00b3, #2b1aff);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 10px;
        }

        .form-header p {
            color: #666;
            font-size: 0.9rem;
            font-weight: 300;
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
            color: #1e1e3f;
            font-size: 0.85rem;
            font-family: 'Nokora', sans-serif;
        }

        input, select {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e8e8f0;
            border-radius: 28px;
            font-size: 1rem;
            transition: all 0.25s;
            font-family: 'Nokora', 'Inter', sans-serif;
            background: #fefefe;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #FFB347;
            box-shadow: 0 0 0 4px rgba(255, 180, 70, 0.2);
        }

        /* Course Info */
        .course-info {
            margin-top: 20px;
            padding: 20px;
            background: linear-gradient(135deg, rgba(7, 0, 196, 0.05) 0%, rgba(10, 0, 232, 0.05) 100%);
            border-radius: 16px;
            border-left: 4px solid #0700C4;
        }

        .course-info h3 {
            color: #0700C4;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .course-info p {
            margin-bottom: 8px;
            color: #555;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            background: #0012b3;
            border: none;
            padding: 16px;
            border-radius: 60px;
            font-size: 1.2rem;
            font-weight: 800;
            font-family: 'Nokora', sans-serif;
            color: white;
            cursor: pointer;
            margin-top: 20px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 30px -8px rgba(0, 0, 0, 0.3);
            gap: 18px;
            background: #0a1787;
        color:white
        }

        /* Error Messages */
        .error-message {
            color: #e63946;
            font-size: 0.7rem;
            margin-top: 6px;
            margin-left: 12px;
            display: none;
            font-weight: 500;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(8px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 40px;
            padding: 32px 28px;
            max-width: 460px;
            width: 90%;
            text-align: center;
            animation: modalPop 0.3s ease;
            box-shadow: 0 30px 50px rgba(0, 0, 0, 0.3);
        }

        @keyframes modalPop {
            from {
                opacity: 0;
                transform: scale(0.92);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .modal-content h3 {
            font-family: 'Moul', cursive;
            color: #e67e22;
            margin-bottom: 16px;
            font-size: 1.6rem;
        }

        #duplicateDetails ul {
            text-align: left;
            margin: 18px 0;
            padding-left: 20px;
        }

        #duplicateDetails li {
            margin: 10px 0;
            color: #c0392b;
            font-weight: 500;
        }

        .modal-buttons {
            display: flex;
            gap: 14px;
            justify-content: center;
            margin-top: 24px;
        }

        .btn-confirm {
            background: linear-gradient(145deg, #27ae60, #2ecc71);
            color: white;
            border: none;
            padding: 12px 28px;
            border-radius: 40px;
            cursor: pointer;
            font-weight: 700;
        }

        .btn-cancel {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 12px 28px;
            border-radius: 40px;
            cursor: pointer;
            font-weight: 700;
        }

        /* Floating Decoration */
        .floating-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        .float-circle {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,215,0,0.08), rgba(255,140,0,0.04));
            animation: floatAnim 12s infinite alternate;
        }

        .circle-1 {
            width: 350px;
            height: 350px;
            top: -150px;
            right: -100px;
        }

        .circle-2 {
            width: 450px;
            height: 450px;
            bottom: -200px;
            left: -150px;
            animation-duration: 15s;
            animation-direction: alternate-reverse;
        }

        .circle-3 {
            width: 180px;
            height: 180px;
            top: 40%;
            left: -60px;
            animation-duration: 10s;
        }

        @keyframes floatAnim {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(30px, -30px) scale(1.1); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-card {
                padding: 30px 20px;
                border-radius: 36px;
            }
            
            .form-header h2 {
                font-size: 1.6rem;
            }
            
            .back-button {
                top: 15px;
                left: 15px;
                padding: 8px 18px;
                font-size: 0.75rem;
            }

            .btn-submit {
                font-size: 1rem;
                padding: 14px;
            }
        }

        @media (max-width: 480px) {
            .form-card {
                padding: 25px 18px;
                border-radius: 32px;
            }
            .form-header h2 {
                font-size: 1.4rem;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Background -->
    <div class="hero-bg"></div>
    <div class="pattern-overlay"></div>
    
    <!-- Floating Background -->
    <div class="floating-bg">
        <div class="float-circle circle-1"></div>
        <div class="float-circle circle-2"></div>
        <div class="float-circle circle-3"></div>
    </div>

    <!-- Back Button -->
    <a href="index.php" class="back-button">
        <span>←</span> Back to Home
    </a>
    
    <!-- Main Form Container -->
    <div class="form-container-full">
        <div class="form-card">
            <div class="form-header">
                <h2 style="color: black;">Student Registration</h2>
                <p>Fill in your details to spin the wheel</p>
            </div>
            
            <form id="studentForm">
                <div class="form-group">
                    <label>Full Name:</label>
                    <input type="text" name="fullname" id="fullname" placeholder="Enter your full name" autocomplete="off" required>
                    <div class="error-message" id="fullnameError"></div>
                </div>
                
                <div class="form-group">
                    <label>Gender:</label>
                    <select name="gender" id="gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Telephone:</label>
                    <input type="tel" name="tel" id="tel" placeholder="Enter your phone number" required>
                    <div class="error-message" id="telError"></div>
                </div>
                
                <div class="form-group">
                    <label>Course:</label>
                    <select name="course_id" id="course_id" required>
                        <option value="">Select Course</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Schedule:</label>
                    <select name="schedule_index" id="schedule_index" required disabled>
                        <option value="">Select Schedule</option>
                    </select>
                </div>
                
                <input type="hidden" name="course_name" id="course_name">
                <input type="hidden" name="course_price" id="course_price">
                <input type="hidden" name="course_schedule" id="course_schedule">
                
                <div class="course-info" id="courseInfo" style="display:none;">
                    <h3>Course Details</h3>
                    <p><strong>Course:</strong> <span id="displayCourse"></span></p>
                    <p><strong>Price:</strong> $<span id="displayPrice"></span></p>
                    <p><strong>Schedule:</strong> <span id="displaySchedule"></span></p>
                </div>
                
                <button type="submit" class="btn-submit">
                     Go to Spin
                </button>
            </form>
        </div>
    </div>
    
    <!-- Modal for duplicate confirmation -->
    <div id="duplicateModal" class="modal">
        <div class="modal-content">
            <h3>⚠️ Student Already Exists!</h3>
            <p>A student with the same <strong>Name</strong> or <strong>Telephone</strong> already exists in the system.</p>
            <div id="duplicateDetails"></div>
            <p>Do you still want to proceed with the spin?</p>
            <div class="modal-buttons">
                <button id="confirmSpinBtn" class="btn-confirm">Yes, Continue Spin</button>
                <button id="cancelSpinBtn" class="btn-cancel">No, Go Back</button>
            </div>
        </div>
    </div>
    
    <script src="assets/js/courses.js"></script>
    <script>
    $(document).ready(function() {
        // Load courses
        if (typeof coursesData !== 'undefined' && coursesData.length) {
            coursesData.forEach(course => {
                $('#course_id').append(`<option value="${course.id}">${course.course} - $${course.price}</option>`);
            });
        } else {
            $('#course_id').append(`<option value="1">English for IT - $350</option><option value="2">Khmer Typography - $200</option>`);
        }

        window.getCourseById = function(id) {
            if (typeof coursesData !== 'undefined') {
                return coursesData.find(c => c.id === id);
            }
            return null;
        };
        
        // On course change
        $('#course_id').change(function() {
            const courseId = parseInt($(this).val());
            const course = getCourseById(courseId);
            
            if(course && course.schedules) {
                $('#schedule_index').html('<option value="">Select Schedule</option>').prop('disabled', false);
                course.schedules.forEach((schedule, index) => {
                    $('#schedule_index').append(`<option value="${index}">${schedule.day} (${schedule.time})</option>`);
                });
                $('#courseInfo').hide();
            } else {
                $('#schedule_index').html('<option value="">Select Course First</option>').prop('disabled', true);
                $('#courseInfo').hide();
            }
        });
        
        // On schedule change
        $('#schedule_index').change(function() {
            const courseId = parseInt($('#course_id').val());
            const scheduleIndex = parseInt($(this).val());
            const course = getCourseById(courseId);
            
            if(course && !isNaN(scheduleIndex) && course.schedules && course.schedules[scheduleIndex]) {
                const schedule = course.schedules[scheduleIndex];
                $('#course_name').val(course.course);
                $('#course_price').val(course.price);
                $('#course_schedule').val(`${schedule.day} (${schedule.time})`);
                $('#displayCourse').text(course.course);
                $('#displayPrice').text(course.price);
                $('#displaySchedule').text(`${schedule.day} (${schedule.time})`);
                $('#courseInfo').fadeIn(200);
            } else {
                $('#courseInfo').hide();
            }
        });
        
        // Check for duplicates before submitting
        function checkDuplicate(studentData, callback) {
            $.ajax({
                url: 'api/check_duplicate.php',
                method: 'POST',
                data: studentData,
                dataType: 'json',
                timeout: 8000,
                success: function(response) {
                    callback(response);
                },
                error: function() {
                    callback({ is_duplicate: false });
                }
            });
        }
        
        // Form submission with duplicate check
        $('#studentForm').submit(function(e) {
            e.preventDefault();
            
            const fullname = $('#fullname').val().trim();
            const tel = $('#tel').val().trim();
            const course_name = $('#course_name').val();
            const course_price = $('#course_price').val();
            const course_schedule = $('#course_schedule').val();
            const gender = $('#gender').val();
            
            // Validate all fields
            if(!fullname || !tel || !course_name || !gender || course_price === "") {
                alert('Please fill in all fields');
                return;
            }
            
            if(tel.length < 8) {
                alert('Please enter a valid phone number (at least 8 digits)');
                return;
            }
            
            const studentData = {
                fullname: fullname,
                tel: tel,
                course_name: course_name,
                course_price: course_price,
                course_schedule: course_schedule,
                gender: gender
            };
            
            const $btn = $('.btn-submit');
            const originalText = $btn.html();
            $btn.html('<span>⏳</span> Checking...').prop('disabled', true);
            
            // Check for duplicates
            checkDuplicate(studentData, function(response) {
                $btn.html(originalText).prop('disabled', false);
                if(response && response.is_duplicate) {
                    // Show duplicate modal with details
                    let detailsHtml = '<ul>';
                    if(response.duplicate_name) {
                        detailsHtml += `<li>❌ Name "${fullname}" already exists (Previous spin on: ${response.existing_name_date || 'previous date'})</li>`;
                    }
                    if(response.duplicate_tel) {
                        detailsHtml += `<li>❌ Telephone "${tel}" already exists (Previous spin on: ${response.existing_tel_date || 'previous date'})</li>`;
                    }
                    detailsHtml += '</ul>';
                    $('#duplicateDetails').html(detailsHtml);
                    $('#duplicateModal').fadeIn();
                    
                    // Store form data for confirmation
                    window.pendingFormData = studentData;
                } else {
                    // No duplicate, proceed directly
                    saveStudent(studentData);
                }
            });
        });
        
        // Confirm spin button click
        $('#confirmSpinBtn').click(function() {
            $('#duplicateModal').fadeOut();
            if(window.pendingFormData) {
                saveStudent(window.pendingFormData, true);
            }
        });
        
        // Cancel button click
        $('#cancelSpinBtn').click(function() {
            $('#duplicateModal').fadeOut();
            window.pendingFormData = null;
        });
        
        // Save student function
        function saveStudent(studentData, force = false) {
            if(force) {
                studentData.force_save = true;
            }
            
            const $btn = $('.btn-submit');
            const originalHtml = $btn.html();
            $btn.html('<span>⏳</span> Saving...').prop('disabled', true);
            
            $.ajax({
                url: 'api/save_student.php',
                method: 'POST',
                data: studentData,
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        window.location.href = 'spin_discount.php';
                    } else {
                        alert('Error: ' + (response.error || 'Could not save data'));
                        $btn.html(originalHtml).prop('disabled', false);
                    }
                },
                error: function() {
                    alert('Connection error. Please try again.');
                    $btn.html(originalHtml).prop('disabled', false);
                }
            });
        }
        
        // Real-time duplicate check for fullname
        $('#fullname').on('blur', function() {
            const fullname = $(this).val().trim();
            if(fullname.length > 2) {
                $.ajax({
                    url: 'api/check_field_duplicate.php',
                    method: 'POST',
                    data: {field: 'fullname', value: fullname},
                    dataType: 'json',
                    success: function(response) {
                        if(response.is_duplicate) {
                            $('#fullnameError').html('⚠️ This name already exists in the system').show();
                        } else {
                            $('#fullnameError').hide();
                        }
                    }
                });
            }
        });
        
        // Real-time duplicate check for telephone
        $('#tel').on('blur', function() {
            const tel = $(this).val().trim();
            if(tel.length > 5) {
                $.ajax({
                    url: 'api/check_field_duplicate.php',
                    method: 'POST',
                    data: {field: 'tel', value: tel},
                    dataType: 'json',
                    success: function(response) {
                        if(response.is_duplicate) {
                            $('#telError').html('⚠️ This telephone number already exists in the system').show();
                        } else {
                            $('#telError').hide();
                        }
                    }
                });
            }
        });
    });
    </script>
</body>
</html>