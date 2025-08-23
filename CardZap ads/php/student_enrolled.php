<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CardZap • Enrolled Subjects</title>
    <link rel="stylesheet" href="../css/student_enrolled.css?v=<?php echo time(); ?>" />
  </head>
  <body>
    <div class="app">
      <!-- Sidebar -->
      <aside class="sidebar">
        <div>
          <strong>CardZap</strong>
        </div>
        <nav>
          <ul class="nav-list">
            <li><a class="nav-item" href="student_profile.php">Profile</a></li>
            <li><a class="nav-item" href="student_friends.php">Friends</a></li>
            <li><a class="nav-item" href="student_yourcards.php">Your Cards</a></li>
            <li><a class="nav-item active" href="student_enrolled.php">Enrolled Subjects</a></li>
            <li><a class="nav-item" href="student_settings.php">Settings</a></li>
          </ul>
        </nav>
        <button class="logout-btn">Log out</button>
      </aside>

             <!-- Header -->
       <header class="topbar">
         <div class="page-title">Enrolled Subjects</div>
         <div class="topbar-right">
           <div class="search-container">
             <input type="text" class="search-input" placeholder="Search enrolled subjects..." id="subjectSearch">
           </div>
           <button class="icon-btn bell-btn" title="Notifications">🔔</button>
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