// Course data as JavaScript array object with conditional pricing
const coursesData = [
  {
    id: 1,
    course: "Web + ReactJs",
    schedules: [
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "9:00-10:30",
        slot: "morning",
        price: 99,
      },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "11:00-12:15",
        slot: "afternoon",
        price: 149,
      },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "2:00-3:15",
        slot: "afternoon",
        price: 149,
      },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "3:30-5:00",
        slot: "evening",
        price: 149,
      },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "6:00-7:15",
        slot: "afternoon",
        price: 149,
      },
      {
        type: "weekend",
        day: "Sat-Sun",
        time: "8:00-11:00",
        slot: "morning",
        price: 99,
      },
      {
        type: "weekend",
        day: "Sat-Sun",
        time: "11:00-13:30",
        slot: "afternoon",
        price: 149,
      },
      {
        type: "weekend",
        day: "Sat-Sun",
        time: "2:00-5:00",
        slot: "evening",
        price: 149,
      },
    ],
  },
  {
    id: 2,
    course: "PHP + Laravel",
    schedules: [
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "9:00-10:30",
        slot: "morning",
        price: 99,
      },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "12:30-1:45",
        slot: "afternoon",
        price: 149,
      },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "2:00-3:15",
        slot: "afternoon",
        price: 149,
      },
      {
        type: "weekend",
        day: "Sat-Sun",
        time: "11:00-13:30",
        slot: "afternoon",
        price: 149,
      },
      {
        type: "weekend",
        day: "Sat-Sun",
        time: "2:00-5:00",
        slot: "evening",
        price: 149,
      },
    ],
  },
  {
    id: 3,
    course: "Java + Spring Boot",
    schedules: [
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "9:00-10:30",
        slot: "morning",
        price: 99,
      },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "12:30-1:45",
        slot: "afternoon",
        price: 149,
      },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "2:00-3:15",
        slot: "afternoon",
        price: 149,
      },
      {
        type: "weekend",
        day: "Sat-Sun",
        time: "11:00-13:30",
        slot: "afternoon",
        price: 149,
      },
      {
        type: "weekend",
        day: "Sat-Sun",
        time: "2:00-5:00",
        slot: "evening",
        price: 149,
      },
    ],
  },
  {
    id: 4,
    course: "C++/OOP/Algorithms",
    schedules: [
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "9:00-10:30",
        slot: "morning",
        price: 69,
      },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "12:30-1:45",
        slot: "afternoon",
        price: 69,
      },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "3:30-5:00",
        slot: "evening",
        price: 69,
      },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "6:00-7:15",
        slot: "afternoon",
        price: 69,
      },
      {
        type: "weekend",
        day: "Sat-Sun",
        time: "11:00-13:30",
        slot: "afternoon",
        price: 69,
      },
    ],
  },
  {
    id: 5,
    course: "Python/OOP/Flask API",
    schedules: [
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "11:00-12:15",
        slot: "afternoon",
        price: 79,
      },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "12:30-1:45",
        slot: "afternoon",
        price: 79,
      },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "2:00-3:15",
        slot: "evening",
        price: 79,
      },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "6:00-7:15",
        slot: "afternoon",
        price: 79,
      },
      {
        type: "weekend",
        day: "Sat-Sun",
        time: "11:00-13:30",
        slot: "afternoon",
        price: 79,
      },
      {
        type: "weekend",
        day: "Sat-Sun",
        time: "2:00-5:00",
        slot: "evening",
        price: 79,
      },
    ],
  },
  {
    id: 6,
    course: "UX-UI Design",
    schedules: [
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "9:00-10:30",
        slot: "morning",
        price: 89,
      },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "11:00-12:15",
        slot: "afternoon",
        price: 89,
      },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "12:30-1:45",
        slot: "afternoon",
        price: 89,
      },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "2:00-3:15",
        slot: "afternoon",
        price: 89,
      },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "3:30-5:00",
        slot: "evening",
        price: 89,
      },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "6:00-7:15",
        slot: "afternoon",
        price: 89,
      },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "7:15-8:30",
        slot: "afternoon",
        price: 89,
      },
      {
        type: "weekend",
        day: "Sat-Sun",
        time: "8:00-11:00",
        slot: "morning",
        price: 89,
      },
      {
        type: "weekend",
        day: "Sat-Sun",
        time: "11:00-13:30",
        slot: "afternoon",
        price: 89,
      },
      {
        type: "weekend",
        day: "Sat-Sun",
        time: "2:00-5:00",
        slot: "evening",
        price: 89,
      },
    ],
  },
  {
    id: 7,
    course: "Adobe Photoshop + illustrator + Projects",
    schedules: [
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "9:00-10:30",
        slot: "morning",
        price: 89,
      },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "11:00-12:15",
        slot: "afternoon",
        price: 89,
      },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "12:30-1:45",
        slot: "afternoon",
        price: 89,
      },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "2:00-3:15",
        slot: "afternoon",
        price: 89,
      },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "3:30-5:00",
        slot: "evening",
        price: 89,
      },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "6:00-7:15",
        slot: "afternoon",
        price: 89,
      },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "7:15-8:30",
        slot: "afternoon",
        price: 89,
      },
      {
        type: "weekend",
        day: "Sat-Sun",
        time: "8:00-11:00",
        slot: "morning",
        price: 89,
      },
      {
        type: "weekend",
        day: "Sat-Sun",
        time: "11:00-13:30",
        slot: "afternoon",
        price: 89,
      },
      {
        type: "weekend",
        day: "Sat-Sun",
        time: "2:00-5:00",
        slot: "evening",
        price: 89,
      },
    ],
  },
  {
    id: 8,
    course: "Java/OOP/MySQL",
    schedules: [
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "12:30-1:45",
        slot: "afternoon",
        price: 89,
      },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "3:30-5:00",
        slot: "evening",
        price: 89,
      },
      {
        type: "weekend",
        day: "Sat-Sun",
        time: "2:00-5:00",
        slot: "evening",
        price: 89,
      },
    ],
  },
  {
    id: 9,
    course: "Mobile App + Laravel",
    schedules: [
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "11:00-12:15",
        slot: "afternoon",
        price: 149,
      },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "3:30-5:00",
        slot: "evening",
        price: 149,
      },
      {
        type: "weekend",
        day: "Sat-Sun",
        time: "11:00-13:30",
        slot: "afternoon",
        price: 149,
      },
    ],
  },
  {
    id: 10,
    course: "Basic Network + IT Support",
    schedules: [
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "9:00-10:30",
        slot: "morning",
        price: 99,
      },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "12:30-1:45",
        slot: "afternoon",
        price: 99,
      },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "3:30-5:00",
        slot: "evening",
        price: 99,
      },
      {
        type: "weekend",
        day: "Sat-Sun",
        time: "8:00-11:00",
        slot: "morning",
        price: 99,
      },
      {
        type: "weekend",
        day: "Sat-Sun",
        time: "11:00-13:30",
        slot: "afternoon",
        price: 99,
      },
    ],
  },
  {
    id: 11,
    course: "Basic Network + Cyber Security",
    schedules: [
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "9:00-10:30",
        slot: "morning",
        price: 99,
      },
      {
        type: "weekday",
        day: "Mon-Thur",
        time: "2:00-3:15",
        slot: "afternoon",
        price: 99,
      },
      {
        type: "weekend",
        day: "Sat-Sun",
        time: "11:00-13:30",
        slot: "afternoon",
        price: 99,
      },
    ],
  },
];

// Helper function to get price for a specific schedule
function getSchedulePrice(courseId, scheduleIndex) {
  const course = coursesData.find((c) => c.id === courseId);
  if (course && course.schedules[scheduleIndex]) {
    return course.schedules[scheduleIndex].price;
  }
  return null;
}

// Function to get course by ID
function getCourseById(id) {
  return coursesData.find((course) => course.id === parseInt(id));
}

// Function to get all courses
function getAllCourses() {
  return coursesData;
}

// Function to get course price based on selected schedule
function getCoursePriceBySchedule(courseId, scheduleTime, scheduleType) {
  const course = getCourseById(courseId);
  if (!course) return null;

  const schedule = course.schedules.find(
    (s) => s.time === scheduleTime && s.type === scheduleType,
  );

  return schedule ? schedule.price : null;
}
