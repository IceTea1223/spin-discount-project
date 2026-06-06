<?php
header('Content-Type: application/json');

$courses = [
    [
        "id" => 1,
        "course" => "Web Development",
        "price" => 500,
        "schedules" => [
            ["day" => "Mon-Thur", "time" => "9:00-10:30"],
            ["day" => "Mon-Thur", "time" => "11:00-12:15"]
        ]
    ],
    [
        "id" => 2,
        "course" => "Mobile App Development",
        "price" => 600,
        "schedules" => [
            ["day" => "Sat-Sun", "time" => "8:00-11:00"],
            ["day" => "Sat-Sun", "time" => "11:00-1:45"]
        ]
    ],
    [
        "id" => 3,
        "course" => "Data Science",
        "price" => 550,
        "schedules" => [
            ["day" => "Mon-Thur", "time" => "9:00-10:30"],
            ["day" => "Mon-Thur", "time" => "11:00-12:15"]
        ]
    ],
    [
        "id" => 4,
        "course" => "UI/UX Design",
        "price" => 450,
        "schedules" => [
            ["day" => "Sat-Sun", "time" => "8:00-11:00"],
            ["day" => "Sat-Sun", "time" => "11:00-1:45"]
        ]
    ],
    [
        "id" => 5,
        "course" => "Python Programming",
        "price" => 520,
        "schedules" => [
            ["day" => "Mon-Thur", "time" => "9:00-10:30"],
            ["day" => "Mon-Thur", "time" => "11:00-12:15"]
        ]
    ],
    [
        "id" => 6,
        "course" => "Digital Marketing",
        "price" => 480,
        "schedules" => [
            ["day" => "Sat-Sun", "time" => "8:00-11:00"],
            ["day" => "Sat-Sun", "time" => "11:00-1:45"]
        ]
    ]
];

echo json_encode($courses);
?>