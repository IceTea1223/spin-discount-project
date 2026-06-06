# Spin Discount System

A complete web application for course registration with spin-to-win discount functionality.

## Features

- Student registration form
- Interactive spin wheel with random discounts (0%, 5%, 10%, 15%, 20%, 25%, 30%, 50%)
- Automatic price calculation with discount
- Admin dashboard with student management
- Search and filter by payment status
- Responsive design

## Requirements

- XAMPP (Apache + MySQL)
- PHP 7.4 or higher
- Modern web browser

## Installation

1. Copy the `spin-discount-project` folder to `htdocs` directory
2. Start Apache and MySQL in XAMPP
3. Open phpMyAdmin and import `sql/database.sql`
4. Access the application at `http://localhost/spin-discount-project/`

## Usage

### For Students:
1. Fill in registration form
2. Select course and schedule
3. Spin the wheel to get discount
4. View final price and payment details

### For Admins:
1. Access dashboard at `/dashboard/`
2. View all registered students
3. Search by name or phone
4. Filter by payment status
5. Mark payments as completed

## Database Structure

- `students`: Stores all student information and spin results

## Courses Available

- Web Development ($500)
- Mobile App Development ($600)
- Data Science ($550)
- UI/UX Design ($450)
- Python Programming ($520)
- Digital Marketing ($480)

## Technologies Used

- PHP (Backend)
- MySQL (Database)
- JavaScript (Frontend + Spin Wheel)
- HTML5/CSS3
- jQuery/AJAX

## Author

Spin Discount System