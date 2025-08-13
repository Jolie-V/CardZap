<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CardZap • Admin Homepage</title>
    
    <!-- ===== CSS STYLES ===== -->
    <style>
      /* ===== BASE STYLES ===== */
      body {
        margin: 0;
        font-family: Arial, sans-serif;
      }
      
      /* ===== LAYOUT GRID ===== */
      /* Main application grid: sidebar (280px) + main content area */
      .app {
        display: grid;
        grid-template-columns: 280px 1fr;
        grid-template-rows: auto 1fr;
        min-height: 100vh;
      }
      
      /* ===== SIDEBAR STYLES ===== */
      /* Left sidebar with navigation */
      .sidebar {
        grid-column: 1;
        grid-row: 1 / -1;
        background: #f0f0f0;
        padding: 20px;
        border-right: 1px solid #ccc;
      }
      
      /* Navigation list styling */
      .nav-list { 
        list-style: none; 
        padding: 0; 
        margin: 0; 
      }
      
      /* Navigation item styling with hover effects */
      .nav-item { 
        padding: 10px 0; 
        text-decoration: none; 
        color: #333; 
        display: block; 
      }
      .nav-item:hover { 
        background: #ddd; 
        padding-left: 10px; 
      }
      .nav-item.active { 
        background: #ddd; 
        padding-left: 10px; 
      }
      
      /* Logout button styling */
      .logout-btn {
        margin-top: 20px;
        width: 100%;
        padding: 10px;
        background: #dc3545;
        color: white;
        border: none;
        cursor: pointer;
      }
      
      /* ===== TOPBAR STYLES ===== */
      /* Header bar with page title */
      .topbar {
        grid-column: 2;
        grid-row: 1;
        background: #e0e0e0;
        padding: 16px 24px;
        border-bottom: 1px solid #ccc;
      }
      
      .page-title {
        font-size: 24px;
        font-weight: bold;
      }
      
      /* ===== MAIN CONTENT AREA ===== */
      /* Right side content area */
      .content {
        grid-column: 2;
        grid-row: 2;
        padding: 24px;
        display: grid;
        gap: 16px;
        align-content: start;
        background: #fff;
      }
      
      /* ===== DASHBOARD CARDS ===== */
      /* Top row with metric cards (Students, Sections) */
      .cards-row { 
        display: grid; 
        grid-template-columns: repeat(2, minmax(140px, 1fr)); 
        gap: 16px; 
        max-width: 520px; 
      }
      
      /* Individual metric card styling */
      .card { 
        border: 1px solid #ccc; 
        background: #fafafa; 
        padding: 16px; 
        border-radius: 6px; 
      }
      .card h3 { 
        margin: 0 0 6px 0; 
        font-size: 14px; 
        color: #444; 
        font-weight: 600; 
      }
      .metric { 
        font-size: 36px; 
        font-weight: bold; 
        color: #333; 
      }
      
      /* Bottom row with two larger cards */
      .two-col { 
        display: grid; 
        grid-template-columns: repeat(2, minmax(240px, 1fr)); 
        gap: 16px; 
      }
      
      /* Placeholder boxes for future content */
      .empty-box { 
        height: 160px; 
        border: 1px dashed #ccc; 
        background: #f9f9f9; 
        border-radius: 6px; 
      }
    </style>
  </head>
  
  <body>
    <!-- ===== MAIN APPLICATION CONTAINER ===== -->
    <div class="app">
      
      <!-- ===== LEFT SIDEBAR ===== -->
      <aside class="sidebar">
        <!-- CardZap logo/brand -->
        <div><a href="admin_homepage.php"><strong>CardZap</strong></a></div>
        
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
        <!-- ===== METRIC CARDS ROW ===== -->
        <div class="cards-row">
          <!-- Students count card -->
          <div class="card">
            <h3>Students</h3>
            <div class="metric">0</div>
          </div>
          <!-- Sections count card -->
          <div class="card">
            <h3>Sections</h3>
            <div class="metric">0</div>
          </div>
        </div>

        <!-- ===== DASHBOARD CHARTS ROW ===== -->
        <div class="two-col">
          <!-- Student Performance chart placeholder -->
          <div class="card">
            <h3>Student Performance</h3>
            <div class="empty-box"></div>
          </div>
          <!-- Top Performing students placeholder -->
          <div class="card">
            <h3>Top Performing</h3>
            <div class="empty-box"></div>
          </div>
        </div>
      </main>
    </div>

    <!-- ===== JAVASCRIPT FUNCTIONALITY ===== -->
    <script>
      // ===== LOGOUT FUNCTIONALITY =====
      // Handle logout button click - redirect to visitor homepage
      const logoutBtn = document.querySelector('.logout-btn');
      if (logoutBtn) {
        logoutBtn.addEventListener('click', () => {
          window.location.href = 'visitor_homepage.php';
        });
      }
    </script>
  </body>
</html>
