<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CardZap • Edit Classic Cards</title>
    <link rel="stylesheet" href="../css/editclassic.css?v=1" />
  </head>
  <body>
    <div class="app">
      <!-- Sidebar -->
      <aside class="sidebar">
        <div><strong>CardZap</strong></div>
        <nav>
          <ul class="nav-list">
            <li><a class="nav-item" href="teacher_profile.php">Profile</a></li>
            <li><a class="nav-item" href="student_friends.php">Friends</a></li>
            <li><a class="nav-item" href="teacher_yourcards.php">Your Cards</a></li>
            <li><a class="nav-item" href="teacher_subjects.php">Subjects</a></li>
            <li><a class="nav-item" href="teacher_settings.php">Settings</a></li>
          </ul>
        </nav>
        <button class="logout-btn">Log out</button>
      </aside>

      <!-- Topbar -->
      <header class="topbar">
        <div class="page-title">Edit Classic Cards</div>
        <button id="saveBtn" class="btn btn-save">Save</button>
      </header>

      <!-- Main content -->
      <main class="content">
        <div id="cardsContainer" class="cards-container"></div>
      </main>
    </div>

    <!-- Save Deck Modal -->
    <div id="saveDeckModal" class="save-deck-modal hidden">
      <div class="save-deck-content">
        <h2>Save Deck</h2>
        <div class="field">
          <label for="subjectSelect">Add to Subject:</label>
          <select id="subjectSelect" class="subject-dropdown">
            <option value="">Choose Subject</option>
            <option value="Mathematics">Mathematics</option>
            <option value="Science">Science</option>
            <option value="History">History</option>
            <option value="Literature">Literature</option>
            <option value="new">Create New Subject</option>
          </select>
        </div>
        <div class="actions">
          <button class="btn btn-primary" id="saveDeckBtn">Next</button>
        </div>
      </div>
    </div>

    <script src="../javascript/editclassic.js?v=1"></script>
  </body>
  </html>


