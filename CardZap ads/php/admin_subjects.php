<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CardZap • Subjects</title>
    <link rel="stylesheet" href="../css/admin_subjects.css" />
  </head>
  
  <body>
    <div class="app">
      
      <!-- ===== SIDEBAR ===== -->
      <aside class="sidebar">
        <div>
          <a class="logo-link" href="admin_homepage.php"><strong>CardZap</strong></a>
        </div>

        <nav>
          <ul class="nav-list">
            <li><a class="nav-item" href="admin_students.php">Students</a></li>
            <li><a class="nav-item" href="admin_teachers.php">Teachers</a></li>
            <li><a class="nav-item active" href="admin_subjects.php">Subjects</a></li>
          </ul>
        </nav>

        <button class="logout-btn">Log out</button>
      </aside>

      <!-- ===== TOPBAR ===== -->
      <header class="topbar">
        <div class="page-title">Sections</div>
      </header>

      <!-- ===== MAIN CONTENT ===== -->
      <main class="content">
        <div class="grid" id="subjectsGrid">
          <!-- Subject cards will be populated here -->
        </div>
      </main>
    </div>

    <script src="../javascript/admin_subjects.js"></script>
  </body>
</html>