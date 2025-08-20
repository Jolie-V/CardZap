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
            <li><a class="nav-item" href="admin_students.php">Students</a></li>
            <li><a class="nav-item" href="admin_teachers.php">Teachers</a></li>
            <li><a class="nav-item" href="admin_subjects.php">Subjects</a></li>
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
            <div class="metric">30</div>
          </div>
          <div class="card">
            <h3>Teachers</h3>
            <div class="metric">12</div>
          </div>
          <div class="card">
            <h3>Subjects</h3>
            <div class="metric">1</div>
          </div>
        </div>

        <div class="two-col">
          <div class="card">
            <h3>Top Performing</h3>
            <table class="table">
              <thead>
                <tr>
                  <th style="width: 80px;">Top</th>
                  <th>Name</th>
                  <th style="width: 90px; text-align:right;">Score</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><span class="rank-badge">1st</span></td>
                  <td>
                    Juan Jose Imperial
                    <div class="subtext">BSIT 3A</div>
                  </td>
                  <td class="text-right">98%</td>
                </tr>
                <tr>
                  <td><span class="rank-badge">2nd</span></td>
                  <td>
                    Maria Mae Panganiban
                    <div class="subtext">BSN 2C</div>
                  </td>
                  <td class="text-right">97%</td>
                </tr>
                <tr>
                  <td><span class="rank-badge">3rd</span></td>
                  <td>
                    Miguel Gonzales
                    <div class="subtext">BSED 4B</div>
                  </td>
                  <td class="text-right">92%</td>
                </tr>
                <tr>
                  <td><span class="rank-badge">4th</span></td>
                  <td>
                    Sherry Joy Rosales
                    <div class="subtext">BS Entrep 1D</div>
                  </td>
                  <td class="text-right">90%</td>
                </tr>
                <tr>
                  <td><span class="rank-badge">5th</span></td>
                  <td>
                    Cassandra Salinel
                    <div class="subtext">BSCPE 2B</div>
                  </td>
                  <td class="text-right">89%</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </main>
    </div>

    <!-- JS -->
    <script src="../javascript/admin_homepage.js?v=2"></script>
  </body>
</html>