<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CardZap • Quiz Cards</title>
    <link rel="stylesheet" href="../css/quizcards.css?v=2">
  </head>
  
  <body>
    <!-- Main Quiz Application Container -->
    <div class="quiz-cards-container">
      
      <!-- Top Navigation Header -->
      <div class="header">
        <!-- Dynamic Page Title (Updated based on deck content) -->
        <div class="page-title" id="pageTitle">Quiz Cards</div>
        
        <!-- Timer and Menu Controls -->
        <div class="timer-container">
          <div class="timer" id="timer">5:00</div>
          <button class="menu-btn" id="menuBtn">☰</button>
        </div>
        
        <!-- Score Display Indicators -->
        <div class="score-indicators">
          <div class="score-item">
            <div class="score-icon incorrect-icon">✕</div>
            <span id="incorrectCount">0</span>
          </div>
          <div class="score-item">
            <div class="score-icon correct-icon">✓</div>
            <span id="correctCount">0</span>
          </div>
        </div>
      </div>
      
      <!-- Main Quiz Content Area -->
      <div class="quiz-card-container">
        <!-- Question Display Card -->
        <div class="quiz-card" id="quizCard">
          <div class="quiz-question" id="quizQuestion">Question</div>
        </div>
        
        <!-- Multiple Choice Answer Options (Right Side) -->
        <div class="options-container">
          <button class="option-btn" id="optionA" data-option="A">
            <span class="option-letter">A.</span>
            <span class="option-text" id="optionAText">Answer</span>
          </button>
          <button class="option-btn" id="optionB" data-option="B">
            <span class="option-letter">B.</span>
            <span class="option-text" id="optionBText">Answer</span>
          </button>
          <button class="option-btn" id="optionC" data-option="C">
            <span class="option-letter">C.</span>
            <span class="option-text" id="optionCText">Answer</span>
          </button>
          <button class="option-btn" id="optionD" data-option="D">
            <span class="option-letter">D.</span>
            <span class="option-text" id="optionDText">Answer</span>
          </button>
        </div>
      </div>
      
      <!-- Progress Indicator (Bottom) -->
      <div class="progress-bar">
        <span id="currentCard">1</span> of <span id="totalCards">4</span>
      </div>
    </div>
    
    <!-- Menu Modal (Hidden by default) -->
    <div class="menu-modal" id="menuModal">
      <div class="menu-content">
        <div class="menu-title">Menu</div>
        <div class="menu-buttons">
          <button class="menu-btn-option" id="saveBtn">Save</button>
          <button class="menu-btn-option" id="saveExitBtn">Save and Exit</button>
          <button class="menu-btn-option" id="exitBtn">Exit without Saving</button>
        </div>
      </div>
    </div>
    
    <!-- Final Score Modal (Hidden by default) -->
    <div class="score-modal" id="scoreModal">
      <div class="score-content">
        <div class="score-header">
          <div class="small-text">YOUR</div>
          <div class="large-text">SCORE</div>
        </div>
        <div class="score-details">
          <div class="score-item-modal">
            <div class="score-icon-modal incorrect-icon">✕</div>
            <div class="score-number incorrect-number" id="finalIncorrect">1</div>
          </div>
          <div class="score-item-modal">
            <div class="score-icon-modal correct-icon">✓</div>
            <div class="score-number correct-number" id="finalCorrect">3</div>
          </div>
        </div>
        <div class="return-home" id="returnHome">Click to return home</div>
      </div>
    </div>
    
    <!-- JavaScript for Quiz Logic and Interactions -->
    <script src="../javascript/quizcards.js?v=2"></script>
  </body>
</html>
