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

        if (password_verify($pword, $row['pass_word'])) {
            session_regenerate_id(true);

            $_SESSION['user_info_id'] = $row['user_info_id'];
            $_SESSION['full_name'] = $row['full_name'];
            $_SESSION['e_mail'] = $row['e_mail'];
            $_SESSION['contact_no'] = $row['contact_no'];
            $_SESSION['user_type'] = $row['user_type'];
            $_SESSION['user_status'] = $row['user_status'];

            // log successful login
            logLogin($conn, $user_id, $login_time);

            if ($row['user_type'] === 'A') {
                header("Location: admin_homepage.php");
                exit();
            } elseif ($row['user_type'] === 'S') {
                header("Location: student_yourcards.php");
                exit();
            } elseif ($row['user_type'] === 'T') {
                header("Location: teacher_yourcards.php");
                exit();
            } else {
                $error = "Invalid user type.";
            }
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login • CardZap</title>

  <!-- Stylesheets -->
  <link rel="stylesheet" href="../css/signinpage.css" />
  <style>
    .title {
      margin: 0 0 24px;
      font-size: 24px;
      text-align: center;
    }

    .error-message {
      background-color: #fee2e2;
      color: #b91c1c;
      padding: 10px 12px;
      border-radius: 8px;
      margin-bottom: 16px;
      text-align: center;
    }

    .form-group {
      display: grid;
      gap: 6px;
      margin-bottom: 16px;
    }

    .form-label {
      font-size: 12px;
      color: var(--muted);
    }

    .form-input {
      padding: 10px 12px;
      border: 1px solid var(--border);
      border-radius: 8px;
      font-size: 14px;
      width: 100%;
    }

    .login-footer {
      margin-top: 16px;
      text-align: center;
      font-size: 14px;
    }

    .login-footer a {
      color: var(--primary);
      text-decoration: none;
    }

  </style>
</head>
<body>
  <main class="wrap">
    <form class="card" method="POST" action="">
      <h1 class="title">Welcome Back</h1>

      <?php if (!empty($error)): ?>
        <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
      <?php endif; ?>

      <div class="form-group">
        <label for="email" class="form-label">Email address</label>
        <input type="email" id="email" name="email" class="form-input" required placeholder="Enter your email">
      </div>

      <div class="form-group">
        <label for="password" class="form-label">Password</label>
        <input type="password" id="password" name="password" class="form-input" required placeholder="Enter your password">
      </div>

      <div class="actions">
        <button class="btn" type="submit" style="width: 100%;">Sign In</button>
        <div class="login-footer">
          Don't have an account? <a href="signinpage.php">Sign up</a>
        </div>
      </div>
    </form>
  </main>
</body>
</html>
