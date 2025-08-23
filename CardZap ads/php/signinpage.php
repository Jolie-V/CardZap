<?php
require 'db.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $contact_no = trim($_POST['contact']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['password2']);
    $user_type_input = $_POST['user_type'] ?? ''; // from radio buttons
    $course = $_POST['course'] ?? '';

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format.');</script>";
        exit;
    }

    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match.');</script>";
        exit;
    }

    // Validate user type and set course accordingly
    $user_type = '';
    if ($user_type_input === 'student') {
        $user_type = 'S';
        // keep selected course
    } elseif ($user_type_input === 'teacher') {
        $user_type = 'T';
        $course = 'N/A'; // teachers should always be N/A
    } else {
        echo "<script>alert('Invalid user type.');</script>";
        exit;
    }

    // Check if email exists
    $stmt = $conn->prepare("SELECT user_info_id FROM user_info WHERE e_mail = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo "<script>alert('Email is already registered.');</script>";
        exit;
    }
    $stmt->close();

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert into user_info
    $stmt = $conn->prepare("INSERT INTO user_info (full_name, e_mail, contact_no, pass_word, course, user_type, user_status) VALUES (?, ?, ?, ?, ?, ?, 'A')");
    $stmt->bind_param("ssssss", $fname, $email, $contact_no, $hashed_password, $course, $user_type);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Signup successful! Redirecting to login...'); window.location.href = 'loginpage.php';</script>";
    exit;
}
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sign up • FlashLearn</title>
    <link rel="stylesheet" href="css/signinpage.css" />
    <script>
      // Simple JS to toggle the Course dropdown
      document.addEventListener("DOMContentLoaded", () => {
        const studentRadio = document.getElementById("student");
        const teacherRadio = document.getElementById("teacher");
        const additionalPart = document.getElementById("additionalPart");

        function toggleCourse() {
          if (studentRadio.checked) {
            additionalPart.style.display = "block";
          } else {
            additionalPart.style.display = "none";
          }
        }

        studentRadio.addEventListener("change", toggleCourse);
        teacherRadio.addEventListener("change", toggleCourse);
        toggleCourse(); // run on page load
      });
    </script>
  </head>
  <body>
    <header class="topnav">
      <div class="brand">FlashLearn</div>
    </header>
    <main class="wrap">

      <form class="card" method="post" action="#">

        <h1 class="title">Sign up</h1>

        <div class="field">
          <label for="su-fullname">Full Name</label>
          <input id="su-fullname" name="fullname" type="text" required />
        </div>

        <div class="field">
          <label for="su-email">Email</label>
          <input id="su-email" name="email" type="email" required />
        </div>

        <div class="field">
          <label for="su-contact">Contact no.</label>
          <input id="su-contact" name="contact" type="number" required />
        </div>

        <div class="field">
          <label for="su-password">Password</label>
          <input id="su-password" name="password" type="password" required />
        </div>

        <div class="field">
          <label for="su-password2">Re-type password</label>
          <input id="su-password2" name="password2" type="password" required />
        </div>

        <div class="user-type-field">
          <label>I am a:</label>
          <div class="user-type-options">
            <div class="user-type-option">
              <input type="radio" id="student" name="user_type" value="student" required>
              <label for="student">Student</label>
            </div>
            <div class="user-type-option">
              <input type="radio" id="teacher" name="user_type" value="teacher" required>
              <label for="teacher">Teacher</label>
            </div>
          </div>
        </div>

        <div id="additionalPart" style="display: none;">
          <!-- This div will be shown/hidden -->
          <label for="course">Course:</label>
          <select  id="course" name="course">
            <option value="BSED">Bachelor in Secondary Education</option>
            <option value="BEED">Bachelor in Elementary Education</option>
            <option value="BSCS">Bachelor of Science in Computer Science</option>
            <option value="BSIT">Bachelor of Science in Information Technology</option>
            <option value="ANIMATION">BSIT with Specialization in Animation</option>
            <option value="BSIS">Bachelor of Science in Information System</option>
            <option value="BSCPE">Bachelor of Science in Computer Engineering</option>
            <option value="BSECE">Bachelor of Science in Electronics Engineering</option>
            <option value="ENTREP">Bachelor of Science in Entrepreneurship</option>
            <option value="NURSING">Bachelor of Science in Nursing</option>
            <option value="BSET">Bachelor of Science in Electrical Technology</option>
            <option value="BSELT">Bachelor of Science in Electronics Technology</option>
            <option value="BSAT">Bachelor of Science in Automotive Technology</option>
            <option value="BSMT">Bachelor of Science in Mechanical Technology</option>
          </select>
        </div>

        <div class="actions">
          <button class="btn" type="submit">Create account</button>
          <div class="link">Already a user? <a href="loginpage.php">Log in</a></div>
        </div>

      </form>
    </main>
  </body>
</html>
