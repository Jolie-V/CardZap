<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CardZap • Teachers</title>

    <!-- External CSS -->
    <link rel="stylesheet" href="../css/admin_teachers.css">
  </head>
  
  <body>
    <div class="app">
      
      <!-- ===== SIDEBAR ===== -->
      <aside class="sidebar">
        <div><a class="logo-link" href="admin_homepage.php"><strong>CardZap</strong></a></div>

        <nav>
          <ul class="nav-list">
            <li><a class="nav-item" href="admin_students.php">Students</a></li>
            <li><a class="nav-item active" href="admin_teachers.php">Teachers</a></li>
            <li><a class="nav-item" href="admin_subjects.php">Subjects</a></li>
          </ul>
        </nav>

        <button class="logout-btn">Log out</button>
      </aside>

      <!-- ===== TOPBAR ===== -->
      <header class="topbar">
        <div class="page-title">Teachers</div>
        <div class="topbar-actions">
          <input id="teacherSearch" class="search-input" type="text" placeholder="Search" />
          <button id="teacherSearchBtn" class="btn btn-secondary">Search</button>
        </div>
      </header>

      <!-- ===== MAIN CONTENT ===== -->
      <main class="content">
        <div class="panel">
          <h4>Registration Requests</h4>
          <div id="requestsList" class="list"></div>

          <h4 class="mt">Registered Teachers</h4>
          <div id="registeredList" class="list"></div>
        </div>
      </main>
    </div>

    <!-- External JS -->
    <script src="../javascript/admin_teachers.js"></script>
  </body>
  
</html>


