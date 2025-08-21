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
    <meta http-equiv="refresh" content="0; url=app.php?route=signup">
    <title>Redirecting…</title>
    <style>body{font-family:system-ui;padding:24px;background:#0b1220;color:#e5e7eb}a{color:#93c5fd}</style>
  </head>
  <body>
    Redirecting to the new signup experience… <a href="app.php?route=signup">Continue</a>
  </body>
</html>
