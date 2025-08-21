<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once "db.php";

// Security headers
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("Content-Security-Policy: default-src 'self'");

$error = '';

if (!$conn) {
    die("Main database connection failed.");
}

// Function to log login attempts
function logLogin($conn, $user_id, $login_time) {
    $stmt = $conn->prepare("
        INSERT INTO login_logs (user_info_id, date_login) 
        VALUES (?, ?)
    ");
    $stmt->bind_param("is", $user_id, $login_time);
    $stmt->execute();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['password'])) {
    $uname = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $pword = $_POST['password'];
    $login_time = date('Y-m-d H:i:s');

    $user_id = null; // default for failed logins

    // Query for user
    $stmt = $conn->prepare("
        SELECT user_info_id, full_name, e_mail, pass_word, contact_no, user_type, user_status 
        FROM user_info 
        WHERE e_mail = ?
    ");
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $user_id = $row['user_info_id'];

        // Check password
        if (password_verify($pword, $row['pass_word'])) {
            session_regenerate_id(true);

            $_SESSION['user_info_id'] = $row['user_info_id'];
            $_SESSION['full_name'] = $row['full_name'];
            $_SESSION['e_mail'] = $row['e_mail'];
            $_SESSION['contact_no'] = $row['contact_no'];
            $_SESSION['user_type'] = $row['user_type'];
            $_SESSION['user_status'] = $row['user_status'];

            // Log successful login
            logLogin($conn, $user_id, $login_time);

            // Redirect based on user type
            if ($row['user_type'] === 'A') {
                header("Location: admin/admin_homepage.php");
                exit();
            } elseif ($row['user_type'] === 'S') {
                header("Location: user/student/yourcardspage.php");
                exit();
            } elseif ($row['user_type'] === 'T') {
                header("Location: user/teacher/yourcardspage.php");
                exit();
            } else {
                $error = "Invalid user type.";
            }
        }
    }

    // Log failed login attempt
    logLogin($conn, $user_id, $login_time);

    $error = "Invalid email or password.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="0; url=app.php?route=login">
    <title>Redirecting…</title>
    <style>body{font-family:system-ui;padding:24px;background:#0b1220;color:#e5e7eb}a{color:#93c5fd}</style>
  </head>
  <body>
    Redirecting to the new login experience… <a href="app.php?route=login">Continue</a>
  </body>
  </html>
