<?php
session_start();
require_once 'db.php';
require_user_type(['A']);

// Fetch total students from user_info table
$total_students = 0;
$sql = "SELECT COUNT(*) AS total FROM user_info WHERE user_type = 'S'";
$result = $conn->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $total_students = $row['total'];
}

$total_teachers = 0;
$sql = "SELECT COUNT(*) AS total FROM user_info WHERE user_type = 'T'";
$result = $conn->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $total_teachers = $row['total'];
}

$total_subjects = 0;
$sql = "SELECT COUNT(*) AS total FROM subjects";
$result = $conn->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $total_subjects = $row['total'];
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Dashboard • CardZap</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../css/main.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  </head>
  
  <body>
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
        <a href="admin_homepage.php" class="nav-link active">
          <img src="https://img.icons8.com/?size=100&id=I4wZrEpGYajn&format=png&color=f0fcfe" alt="Dashboard Icon" class="nav-icon" />
          Dashboard
        </a>
        </li>
        <li class="nav-item">
        <a href="admin_students.php" class="nav-link">
          <img src="https://img.icons8.com/?size=100&id=QlB1OMIqTVgl&format=png&color=f0fcfe" alt="Dashboard Icon" class="nav-icon" />
          Students
        </a>
        </li>
        <li class="nav-item">
        <a href="admin_teachers.php" class="nav-link">
          <img src="https://img.icons8.com/?size=100&id=I4wZrEpGYajn&format=png&color=f0fcfe" alt="Dashboard Icon" class="nav-icon" />
          Teachers
        </a>
        </li>
        <li class="nav-item">
        <a href="admin_subjects.php" class="nav-link">
          <img src="https://img.icons8.com/?size=100&id=DEg1RKY5gqD7&format=png&color=f0fcfe" alt="Dashboard Icon" class="nav-icon" />
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
      <div class="page-title">Admin Dashboard</div>
      <div class="topbar-actions">
        <button class="btn btn-secondary mobile-menu-btn" id="sidebarToggle" aria-label="Open sidebar">☰</button>
      </div>
    </header>

    <!-- ===== MAIN CONTENT AREA ===== -->
    <main class="content">
      <!-- Welcome Section -->
      <div class="welcome-section mb-6">
        <h1>Welcome back, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</h1>
        <p class="text-gray-600">Here's what's happening with your platform today.</p>
      </div>

      <!-- Metrics Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Total Students</h3>
            <img src="https://img.icons8.com/?size=100&id=QlB1OMIqTVgl&format=png&color=3a728e" alt="Dashboard Icon" class="nav-icon" />
          </div>
          <div class="card-body">
            <div class="metric metric-students"><?php echo $total_students; ?></div>
            <p class="text-sm text-gray-600">Active students</p>
          </div>
        </div>
        
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Total Teachers</h3>
            <img src="https://img.icons8.com/?size=100&id=I4wZrEpGYajn&format=png&color=3a728e" alt="Dashboard Icon" class="nav-icon" />
          </div>
          <div class="card-body">
            <div class="metric metric-teachers"><?php echo $total_teachers; ?></div>
            <p class="text-sm text-gray-600">Active teachers</p>
          </div>
        </div>
        
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Total Subjects</h3>
            <img src="https://img.icons8.com/?size=100&id=DEg1RKY5gqD7&format=png&color=3a728e" alt="Dashboard Icon" class="nav-icon" />
          </div>
          <div class="card-body">
            <div class="metric metric-subjects"><?php echo $total_subjects; ?></div>
            <p class="text-sm text-gray-600">Active subjects</p>
          </div>
        </div>
      </div>

      <!-- Top Performing Students -->
      <!--
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Top Performing Students</h3>
        </div>
        <div class="card-body">
          <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
          <th style="width: 80px;">Rank</th>
          <th>Student Name</th>
          <th>Course</th>
          <th style="width: 100px; text-align:right;">Score</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Fetch top 5 students by score (assuming you have a 'score' column)
            // Adjust the query as needed for your schema
            $sql = "SELECT full_name, e_mail, course 
            FROM user_info 
            WHERE user_type = 'S' 
            ORDER BY score DESC 
            LIMIT 5";
            $result = $conn->query($sql);
            $ranks = ['1st', '2nd', '3rd', '4th', '5th'];
            $rank_class = ['rank-1', 'rank-2', 'rank-3', '', ''];
            $i = 0;
            if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $rank = isset($ranks[$i]) ? $ranks[$i] : ($i+1) . 'th';
            $class = isset($rank_class[$i]) ? $rank_class[$i] : '';
            echo '<tr>';
            echo '<td><span class="rank-badge ' . $class . '">' . $rank . '</span></td>';
            echo '<td>
                <div class="student-info">
              <div class="student-name">' . htmlspecialchars($row['full_name']) . '</div>
              <div class="student-email">' . htmlspecialchars($row['email']) . '</div>
                </div>
              </td>';
            echo '<td>' . htmlspecialchars($row['course']) . '</td>';
            echo '<td class="text-right"><span class="score">' . htmlspecialchars($row['score']) . '%</span></td>';
            echo '</tr>';
            $i++;
          }
            } else {
          echo '<tr><td colspan="4" class="text-center">No student data available.</td></tr>';
            }
            ?>
          </tbody>
        </table>
          </div>
        </div>
      </div>
      -->
        <div class="card">
    <div class="card-header">
      <h3 class="card-title">Top Performing Students</h3>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th style="width: 80px;">Rank</th>
              <th>Student Name</th>
              <th>Course</th>
              <th style="width: 100px; text-align:right;">Score</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><span class="rank-badge rank-1">1st</span></td>
              <td>
                <div class="student-info">
                  <div class="student-name">Alice Johnson</div>
                  <div class="student-email">alice.johnson@email.com</div>
                </div>
              </td>
              <td>Mathematics</td>
              <td class="text-right"><span class="score">98%</span></td>
            </tr>
            <tr>
              <td><span class="rank-badge rank-2">2nd</span></td>
              <td>
                <div class="student-info">
                  <div class="student-name">Bob Smith</div>
                  <div class="student-email">bob.smith@email.com</div>
                </div>
              </td>
              <td>Physics</td>
              <td class="text-right"><span class="score">95%</span></td>
            </tr>
            <tr>
              <td><span class="rank-badge rank-3">3rd</span></td>
              <td>
                <div class="student-info">
                  <div class="student-name">Carol Lee</div>
                  <div class="student-email">carol.lee@email.com</div>
                </div>
              </td>
              <td>Chemistry</td>
              <td class="text-right"><span class="score">93%</span></td>
            </tr>
            <tr>
              <td><span class="rank-badge">4th</span></td>
              <td>
                <div class="student-info">
                  <div class="student-name">David Kim</div>
                  <div class="student-email">david.kim@email.com</div>
                </div>
              </td>
              <td>Biology</td>
              <td class="text-right"><span class="score">91%</span></td>
            </tr>
            <tr>
              <td><span class="rank-badge">5th</span></td>
              <td>
                <div class="student-info">
                  <div class="student-name">Eva Green</div>
                  <div class="student-email">eva.green@email.com</div>
                </div>
              </td>
              <td>English</td>
              <td class="text-right"><span class="score">89%</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
        </main>
      </div>

  <!-- JS -->
  <script src="../javascript/main.js">
  const sidebar = document.getElementById('sidebar');
  const sidebarToggle = document.getElementById('sidebarToggle');
  const sidebarOverlay = document.getElementById('sidebarOverlay');

  sidebarToggle.addEventListener('click', function() {
    sidebar.classList.toggle('open');
    sidebarOverlay.style.display = sidebar.classList.contains('open') ? 'block' : 'none';
  });

  sidebarOverlay.addEventListener('click', function() {
    sidebar.classList.remove('open');
    sidebarOverlay.style.display = 'none';
  });
</script>
</body>
</html>