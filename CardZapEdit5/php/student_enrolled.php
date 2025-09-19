<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CardZap • Enrolled Subjects</title>
    <link rel="stylesheet" href="../css/student_enrolled.css?v=<?php echo time(); ?>" />
    <link rel="stylesheet" href="../css/main.css?v=<?php echo time(); ?>" />
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
            <a href="student_profile.php" class="nav-link">
              <img src="https://img.icons8.com/?size=100&id=QlB1OMIqTVgl&format=png&color=f0fcfe" alt="Profile" class="nav-icon" />
              Profile
            </a>
          </li>
          <li class="nav-item">
            <a href="student_yourcards.php" class="nav-link">
              <img src="https://img.icons8.com/?size=100&id=04GSmQqf0WPl&format=png&color=f0fcfe" alt="YourCards" class="nav-icon" />
              Your Cards
            </a>
          </li>
          <li class="nav-item">
            <a href="student_friends.php" class="nav-link">
              <img src="https://img.icons8.com/?size=100&id=W0yStnm1ahyh&format=png&color=f0fcfe" alt="Friends" class="nav-icon" />
              Friends
            </a>
          </li>
          <li class="nav-item">
            <a href="student_enrolled.php" class="nav-link">
              <img src="https://img.icons8.com/?size=100&id=ssqfwv5zvoTR&format=png&color=f0fcfe" alt="Enrolled" class="nav-icon" />
              Enrolled Subjects
            </a>
          </li>
          <li class="nav-item">
            <a href="student_settings.php" class="nav-link">
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
      <div class="page-title">Enrolled Subjects</div>
      <div class="topbar-actions">
        <button class="btn btn-secondary mobile-menu-btn" id="sidebarToggle" aria-label="Open sidebar">☰</button>
      </div>
    </header>


      <!-- Main content -->
      <main class="content">
        <!-- Subjects Overview (default view) -->
        <div class="subjects-container" id="subjects-overview">
          <div class="subjects-grid">
            <!-- Enrolled Subject Card -->
            <div class="subject-card" data-subject-id="1" data-subject-name="Mathematics">
              <div class="subject-banner">
                <div class="subject-pattern"></div>
              </div>
              <div class="subject-body">
                <div class="subject-name">Mathematics</div>
                <div class="subject-students">Enrolled</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Subject Detail View (hidden by default) -->
        <div class="subject-detail" id="subject-detail" style="display: none;">
          <!-- Back button -->
          <button class="back-btn" onclick="showSubjectsOverview()">← Back to Enrolled Subjects</button>
          
          <!-- Subject Header -->
          <div class="subject-header">
            <h1 class="subject-title" id="detail-subject-title">Subject Name</h1>
            <div class="subject-code">Subject Code: BXMR20L79A</div>
          </div>

          <!-- Tabs -->
          <div class="tabs">
            <button class="tab active" data-tab="published">Published Cards</button>
            <button class="tab" data-tab="people">People</button>
          </div>

          <!-- Published Cards Panel -->
          <div class="panel" id="publishedPanel">
            <div class="deck-card" data-deck-id="1" data-deck-name="Algebra Basics" data-card-count="15" data-deck-type="Classic" data-subject="Mathematics">
              <div class="deck-stack">
                <div class="deck-card-top" style="background: #007bff">
                  Algebra Basics
                </div>
                <div class="deck-card-middle"></div>
                <div class="deck-card-bottom"></div>
              </div>
              <div class="deck-info">
                <div class="deck-title">Algebra Basics</div>
                <div class="deck-details">Mathematics • Classic • Created May 5</div>
              </div>
            </div>
            
            <div class="deck-card" data-deck-id="2" data-deck-name="Quadratic Equations" data-card-count="20" data-deck-type="Classic" data-subject="Mathematics">
              <div class="deck-stack">
                <div class="deck-card-top" style="background: #28a745">
                  Quadratic Equations
                </div>
                <div class="deck-card-middle"></div>
                <div class="deck-card-bottom"></div>
              </div>
              <div class="deck-info">
                <div class="deck-title">Quadratic Equations</div>
                <div class="deck-details">Mathematics • Classic • Created May 6</div>
              </div>
            </div>
            
            <div class="deck-card" data-deck-id="3" data-deck-name="Linear Functions" data-card-count="12" data-deck-type="Classic" data-subject="Mathematics">
              <div class="deck-stack">
                <div class="deck-card-top" style="background: #ffc107">
                  Linear Functions
                </div>
                <div class="deck-card-middle"></div>
                <div class="deck-card-bottom"></div>
              </div>
              <div class="deck-info">
                <div class="deck-title">Linear Functions</div>
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
              <h3>Classmates</h3>
              <div class="person-row">
                <div class="avatar"></div>
                <div class="person-name">Juan Jose Imperial <span class="person-sub">BSIT 3A</span></div>
                <div class="person-actions">
                  <button class="action-btn profile-btn">Profile</button>
                  <button class="action-btn message-btn">Message</button>
                </div>
              </div>
              <div class="person-row">
                <div class="avatar"></div>
                <div class="person-name">Maria Lopez <span class="person-sub">BSIT 3A</span></div>
                <div class="person-actions">
                  <button class="action-btn profile-btn">Profile</button>
                  <button class="action-btn message-btn">Message</button>
                </div>
              </div>
              <div class="person-row">
                <div class="avatar"></div>
                <div class="person-name">Josh Lim <span class="person-sub">BSIT 3A</span></div>
                <div class="person-actions">
                  <button class="action-btn profile-btn">Profile</button>
                  <button class="action-btn message-btn">Message</button>
                </div>
              </div>
              <div class="person-row">
                <div class="avatar"></div>
                <div class="person-name">Sarah Chen <span class="person-sub">BSIT 3A</span></div>
                <div class="person-actions">
                  <button class="action-btn profile-btn">Profile</button>
                  <button class="action-btn message-btn">Message</button>
                </div>
              </div>
              <div class="person-row">
                <div class="avatar"></div>
                <div class="person-name">Alex Rodriguez <span class="person-sub">BSIT 3A</span></div>
                <div class="person-actions">
                  <button class="action-btn profile-btn">Profile</button>
                  <button class="action-btn message-btn">Message</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>

    <script src="../javascript/student_enrolled.js"></script>
  </body>
</html>