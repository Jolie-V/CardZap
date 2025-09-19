<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CardZap • Quiz Cards</title>
    <link rel="stylesheet" href="../css/student_quizcards.css?v=<?php echo time(); ?>">
  </head>
  <body>
    <div class="quiz-cards-container">
      <div class="header">
        <div class="page-title" id="pageTitle">Quiz Cards</div>
        <div class="timer-container">
          <div class="timer" id="timer">5:00</div>
          <button class="menu-btn" id="menuBtn">☰</button>
        </div>
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
      <div class="quiz-card-container">
        <div class="quiz-card" id="quizCard">
          <div class="quiz-question" id="quizQuestion">Question</div>
        </div>
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
      <div class="progress-bar">
        <span id="currentCard">1</span> of <span id="totalCards">4</span>
      </div>
    </div>
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
        <div class="score-actions">
          <button class="menu-btn-option" id="tryAgainBtn">Try Again</button>
          <button class="menu-btn-option" id="returnHome">Return Home</button>
        </div>
      </div>
    </div>
    
    <script>
      (function ensureTypeParam(){
        var url = new URL(window.location.href);
        if (!url.searchParams.get('type')) { url.searchParams.set('type', 'student'); window.history.replaceState({}, '', url.toString()); }
      })();
    </script>
    <script src="../javascript/student_quizcards.js?v=<?php echo time(); ?>"></script>
  </body>
</html>