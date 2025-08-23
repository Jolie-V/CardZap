<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>CardZap • Co-op Lobby</title>
  <link rel="stylesheet" href="../css/cooplobby.css" />
</head>
<body>
  <!-- Main Application Container -->
  <div class="app">
    <!-- Main Content Area -->
    <main class="content">
      <!-- Top Navigation Section -->
      <div class="header-section">
        <!-- Exit Lobby Button (Returns to Friends Page) -->
        <button class="exit-btn">
          <span class="exit-icon">→</span>
          Exit Lobby
        </button>
      </div>

      <!-- File Upload Section (Center) -->
      <div class="upload-section">
        <!-- Interactive File Upload Card -->
        <div class="file-upload-card">
          <div class="upload-icon">+</div>
          <div class="upload-text">Upload File</div>
        </div>
      </div>

      <!-- Player Management Section (Bottom) -->
      <div class="player-slots">
        <!-- Current Player Slot (Always Present) -->
        <div class="player-slot you">
          <div class="player-avatar">😊</div>
          <div class="player-name">You</div>
        </div>
        
        <!-- Empty Player Slots (Available for Invites) -->
        <div class="player-slot empty">
          <div class="add-icon">+</div>
        </div>
        <div class="player-slot empty">
          <div class="add-icon">+</div>
        </div>
        <div class="player-slot empty">
          <div class="add-icon">+</div>
        </div>
      </div>
    </main>
  </div>

  <!-- JavaScript for Lobby Interactions -->
  <script src="../javascript/cooplobby.js"></script>
</body>
</html>
