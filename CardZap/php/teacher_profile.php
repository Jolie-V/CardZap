<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>CardZap • Profile</title>
  <link rel="stylesheet" href="../css/teacher_profile.css" />
</head>
<body>
  <div class="app">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div>
        <strong>CardZap</strong>
      </div>
      <nav>
        <ul class="nav-list">
          <li><a class="nav-item active" href="teacher_profile.php">Profile</a></li>
          <li><a class="nav-item" href="student_friends.php">Friends</a></li>
          <li><a class="nav-item" href="teacher_yourcards.php">Your Cards</a></li>
          <li><a class="nav-item" href="teacher_subjects.php">Enrolled Subjects</a></li>
          <li><a class="nav-item" href="teacher_settings.php">Settings</a></li>
        </ul>
      </nav>
      <button class="logout-btn">Log out</button>
    </aside>

    <!-- Header -->
    <header class="topbar">
      <div class="page-title">Profile</div>
      <div class="notification-container">
        <button class="notification-btn">🔔</button>
        <div class="notification-popup">
          <div class="notification-header">Notifications</div>
          <div class="notification-content">No new notifications.</div>
        </div>
      </div>
    </header>

    <!-- Main content -->
    <main class="content">
      <div class="profile-container">
        <!-- Profile Header -->
        <div class="profile-header">
          <div class="profile-avatar">👤</div>
          <div class="profile-info">
            <h1 class="profile-username">Username</h1>
            <p class="profile-email">email@gmail.com</p>
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
            <div class="stat-number">0%</div>
            <div class="stat-label">Top Score</div>
          </div>
        </div>

        <!-- Progress Section -->
        <div class="progress-section">
          <h2 class="progress-title">Progress</h2>
          <div class="progress-content">
            <!-- Progress content will go here -->
          </div>
        </div>
      </div>
    </main>
  </div>

  <script src="../javascript/teacher_profile.js"></script>
</body>
</html>

