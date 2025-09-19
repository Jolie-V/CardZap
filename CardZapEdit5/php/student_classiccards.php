<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CardZap • Classic Cards</title>
    <link rel="stylesheet" href="../css/student_classiccards.css?v=<?php echo time(); ?>">
  </head>
  
  <body>
    <!-- Main container -->
    <div class="classic-cards-container">
      
      <!-- Header section -->
      <div class="header">
        <div class="page-title" id="pageTitle">Classic Cards</div>
        
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
      
      <!-- Card display stage with 3D flip animation -->
      <div class="cc-stage">
        <!-- Main card container with flip functionality -->
        <div class="cc-card" id="cc-card" aria-live="polite" aria-atomic="true">
          <!-- Inner card container for 3D transform -->
          <div class="cc-card-inner" id="cc-card-inner">
            <!-- Front face showing the question -->
            <div class="cc-face cc-face-front" id="cc-front"></div>
            <!-- Back face showing the answer (flipped) -->
            <div class="cc-face cc-face-back" id="cc-back"></div>
          </div>
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
        <div class="score-actions">
          <button class="menu-btn-option" id="tryAgainBtn">Try Again</button>
          <button class="menu-btn-option" id="returnHome">Return Home</button>
        </div>
      </div>
    </div>
    
    <script>
      // Ensure type=student is present to guide navigation in the shared script
      (function ensureTypeParam(){
        var url = new URL(window.location.href);
        if (!url.searchParams.get('type')) { url.searchParams.set('type', 'student'); window.history.replaceState({}, '', url.toString()); }
      })();
    </script>
    <script src="../javascript/student_classiccards.js?v=<?php echo time(); ?>"></script>
  </body>
</html>