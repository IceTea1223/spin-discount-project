// Course data as JavaScript array object
const coursesData = [
  {
    id: 1,
    course: "Web + ReactJs",
    price: 149,
    schedules: [
      { type: "weekday", day: "Mon-Thur", time: "9:00-10:30", slot: "morning" },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "11:00-12:15",
        slot: "late-morning",
      },
    ],
  },
  {
    id: 2,
    course: "PHP + Laravel",
    price: 149,
    schedules: [
      { type: "weekend", day: "Sat-Sun", time: "8:00-11:00", slot: "morning" },
      {
        type: "weekend",
        day: "Sat-Sun",
        time: "11:00-1:45",
        slot: "afternoon",
      },
    ],
  },
  {
    id: 3,
    course: "Java + Spring Boot",
    price: 149,
    schedules: [
      { type: "weekday", day: "Mon-Thur", time: "9:00-10:30", slot: "morning" },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "11:00-12:15",
        slot: "late-morning",
      },
    ],
  },
  {
    id: 4,
    course: "C++/OOP/Algorithms",
    price: 69,
    schedules: [
      { type: "weekend", day: "Sat-Sun", time: "8:00-11:00", slot: "morning" },
      {
        type: "weekend",
        day: "Sat-Sun",
        time: "11:00-1:45",
        slot: "afternoon",
      },
    ],
  },
  {
    id: 5,
    course: "Python/OOP/Flask API",
    price: 79,
    schedules: [
      { type: "weekday", day: "Mon-Thur", time: "9:00-10:30", slot: "morning" },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "11:00-12:15",
        slot: "late-morning",
      },
    ],
  },
  {
    id: 6,
    course: "UX-UI Design",
    price: 89,
    schedules: [
      { type: "weekend", day: "Sat-Sun", time: "8:00-11:00", slot: "morning" },
      {
        type: "weekend",
        day: "Sat-Sun",
        time: "11:00-1:45",
        slot: "afternoon",
      },
    ],
  },
  {
    id: 7,
    course: "Adobe Photoshop + illustrator + Projects",
    price: 89,
    schedules: [
      { type: "weekend", day: "Sat-Sun", time: "8:00-11:00", slot: "morning" },
      {
        type: "weekend",
        day: "Sat-Sun",
        time: "11:00-1:45",
        slot: "afternoon",
      },
    ],
  },
  {
    id: 8,
    course: "Java/OOP/MySQL",
    price: 89,
    schedules: [
      { type: "weekend", day: "Sat-Sun", time: "8:00-11:00", slot: "morning" },
      {
        type: "weekend",
        day: "Sat-Sun",
        time: "11:00-1:45",
        slot: "afternoon",
      },
    ],
  },
  {
    id: 9,
    course: "Mobile App + Laravel",
    price: 149,
    schedules: [
      { type: "weekend", day: "Sat-Sun", time: "8:00-11:00", slot: "morning" },
      {
        type: "weekend",
        day: "Sat-Sun",
        time: "11:00-1:45",
        slot: "afternoon",
      },
    ],
  },
  {
    id: 10,
    course: "Basic Network + IT Support",
    price: 99,
    schedules: [
      { type: "weekend", day: "Sat-Sun", time: "8:00-11:00", slot: "morning" },
      {
        type: "weekend",
        day: "Sat-Sun",
        time: "11:00-1:45",
        slot: "afternoon",
      },
    ],
  },
  {
    id: 11,
    course: "Basic Network + Cyber Security",
    price: 99,
    schedules: [
      { type: "weekend", day: "Sat-Sun", time: "8:00-11:00", slot: "morning" },
      {
        type: "weekend",
        day: "Sat-Sun",
        time: "11:00-1:45",
        slot: "afternoon",
      },
    ],
  },
];

// Function to get course by ID
function getCourseById(id) {
  return coursesData.find((course) => course.id === parseInt(id));
}

// Function to get all courses
function getAllCourses() {
  return coursesData;
}
