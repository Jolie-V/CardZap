<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CardZap • Students</title>

    <!-- External CSS -->
    <link rel="stylesheet" href="../css/studentspage.css">
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
            <li><a class="nav-item" href="admin_homepage.php">Dashboard</a></li>
            <li><a class="nav-item active" href="studentspage.php">Students</a></li>
            <li><a class="nav-item" href="sectionspage.php">Sections</a></li>
          </ul>
        </nav>
        
        <!-- Logout button -->
        <button class="logout-btn">Log out</button>
      </aside>

      <!-- ===== TOP HEADER BAR ===== -->
      <header class="topbar">
        <div class="page-title">Students</div>
      </header>

      <!-- ===== MAIN CONTENT AREA ===== -->
      <main class="content">
        <!-- ===== SEARCH BAR ===== -->
        <div class="search-row">
          <input class="search-input" type="text" placeholder="Search students" />
          <button class="search-btn">Search</button>
        </div>

        <!-- ===== STUDENT TABLE ===== -->
        <div class="table-card">
          <table>
            <!-- Table header with column names -->
            <thead>
              <tr>
                <th>NAME</th>
                <th class="small">YEAR</th>
                <th class="small">SECTION</th>
                <th class="small">ACTIONS</th>
              </tr>
            </thead>
            <!-- Table body for student data (currently empty) -->
            <tbody>
              <!-- Student rows will be populated here when system is implemented -->
            </tbody>
          </table>
          <!-- Empty state message -->
          <div class="empty-hint">No students yet.</div>
        </div>
      </main>
    </div>

    <!-- External JS -->
    <script src="../javascript/studentspage.js"></script>
  </body>
</html>
