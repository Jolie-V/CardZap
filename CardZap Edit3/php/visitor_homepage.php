<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CardZap</title>
    <link rel="stylesheet" href="../css/visitor_homepage.css">
    <link rel="stylesheet" href="../css/main.css">
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
            <a href="visitor_homepage.php" class="nav-link">
              <img src="https://img.icons8.com/?size=100&id=04GSmQqf0WPl&format=png&color=f0fcfe" alt="cards" class="nav-icon" />
              Cards Creation
            </a>
          </li>
        </ul>
      </nav>
    </aside>

    <!-- Sidebar overlay for mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- ===== TOP HEADER BAR ===== -->
    <header class="topbar">
      <div class="page-title">Welcome, Visitor!</div>
      <div class="topbar-actions">
        <a class="login-btn" href="loginpage.php">Log in</a>
      </div>
    </header>


      <!-- ===== MAIN CONTENT ===== -->
      <main class="content">
        <div id="decksContainer">
          <button class="add-card" id="addCardBtn">+</button>
        </div>
      </main>
    </div>

    <!-- ===== MODAL ===== -->
    <div id="cardModal" class="modal hidden">
      <div class="modal-content">
        <!-- Step 1: Basic Deck Information -->
        <div id="step1">
          <h2>Add New Deck</h2>
          
          <!-- Subject Name Input -->
          <div class="field">
            <label for="subjectName">Subject Name</label>
            <input type="text" id="subjectName" placeholder="Enter subject name">
          </div>
          
          <!-- Reading Material Selection -->
          <div class="field">
            <label>Reading Material</label>
            <div class="checkbox-group">
              <!-- Text Input Option -->
              <div class="checkbox-item">
                <input type="checkbox" id="textCheckbox" name="readingMaterial" value="text">
                <div>
                  <label class="checkbox-label" for="textCheckbox">Text</label>
                  <div class="checkbox-sublabel">Maximum of 10,000 characters</div>
                </div>
              </div>
              <!-- File Upload Option -->
              <div class="checkbox-item">
                <input type="checkbox" id="fileCheckbox" name="readingMaterial" value="file">
                <div>
                  <label class="checkbox-label" for="fileCheckbox">File Upload</label>
                  <div class="checkbox-sublabel">Maximum of 25MB</div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Number of Cards Input -->
          <div class="field">
            <label for="cardCount">Number of Cards</label>
            <input type="number" id="cardCount" min="1" placeholder="Enter number of cards">
          </div>
          
          <!-- Card Color Selection -->
          <div class="field">
            <label for="cardColor">Card Color</label>
            <select id="cardColor">
              <option value="blue">Blue</option>
              <option value="green">Green</option>
              <option value="red">Red</option>
              <option value="yellow">Yellow</option>
              <option value="purple">Purple</option>
            </select>
          </div>
          
          <!-- Action Buttons -->
          <div class="actions">
            <button class="btn" id="nextBtn" disabled>Next</button>
            <button type="button" class="btn secondary" id="closeModal">Cancel</button>
          </div>
        </div>

        <!-- Step 2: Text Input -->
        <div id="step2" style="display: none;">
          <h2>Paste Text</h2>
          <div class="field">
            <textarea class="text-input-area" id="textInput" placeholder="Value"></textarea>
          </div>
          <div class="actions">
            <button class="btn" id="nextTextBtn">Next</button>
            <button type="button" class="btn secondary" id="backToStep1">Back</button>
          </div>
        </div>

        <!-- Step 3: File Upload -->
        <div id="step3" style="display: none;">
          <h2>Upload your file!</h2>
          <div class="file-upload-area">
            <div class="file-input-container">
              <input type="text" class="file-input" id="fileDisplay" placeholder="Choose File" readonly>
              <button class="browse-btn" id="browseBtn">Browse...</button>
            </div>
            <input type="file" id="fileInput" style="display: none;" accept=".txt,.pdf,.doc,.docx">
          </div>
          <div class="actions">
            <button class="btn" id="nextFileBtn">Next</button>
            <button type="button" class="btn secondary" id="backToStep1File">Back</button>
          </div>
        </div>

        <!-- Step 4: Questioning Type Selection -->
        <div id="step4" style="display: none;">
          <h2>Choose Questioning Type</h2>
          <div class="checkbox-group">
            <div class="checkbox-item">
              <input type="checkbox" id="classicCheckbox" name="questioningType" value="classic">
              <label class="checkbox-label" for="classicCheckbox">Classic</label>
            </div>
            <div class="checkbox-item">
              <input type="checkbox" id="quizCheckbox" name="questioningType" value="quiz">
              <label class="checkbox-label" for="quizCheckbox">Quiz</label>
            </div>
          </div>
          <div class="actions">
            <button class="btn" id="createDeckBtn" disabled>Create</button>
            <button type="button" class="btn secondary" id="backToStep1Final">Back</button>
          </div>
        </div>
      </div>
    </div>

    <!-- JS -->
    <script src="../javascript/visitor_homepage.js"></script>
  </body>
</html>