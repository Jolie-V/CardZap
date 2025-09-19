<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CardZap • Settings</title>
    <link rel="stylesheet" href="../css/teacher_settings.css">
    <link rel="stylesheet" href="../css/main.css">
  </head>
  <body>
  <div class="app">
    <!-- ===== LEFT SIDEBAR ===== -->
    <aside class="sidebar" id="sidebar">
      <div class="sidebar-header">
        <a href="teacher_yourcards.php" class="logo">
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
      <div class="page-title">Settings</div>
      <div class="topbar-actions">
        <button class="btn btn-secondary mobile-menu-btn" id="sidebarToggle" aria-label="Open sidebar">☰</button>
      </div>
    </header>

      <!-- Main content -->
      <main class="content">
        <div class="settings-container">
          <!-- Account Settings -->
          <div class="settings-section">
            <h2 class="settings-title">Account Settings</h2>
            <a href="#" class="settings-link">Change Username</a>
            <a href="#" class="settings-link">Change Profile Picture</a>
            <a href="#" class="settings-link">Change Email</a>
          </div>

          <!-- Appearance -->
          <div class="settings-section">
            <h2 class="settings-title">Appearance</h2>
            <a href="#" class="settings-link">Dark Mode</a>
          </div>
        </div>
      </main>
    </div>

    <script src="../javascript/student_settings.js"></script>
  </body>
</html>