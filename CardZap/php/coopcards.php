<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>CardZap • Co-op Cards</title>
  <link rel="stylesheet" href="../css/coopcards.css" />
</head>
<body>
  <!-- Main Application Container -->
  <div class="app">
    <!-- Top Navigation Bar with Game Controls -->
    <div class="top-section">
      <!-- Page Title -->
      <div class="page-title">Co-op cards</div>
      
      <!-- Timer Display (Centered) -->
      <div class="timer-container">
        <div class="timer">5:00</div>
      </div>
      
      <!-- Surrender Button (Right Side) -->
      <div class="surrender-btn">
        <span class="surrender-icon">→</span>
        Surrender
      </div>
    </div>

    <!-- Main Game Content Area -->
    <div class="main-content">
      <!-- Player Information Sidebar (Left Side) -->
      <div class="player-info">
        <!-- Opponent Player Card (Top) -->
        <div class="player-card wendy">
          <div class="player-avatar">😊</div>
          <div class="player-details">
            <div class="player-name">Wendy</div>
            <!-- Score Indicators: Correct and Incorrect Answers -->
            <div class="player-scores">
              <div class="score-item correct">
                <span class="score-icon">✓</span>
                <span class="score-number">0</span>
              </div>
              <div class="score-item incorrect">
                <span class="score-icon">✕</span>
                <span class="score-number">0</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Current Player Card (Bottom) -->
        <div class="player-card you">
          <div class="player-avatar">😊</div>
          <div class="player-details">
            <div class="player-name">You</div>
            <!-- Score Indicators: Correct and Incorrect Answers -->
            <div class="player-scores">
              <div class="score-item correct">
                <span class="score-icon">✓</span>
                <span class="score-number">0</span>
              </div>
              <div class="score-item incorrect">
                <span class="score-icon">✕</span>
                <span class="score-number">0</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Quiz Game Area (Center) -->
      <div class="question-area">
        <!-- Question Display Card -->
        <div class="question-card">
          <div class="question-text">Question</div>
        </div>
        
        <!-- Progress Indicator -->
        <div class="card-progress">
          <span id="currentCard">4</span> of <span id="totalCards">4</span>
        </div>

        <!-- Multiple Choice Answer Options (2x2 Grid) -->
        <div class="answer-options">
          <button class="option-btn" id="optionA" data-option="A">
            <span class="option-letter">A.</span>
            <span class="option-text">Answer</span>
          </button>
          <button class="option-btn" id="optionB" data-option="B">
            <span class="option-letter">B.</span>
            <span class="option-text">Answer</span>
          </button>
          <button class="option-btn" id="optionC" data-option="C">
            <span class="option-letter">C.</span>
            <span class="option-text">Answer</span>
          </button>
          <button class="option-btn" id="optionD" data-option="D">
            <span class="option-letter">D.</span>
            <span class="option-text">Answer</span>
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- JavaScript for Game Logic and Interactions -->
  <script src="../javascript/coopcards.js"></script>
</body>
</html>
