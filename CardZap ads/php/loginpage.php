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
    <title>Login • CardZap</title>
    
    <!-- PWA Meta Tags -->
    <meta name="description" content="CardZap - Progressive Web Application for Flashcard Learning">
    <meta name="theme-color" content="#2563eb">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="CardZap">
    
    <!-- PWA Manifest -->
    <link rel="manifest" href="/manifest.json">
    
    <!-- Apple Touch Icons -->
    <link rel="apple-touch-icon" href="/icons/icon-192x192.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/icons/icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/icons/icon-192x192.png">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="/icons/icon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/icons/icon-16x16.png">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="../css/main.css" />
    <link rel="stylesheet" href="../css/loginpage.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-header">
                <div class="logo">
                    <div class="logo-icon">📚</div>
                    <span>CardZap</span>
                </div>
                <h1>Welcome back</h1>
                <p>Sign in to your account to continue learning</p>
            </div>
            
            <?php if (!empty($error)): ?>
                <div class="alert alert-error">
                    <span><?php echo htmlspecialchars($error); ?></span>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="" class="login-form">
                <div class="form-group">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="Enter your email" required>
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="Enter your password" required>
                </div>
                
                <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">
                    Sign In
                </button>
            </form>
            
            <div class="login-footer">
                <p>Don't have an account? <a href="signinpage.php">Sign up</a></p>
            </div>
        </div>
    </div>
    
    <script src="../javascript/main.js"></script>
</body>
</html>
