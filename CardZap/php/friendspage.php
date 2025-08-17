<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>CardZap • Friends</title>
  <link rel="stylesheet" href="../css/friendspage.css" />
</head>
<body>
  <div class="app">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div><strong>CardZap</strong></div>
      <nav>
        <ul class="nav-list">
          <li><a class="nav-item" href="profilepage.php">Profile</a></li>
          <li><a class="nav-item active" href="friendspage.php">Friends</a></li>
          <li><a class="nav-item" href="yourcardspage.php">Your Cards</a></li>
          <li><a class="nav-item" href="recentpage.php">Recent</a></li>
          <li><a class="nav-item" href="settingspage.php">Settings</a></li>
        </ul>
      </nav>
      <button class="logout-btn">Log out</button>
    </aside>

    <!-- Header -->
    <header class="topbar">
      <div class="page-title">Friends</div>
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
      <div class="friends-container">
        <!-- Friends Tabs -->
        <div class="friends-tabs">
          <button class="tab active">Friend List</button>
          <button class="tab">Search People</button>
          <button class="tab">Requests</button>
        </div>

        <!-- Friends Content -->
        <div class="friends-content">
          <div class="no-friends-message">No Friends.</div>
        </div>
      </div>
    </main>
  </div>

  <script src="../javascript/friendspage.js"></script>
</body>
</html>