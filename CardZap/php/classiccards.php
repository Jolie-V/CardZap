<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CardZap • Classic Cards</title>
    <link rel="stylesheet" href="classiccardspage.css">
  </head>
  
  <body>
    <!-- Main container -->
    <div class="classic-cards-container">
      
      <!-- Header section -->
      <div class="header">
        <div class="page-title">Classic Cards 1</div>
        
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
      
      <!-- Flashcard container -->
      <div class="flashcard-container">
        <div class="answer-area-left" id="answerLeft"></div>
        <div class="answer-area-right" id="answerRight"></div>
        
        <div class="flashcard" id="flashcard">
          <div class="flashcard-face" id="cardFront">Question</div>
          <div class="flashcard-face flashcard-back" id="cardBack">Answer</div>
        </div>
      </div>
      
      <!-- Progress indicator -->
      <div class="progress-bar">
        <span id="currentCard">1</span> of <span id="totalCards">4</span>
      </div>
    </div>
    
    <!-- Menu modal -->
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
    
    <!-- Score modal -->
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
    
    <script src="classiccardspage.js"></script>
  </body>
</html>