<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CardZap • Students</title>
    
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
      
      /* CardZap logo link styling */
      .logo-link { 
        color: inherit; 
        text-decoration: none; 
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
      
      /* ===== SEARCH FUNCTIONALITY ===== */
      /* Search bar row with input and button */
      .search-row { 
        display: flex; 
        gap: 8px; 
        align-items: center; 
      }
      
      /* Search input field */
      .search-input { 
        flex: 0 1 360px; 
        padding: 8px; 
        border: 1px solid #ccc; 
        border-radius: 4px; 
      }
      
      /* Search button */
      .search-btn { 
        padding: 8px 12px; 
        border: none; 
        background: #007bff; 
        color: white; 
        border-radius: 4px; 
        cursor: pointer; 
      }
      
      /* ===== STUDENT TABLE ===== */
      /* Table container card */
      .table-card { 
        border: 1px solid #ccc; 
        background: #fafafa; 
        border-radius: 6px; 
        overflow: hidden; 
      }
      
      /* Table styling */
      table { 
        width: 100%; 
        border-collapse: collapse; 
      }
      
      /* Table header styling */
      thead { 
        background: #eef6f6; 
      }
      
      /* Table cell styling */
      th, td { 
        padding: 12px 16px; 
        border-bottom: 1px solid #e5e5e5; 
        text-align: left; 
        font-size: 14px; 
      }
      
      /* Narrow columns for year, section, and actions */
      th.small { 
        width: 100px; 
      }
      
      /* Empty state message */
      .empty-hint { 
        padding: 12px 16px; 
        color: #777; 
        font-size: 14px; 
      }
    </style>
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


