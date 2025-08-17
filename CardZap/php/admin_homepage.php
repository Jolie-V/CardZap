<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CardZap • Admin Homepage</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../css/admin_homepage.css?v=2" />
  </head>
  
  <body>
    <!-- ===== MAIN APPLICATION CONTAINER ===== -->
    <div class="app">
      
      <!-- ===== LEFT SIDEBAR ===== -->
      <aside class="sidebar">
        <!-- CardZap logo/brand -->
        <div><a class="logo-link" href="admin_homepage.php"><strong>CardZap</strong></a></div>
        
        <!-- Navigation menu -->
        <nav>
          <ul class="nav-list">
            <li><a class="nav-item active" href="admin_homepage.php">Dashboard</a></li>
            <li><a class="nav-item" href="studentspage.php">Students</a></li>
            <li><a class="nav-item" href="sectionspage.php">Sections</a></li>
          </ul>
        </nav>
        
        <!-- Logout button -->
        <button class="logout-btn">Log out</button>
      </aside>

      <!-- ===== TOP HEADER BAR ===== -->
      <header class="topbar">
        <div class="page-title">Welcome Admin!</div>
      </header>

      <!-- ===== MAIN CONTENT AREA ===== -->
      <main class="content">
        <div class="cards-row">
          <div class="card">
            <h3>Students</h3>
            <div class="metric">0</div>
          </div>
          <div class="card">
            <h3>Sections</h3>
            <div class="metric">0</div>
          </div>
        </div>

        <div class="two-col">
          <div class="card">
            <h3>Student Performance</h3>
            <div class="empty-box"></div>
          </div>
          <div class="card">
            <h3>Top Performing</h3>
            <div class="empty-box"></div>
          </div>
        </div>
      </main>
    </div>

    <!-- JS -->
    <script src="../javascript/admin_homepage.js?v=2"></script>
  </body>
</html>