<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CardZap • Students</title>

    <!-- External CSS -->
    <link rel="stylesheet" href="../css/main.css">
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
      <div class="page-title">Students</div>
      <div class="topbar-actions">
        <button class="btn btn-secondary mobile-menu-btn" id="sidebarToggle" aria-label="Open sidebar">☰</button>
      </div>
    </header>

      <!-- ===== MAIN CONTENT AREA ===== -->
      <main class="content">
      <!-- ===== SEARCH BAR ===== -->
      <div class="search-row" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
      <form id="searchForm" method="get" style="display: flex; gap: 8px; flex: 1;">
      <input class="search-input" type="text" name="q" placeholder="🔍 Search students..." value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>" style="padding: 10px 14px; border-radius: 6px; border: 1px solid #d0d7de; width: 100%;"/>
      <button class="search-btn btn btn-primary" type="submit" style="padding: 10px 18px; border-radius: 6px;">Search</button>
      </form>
      </div>

      <!-- ===== STUDENT TABLE ===== -->
      <div class="table-card" style="background: #fff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); padding: 24px;">
      <table style="width: 100%; border-collapse: collapse;">
      <!-- Table header with column names -->
      <thead>
      <tr style="background: #f6f8fa;">
      <th style="padding: 12px 8px; text-align: left; letter-spacing: 1px;">NAME</th>
      <th class="small" style="padding: 12px 8px; text-align: left;">COURSE</th>
      <th class="small" style="padding: 12px 8px; text-align: left;">ACTIONS</th>
      </tr>
      </thead>
      <!-- Table body for student data -->
      <tbody>
      <?php
      // Example DB connection (adjust as needed)
      $conn = new mysqli("localhost", "root", "", "cardzap");
      if ($conn->connect_error) {
      echo '<tr><td colspan="3" style="text-align:center; color: #d32f2f;">Database connection failed.</td></tr>';
      } else {
      $search = isset($_GET['q']) ? $conn->real_escape_string($_GET['q']) : '';
      $sql = "SELECT user_info_id, full_name, course FROM user_info WHERE user_type = 'S'";
      if ($search !== '') {
        $sql .= " AND (full_name LIKE '%$search%' OR course LIKE '%$search%')";
      }
      $sql .= " ORDER BY full_name ASC";
      $result = $conn->query($sql);

      if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
        echo "<tr style='border-bottom: 1px solid #f0f0f0;'>";
        echo "<td style='padding: 12px 8px;'>" . htmlspecialchars($row['full_name']) . "</td>";
        echo "<td class='small' style='padding: 12px 8px;'>" . htmlspecialchars($row['course']) . "</td>";
        echo "<td class='small' style='padding: 12px 8px;'>
        <a href='edit_student.php?id=" . $row['user_info_id'] . "' class='btn btn-sm btn-primary' style='margin-right: 8px;'>Edit</a>
        <a href='delete_student.php?id=" . $row['user_info_id'] . "' class='btn btn-sm btn-danger' style='background: #e57373; border: none;' onclick=\"return confirm('Delete this student?');\">Delete</a>
        </td>";
        echo "</tr>";
        }
      } else {
        echo '<tr><td colspan="3" style="text-align:center; color: #888; padding: 24px 0;">No students found.</td></tr>';
      }
      $conn->close();
      }
      ?>
      </tbody>
      </table>
      </div>
      </main>
    </div>

    <!-- External JS -->
    <script src="../javascript/admin_students.js"></script>
  </body>
</html>
