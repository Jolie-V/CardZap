<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CardZap • Subjects</title>
    <link rel="stylesheet" href="../css/main.css" />
    <link rel="stylesheet" href="../css/admin_subjects.css" />
  </head>
  
  <body>
    <!-- ===== MAIN APPLICATION CONTAINER ===== -->
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
            <a href="admin_homepage.php" class="nav-link">
              <img src="https://img.icons8.com/?size=100&id=I4wZrEpGYajn&format=png&color=f0fcfe" alt="Dashboard Icon" class="nav-icon" />
              Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a href="admin_students.php" class="nav-link">
              <img src="https://img.icons8.com/?size=100&id=QlB1OMIqTVgl&format=png&color=f0fcfe" alt="Students Icon" class="nav-icon" />
              Students
            </a>
          </li>
          <li class="nav-item">
            <a href="admin_teachers.php" class="nav-link">
              <img src="https://img.icons8.com/?size=100&id=I4wZrEpGYajn&format=png&color=f0fcfe" alt="Teachers Icon" class="nav-icon" />
              Teachers
            </a>
          </li>
          <li class="nav-item">
            <a href="admin_subjects.php" class="nav-link">
              <img src="https://img.icons8.com/?size=100&id=DEg1RKY5gqD7&format=png&color=f0fcfe" alt="Subjects Icon" class="nav-icon" />
              Subjects
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
      <div class="page-title">Subjects</div>
      <div class="topbar-actions">
        <button class="btn btn-secondary mobile-menu-btn" id="sidebarToggle" aria-label="Open sidebar">☰</button>
      </div>
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