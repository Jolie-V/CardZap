<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>CardZap • Friends</title>
  <link rel="stylesheet" href="../css/student_friends.css" />
</head>
<body>
  <div class="app">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div><strong>CardZap</strong></div>
      <nav>
        <ul class="nav-list">
          <li><a class="nav-item" href="student_profile.php">Profile</a></li>
          <li><a class="nav-item active" href="student_friends.php">Friends</a></li>
          <li><a class="nav-item" href="student_yourcards.php">Your Cards</a></li>
          <li><a class="nav-item" href="student_enrolled.php">Enrolled Subjects</a></li>
          <li><a class="nav-item" href="student_settings.php">Settings</a></li>
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
          <button class="tab active" data-tab="friend-list">Friend List</button>
          <button class="tab" data-tab="search-people">Search People</button>
          <button class="tab" data-tab="requests">Requests</button>
        </div>

        <!-- Friend List Content -->
        <div class="friends-content" id="friend-list-content">
          <div class="search-section">
            <input type="text" class="search-input" placeholder="Search friends..." id="friend-search">
            <button class="search-btn">Search</button>
          </div>
          <div class="friends-table">
            <table>
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Level</th>
                  <th>Section</th>
                  <th>Actions</th>
                </tr>
              </thead>
                             <tbody id="friends-table-body">
                 <!-- Friends will be populated here -->
               </tbody>
            </table>
          </div>
        </div>

        <!-- Search People Content -->
        <div class="friends-content hidden" id="search-people-content">
          <div class="search-section">
            <input type="text" class="search-input" placeholder="Search for people..." id="people-search">
            <button class="search-btn">Search</button>
          </div>
          <div class="search-results" id="search-results">
            <!-- Search results will be populated here -->
          </div>
        </div>

        <!-- Requests Content -->
        <div class="friends-content hidden" id="requests-content">
          <div class="requests-list" id="requests-list">
            <!-- Friend requests will be populated here -->
          </div>
        </div>
      </div>
    </main>
  </div>

  <script src="../javascript/student_friends.js"></script>
</body>
</html>