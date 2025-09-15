<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>CardZap • Subjects</title>
  <link rel="stylesheet" href="../css/teacher_subjects.css" />
  <link rel="stylesheet" href="../css/main.css" />
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
            <a href="teacher_profile.php" class="nav-link">
              <img src="https://img.icons8.com/?size=100&id=QlB1OMIqTVgl&format=png&color=f0fcfe" alt="Profile" class="nav-icon" />
              Profile
            </a>
          </li>
          <li class="nav-item">
            <a href="teacher_yourcards.php" class="nav-link">
              <img src="https://img.icons8.com/?size=100&id=04GSmQqf0WPl&format=png&color=f0fcfe" alt="YourCards" class="nav-icon" />
              Your Cards
            </a>
          </li>
          <li class="nav-item">
            <a href="teacher_subjects.php" class="nav-link">
              <img src="https://img.icons8.com/?size=100&id=ssqfwv5zvoTR&format=png&color=f0fcfe" alt="Subjcts" class="nav-icon" />
              Created Subjects
            </a>
          </li>
          <li class="nav-item">
            <a href="teacher_settings.php" class="nav-link">
              <img src="https://img.icons8.com/?size=100&id=yku81UQEXoew&format=png&color=f0fcfe" alt="Settings" class="nav-icon" />
              Settings
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
      <div class="page-title">Created Subjects</div>
      <div class="topbar-actions">
        <button class="btn btn-secondary mobile-menu-btn" id="sidebarToggle" aria-label="Open sidebar">☰</button>
      </div>
    </header>

      <!-- Main content -->
      <main class="content">
      <!-- Subjects Overview (default view) -->
      <div class="subjects-container" id="subjects-overview">
        <div class="subjects-grid">
          <!-- Existing Subject Card -->
          <div class="subject-card" data-subject-id="1" data-subject-name="Mathematics">
            <div class="subject-banner">
              <div class="subject-pattern"></div>
            </div>
            <div class="subject-body">
              <div class="subject-name">Mathematics</div>
              <div class="subject-students">0 students</div>
            </div>
          </div>
          
          <!-- Add Subject Card -->
          <div class="subject-card add-subject">
            <div class="subject-banner add-banner">
              <div class="add-icon">+</div>
            </div>
            <div class="subject-body">
              <div class="subject-name">Add Subject</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Subject Detail View (hidden by default) -->
      <div class="subject-detail" id="subject-detail" style="display: none;">
        <!-- Back button -->
        <button class="back-btn" onclick="showSubjectsOverview()">← Back to Subjects</button>
        
        <!-- Subject Header -->
        <div class="subject-header">
          <h1 class="subject-title" id="detail-subject-title">Subject Name</h1>
          <div class="subject-code">Subject Code: BXMR20L79A</div>
        </div>

        <!-- Tabs -->
        <div class="tabs">
          <button class="tab active" data-tab="published">Published Cards</button>
          <button class="tab" data-tab="people">People</button>
          <button class="tab" data-tab="progress">Progress</button>
        </div>

        <!-- Published Cards Panel -->
        <div class="panel" id="publishedPanel">
          <div class="deck-card" data-deck-id="1" data-deck-name="Mathematics Basics" data-card-count="15" data-deck-type="Classic" data-subject="Mathematics">
            <div class="deck-stack">
              <div class="deck-card-top" style="background: #007bff">
                Mathematics Basics
              </div>
              <div class="deck-card-middle"></div>
              <div class="deck-card-bottom"></div>
            </div>
            <div class="deck-info">
              <div class="deck-title">Mathematics Basics</div>
              <div class="deck-details">Mathematics • Classic • Created May 5</div>
            </div>
          </div>
          
          <div class="deck-card" data-deck-id="2" data-deck-name="Advanced Algebra" data-card-count="20" data-deck-type="Classic" data-subject="Mathematics">
            <div class="deck-stack">
              <div class="deck-card-top" style="background: #28a745">
                Advanced Algebra
              </div>
              <div class="deck-card-middle"></div>
              <div class="deck-card-bottom"></div>
            </div>
            <div class="deck-info">
              <div class="deck-title">Advanced Algebra</div>
              <div class="deck-details">Mathematics • Classic • Created May 6</div>
            </div>
          </div>
          
          <div class="deck-card" data-deck-id="3" data-deck-name="Geometry Fundamentals" data-card-count="12" data-deck-type="Classic" data-subject="Mathematics">
            <div class="deck-stack">
              <div class="deck-card-top" style="background: #ffc107">
                Geometry Fundamentals
              </div>
              <div class="deck-card-middle"></div>
              <div class="deck-card-bottom"></div>
            </div>
            <div class="deck-info">
              <div class="deck-title">Geometry Fundamentals</div>
              <div class="deck-details">Mathematics • Classic • Created May 7</div>
            </div>
          </div>
          
          <div class="deck-card" data-deck-id="4" data-deck-name="Calculus Quiz" data-card-count="18" data-deck-type="Quiz" data-subject="Mathematics">
            <div class="deck-stack">
              <div class="deck-card-top" style="background: #e91e63">
                Calculus Quiz
              </div>
              <div class="deck-card-middle"></div>
              <div class="deck-card-bottom"></div>
            </div>
            <div class="deck-info">
              <div class="deck-title">Calculus Quiz</div>
              <div class="deck-details">Mathematics • Quiz • Created May 8</div>
            </div>
          </div>
          
          <div class="deck-card" data-deck-id="5" data-deck-name="Statistics Test" data-card-count="25" data-deck-type="Quiz" data-subject="Mathematics">
            <div class="deck-stack">
              <div class="deck-card-top" style="background: #9c27b0">
                Statistics Test
              </div>
              <div class="deck-card-middle"></div>
              <div class="deck-card-bottom"></div>
            </div>
            <div class="deck-info">
              <div class="deck-title">Statistics Test</div>
              <div class="deck-details">Mathematics • Quiz • Created May 9</div>
            </div>
          </div>
        </div>

        <!-- People Panel -->
        <div class="panel hidden" id="peoplePanel">
          <div class="enrollment-section">
            <h3>Enrollment Requests</h3>
            <div class="person-row">
              <div class="avatar"></div>
              <div class="person-name">Juan Jose Imperial <span class="person-sub">BSIT 3A</span></div>
              <div class="person-actions">
                <button class="action-btn accept-btn">Accept</button>
                <button class="action-btn remove-btn">Remove</button>
              </div>
            </div>
          </div>
          
          <div class="enrollment-section">
            <h3>Enrolled Students</h3>
            <div class="person-row">
              <div class="avatar"></div>
              <div class="person-name">Maria Lopez <span class="person-sub">BSIT 3A</span></div>
              <div class="person-actions">
                <button class="action-btn profile-btn">Profile</button>
                <button class="action-btn remove-btn">Remove</button>
              </div>
            </div>
            <div class="person-row">
              <div class="avatar"></div>
              <div class="person-name">Josh Lim <span class="person-sub">BSIT 3A</span></div>
              <div class="person-actions">
                <button class="action-btn profile-btn">Profile</button>
                <button class="action-btn remove-btn">Remove</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Progress Panel -->
        <div class="panel hidden" id="progressPanel">
          <div class="progress-section">
            <h3>Class Performance</h3>
            <div class="progress-graph">
              <div class="graph-container">
                <div class="graph-y-axis">
                  <div class="y-label">Scores</div>
                  <div class="y-markers">
                    <span>100%</span>
                    <span>75%</span>
                    <span>50%</span>
                    <span>25%</span>
                    <span>0%</span>
                  </div>
                </div>
                <div class="graph-content">
                  <div class="graph-line" data-score="0" data-date="May 5">Card 1</div>
                  <div class="graph-line" data-score="0" data-date="May 6">Card 1</div>
                  <div class="graph-line" data-score="0" data-date="May 7">Card 1</div>
                </div>
                <div class="graph-x-axis">
                  <span>May 5</span>
                  <span>May 6</span>
                  <span>May 7</span>
                </div>
              </div>
            </div>
          </div>
          
          <div class="progress-section">
            <h3>Top Performing</h3>
            <div class="leaderboard">
              <div class="leaderboard-item">
                <div class="medal gold">🥇</div>
                <div class="rank">1st</div>
                <div class="student-info">
                  <div class="student-name">Juan Jose Imperial</div>
                  <div class="student-section">BSIT 3A</div>
                </div>
                <div class="score">98%</div>
              </div>
              <div class="leaderboard-item">
                <div class="medal silver">🥈</div>
                <div class="rank">2nd</div>
                <div class="student-info">
                  <div class="student-name">Maria Lopez</div>
                  <div class="student-section">BSIT 3A</div>
                </div>
                <div class="score">97%</div>
              </div>
              <div class="leaderboard-item">
                <div class="medal bronze">🥉</div>
                <div class="rank">3rd</div>
                <div class="student-info">
                  <div class="student-name">Josh Lim</div>
                  <div class="student-section">BSIT 3A</div>
                </div>
                <div class="score">92%</div>
              </div>
            </div>
          </div>
        </div>
        </div>
      </main>
    </div>

    <script src="../javascript/teacher_subjects.js"></script>
  </body>
  </html>

