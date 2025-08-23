<?php
session_start();
require_once 'db.php';
require_user_type(['A']);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Dashboard • CardZap</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../css/main.css" />
    <link rel="stylesheet" href="../css/admin_homepage.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  </head>
  
  <body>
    <!-- ===== MAIN APPLICATION CONTAINER ===== -->
    <div class="app">
      
      <!-- ===== LEFT SIDEBAR ===== -->
      <aside class="sidebar">
        <div class="sidebar-header">
          <a href="admin_homepage.php" class="logo">
            <div class="logo-icon">📚</div>
            <span>CardZap</span>
          </a>
        </div>
        
        <!-- Navigation menu -->
        <nav>
          <ul class="nav-list">
            <li class="nav-item">
              <a href="admin_homepage.php" class="nav-link active">
                <span class="nav-icon">📊</span>
                Dashboard
              </a>
            </li>
            <li class="nav-item">
              <a href="admin_students.php" class="nav-link">
                <span class="nav-icon">👥</span>
                Students
              </a>
            </li>
            <li class="nav-item">
              <a href="admin_teachers.php" class="nav-link">
                <span class="nav-icon">👨‍🏫</span>
                Teachers
              </a>
            </li>
            <li class="nav-item">
              <a href="admin_subjects.php" class="nav-link">
                <span class="nav-icon">📚</span>
                Subjects
              </a>
            </li>
          </ul>
        </nav>
        
        <!-- Logout button -->
        <div class="sidebar-footer">
          <button class="btn btn-danger" style="width: 100%;">Log out</button>
        </div>
      </aside>

      <!-- ===== TOP HEADER BAR ===== -->
      <header class="topbar">
        <div class="page-title">Admin Dashboard</div>
        <div class="topbar-actions">
          <button class="btn btn-secondary mobile-menu-btn" style="display: none;">☰</button>
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
              <span class="nav-icon">👥</span>
            </div>
            <div class="card-body">
              <div class="metric metric-students">0</div>
              <p class="text-sm text-gray-600">Active students</p>
            </div>
          </div>
          
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Total Teachers</h3>
              <span class="nav-icon">👨‍🏫</span>
            </div>
            <div class="card-body">
              <div class="metric metric-teachers">0</div>
              <p class="text-sm text-gray-600">Active teachers</p>
            </div>
          </div>
          
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Total Subjects</h3>
              <span class="nav-icon">📚</span>
            </div>
            <div class="card-body">
              <div class="metric metric-subjects">0</div>
              <p class="text-sm text-gray-600">Active subjects</p>
            </div>
          </div>
        </div>

        <!-- Top Performing Students -->
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
                        <div class="student-name">Juan Jose Imperial</div>
                        <div class="student-email">juan.imperial@email.com</div>
                      </div>
                    </td>
                    <td>BSIT 3A</td>
                    <td class="text-right"><span class="score">98%</span></td>
                  </tr>
                  <tr>
                    <td><span class="rank-badge rank-2">2nd</span></td>
                    <td>
                      <div class="student-info">
                        <div class="student-name">Maria Mae Panganiban</div>
                        <div class="student-email">maria.panganiban@email.com</div>
                      </div>
                    </td>
                    <td>BSN 2C</td>
                    <td class="text-right"><span class="score">97%</span></td>
                  </tr>
                  <tr>
                    <td><span class="rank-badge rank-3">3rd</span></td>
                    <td>
                      <div class="student-info">
                        <div class="student-name">Miguel Gonzales</div>
                        <div class="student-email">miguel.gonzales@email.com</div>
                      </div>
                    </td>
                    <td>BSED 4B</td>
                    <td class="text-right"><span class="score">92%</span></td>
                  </tr>
                  <tr>
                    <td><span class="rank-badge">4th</span></td>
                    <td>
                      <div class="student-info">
                        <div class="student-name">Sherry Joy Rosales</div>
                        <div class="student-email">sherry.rosales@email.com</div>
                      </div>
                    </td>
                    <td>BS Entrep 1D</td>
                    <td class="text-right"><span class="score">90%</span></td>
                  </tr>
                  <tr>
                    <td><span class="rank-badge">5th</span></td>
                    <td>
                      <div class="student-info">
                        <div class="student-name">Cassandra Salinel</div>
                        <div class="student-email">cassandra.salinel@email.com</div>
                      </div>
                    </td>
                    <td>BSCPE 2B</td>
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
    <script src="../javascript/main.js"></script>
  </body>
</html>