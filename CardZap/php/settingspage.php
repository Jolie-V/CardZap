<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>FlashLearn • Settings</title>
    <link rel="stylesheet" href="settings.css">
  </head>
  <body>
    <div class="app">
      <!-- Sidebar -->
      <aside class="sidebar">
        <div>
          <strong>FlashLearn</strong>
        </div>
        <nav>
          <ul class="nav-list">
            <li><a class="nav-item" href="profilepage.php">Profile</a></li>
            <li><a class="nav-item" href="friendspage.php">Friends</a></li>
            <li><a class="nav-item" href="yourcardspage.php">Your Cards</a></li>
            <li><a class="nav-item" href="recentpage.php">Recent</a></li>
            <li><a class="nav-item active" href="settingspage.php">Settings</a></li>
          </ul>
        </nav>
        <button class="logout-btn">Log out</button>
      </aside>

      <!-- Header -->
      <header class="topbar">
        <div class="page-title">Settings</div>
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

    <script src="settings.js"></script>
  </body>
</html>
