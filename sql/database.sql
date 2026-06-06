-- Create database
CREATE DATABASE IF NOT EXISTS spin_discount_db;
USE spin_discount_db;

-- Students table
CREATE TABLE IF NOT EXISTS students (
    id INT PRIMARY KEY AUTO_INCREMENT,
    fullname VARCHAR(100) NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    tel VARCHAR(20) NOT NULL,
    course_name VARCHAR(100) NOT NULL,
    course_price DECIMAL(10,2) NOT NULL,
    course_schedule VARCHAR(100) NOT NULL,
    booking_date DATE NOT NULL,
    booking_time TIME NOT NULL,
    spin_discount INT DEFAULT 0,
    final_price DECIMAL(10,2),
    payment_status ENUM('pending', 'done') DEFAULT 'pending',
    spin_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);