<?php
session_start();
include_once "db.php";

// Redirect to login if not logged in
if (!isset($_SESSION['user_info_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_info_id'];
$userData = null;

if ($conn) {
    $stmt = $conn->prepare("SELECT full_name, course, e_mail, photo FROM user_info WHERE user_info_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows === 1) {
        $userData = $result->fetch_assoc();
    } else {
        header("Location: login.php");
        exit();
    }
} else {
    die("Database connection failed.");
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>CardZap • Profile</title>
  <link rel="stylesheet" href="../css/student_profile.css" />
  <link rel="stylesheet" href="../css/main.css" />
  <style>
    .profile-photo {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      object-fit: cover;
    }
  </style>
</head>
<body>
  <!-- Main Application Container -->
  <div class="app">
    <!-- ===== LEFT SIDEBAR ===== -->
    <aside class="sidebar" id="sidebar">
      <div class="sidebar-header">
        <a href="admin_homepage.php" class="logo">
          <img src="../css/CardZapLogo.png" alt="Dashboard Icon" class="logo-img" />
          <span>CardZap</span>
        </a>
      </div>

      <!-- Navigation menu -->
      <nav>
        <ul class="nav-list">
          <li class="nav-item">
            <a href="teacher_profile.php" class="nav-link">
              <img src="https://img.icons8.com/?size=100&id=QlB1OMIqTVgl&format=png&color=f0fcfe" alt="Profile" class="nav-icon" />
              Profile
            </a>
          </li>
          <li class="nav-item">
            <a href="teacher_yourcards.php" class="nav-link">
              <img src="https://img.icons8.com/?size=100&id=04GSmQqf0WPl&format=png&color=f0fcfe" alt="YourCards" class="nav-icon" />
              Your Cards
            </a>
          </li>
          <li class="nav-item">
            <a href="teacher_subjects.php" class="nav-link">
              <img src="https://img.icons8.com/?size=100&id=ssqfwv5zvoTR&format=png&color=f0fcfe" alt="Subjcts" class="nav-icon" />
              Created Subjects
            </a>
          </li>
          <li class="nav-item">
            <a href="teacher_settings.php" class="nav-link">
              <img src="https://img.icons8.com/?size=100&id=yku81UQEXoew&format=png&color=f0fcfe" alt="Settings" class="nav-icon" />
              Settings
            </a>
          </li>
        </ul>
      </nav>

      <!-- Logout button -->
      <div class="sidebar-footer">
        <form action="logout.php" method="post" style="width: 100%;">
          <button type="submit" class="btn btn-danger" style="width: 100%;">Log out</button>
        </form>
      </div>
    </aside>

    <!-- Sidebar overlay for mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- ===== TOP HEADER BAR ===== -->
    <header class="topbar">
      <div class="page-title">Profile</div>
      <div class="topbar-actions">
        <button class="btn btn-secondary mobile-menu-btn" id="sidebarToggle" aria-label="Open sidebar">☰</button>
      </div>
    </header>

    <!-- Main content -->
    <main class="content">
      <div class="profile-container">
        <!-- Profile Header -->
        <div class="profile-header">
          <div class="profile-avatar">
            <?php if (!empty($userData['photo'])): ?>
              <img src="<?php echo htmlspecialchars($userData['photo'] ?: '../css/default-avatar.png'); ?>" alt="Profile Photo" class="profile-photo" />
            <?php else: ?>
              <img src="../css/default-avatar.png" class="profile-photo">
            <?php endif; ?>
          </div>
          <div class="profile-info">
            <h1 class="profile-username"><?php echo htmlspecialchars($userData['full_name']); ?></h1>
            <a>Teacher</a>
            <p class="profile-email"><?php echo htmlspecialchars($userData['e_mail']); ?></p>
          </div>
        </div>

        <!-- Statistics -->
        <div class="profile-stats">
          <div class="stat-item">
            <div class="stat-number">0</div>
            <div class="stat-label">Created Decks</div>
          </div>
          <div class="stat-item">
            <div class="stat-number">0</div>
            <div class="stat-label">Finished Decks</div>
          </div>
          <div class="stat-item">
            <div class="stat-number">0</div>
            <div class="stat-label">Created Subjects</div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script src="../javascript/student_profile.js"></script>
</body>
</html>
