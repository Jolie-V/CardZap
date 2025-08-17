/* ===== CO-OP CARDS GAME LOGIC ===== */
/* This file handles the collaborative quiz game functionality including:
   - Timer management
   - Question progression
   - Score tracking for multiple players
   - Answer validation and feedback
   - Game state management */

// ===== GLOBAL VARIABLES =====
let currentCardIndex = 0;        // Current question being displayed
let timer = 300;                 // Game timer in seconds (5 minutes)
let timerInterval;               // Timer interval reference
let quizCards = [];              // Array to store quiz questions and answers
let playerScores = {
  you: { correct: 0, incorrect: 0 },    // Current player's score
  wendy: { correct: 0, incorrect: 0 }   // Opponent's score
};

// ===== SAMPLE QUIZ DATA =====
// In a real application, this would be loaded from the uploaded file
const sampleQuizData = [
  {
    question: "What is the capital of France?",
    options: ["London", "Paris", "Berlin", "Madrid"],
    correctAnswer: 1  // Index of correct answer (0-based)
  },
  {
    question: "Which planet is known as the Red Planet?",
    options: ["Venus", "Mars", "Jupiter", "Saturn"],
    correctAnswer: 1
  },
  {
    question: "What is 2 + 2?",
    options: ["3", "4", "5", "6"],
    correctAnswer: 1
  },
  {
    question: "Who painted the Mona Lisa?",
    options: ["Van Gogh", "Da Vinci", "Picasso", "Rembrandt"],
    correctAnswer: 1
  }
];

// ===== DOM ELEMENT REFERENCES =====
const timerElement = document.querySelector('.timer');
const surrenderBtn = document.querySelector('.surrender-btn');
const questionText = document.querySelector('.question-text');
const currentCardElement = document.getElementById('currentCard');
const totalCardsElement = document.getElementById('totalCards');
const optionButtons = document.querySelectorAll('.option-btn');

// Score display elements for both players
const playerScoreElements = {
  you: {
    correct: document.querySelector('.player-card.you .score-item.correct .score-number'),
    incorrect: document.querySelector('.player-card.you .score-item.incorrect .score-number')
  },
  wendy: {
    correct: document.querySelector('.player-card.wendy .score-item.correct .score-number'),
    incorrect: document.querySelector('.player-card.wendy .score-item.incorrect .score-number')
  }
};

// ===== INITIALIZATION =====
/**
 * Initialize the game when the page loads
 * Sets up event listeners, loads quiz data, starts timer, and displays first question
 */
function init() {
  setupEventListeners();
  loadQuizData();
  startTimer();
  updateCardDisplay();
}

// ===== EVENT LISTENER SETUP =====
/**
 * Set up all event listeners for user interactions
 * Includes surrender button and answer option buttons
 */
function setupEventListeners() {
  // Surrender button functionality
  if (surrenderBtn) {
    surrenderBtn.addEventListener('click', () => {
      if (confirm('Are you sure you want to surrender?')) {
        endGame();
      }
    });
  }

  // Answer option button functionality
  optionButtons.forEach(button => {
    button.addEventListener('click', () => {
      selectOption(button);
    });
  });
}

// ===== QUIZ DATA MANAGEMENT =====
/**
 * Load quiz data into the game
 * In a real app, this would parse data from an uploaded file
 */
function loadQuizData() {
  quizCards = sampleQuizData;
  totalCardsElement.textContent = quizCards.length;
}

// ===== TIMER MANAGEMENT =====
/**
 * Start the game timer countdown
 * Updates every second and ends game when time runs out
 */
function startTimer() {
  timerInterval = setInterval(() => {
    timer--;
    updateTimerDisplay();
    
    if (timer <= 0) {
      endGame();
    }
  }, 1000);
}

/**
 * Update the timer display in MM:SS format
 * Converts seconds to minutes and seconds for display
 */
function updateTimerDisplay() {
  const minutes = Math.floor(timer / 60);
  const seconds = timer % 60;
  timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
}

// ===== QUESTION DISPLAY MANAGEMENT =====
/**
 * Update the current question display
 * Shows question text, updates progress, and resets answer buttons
 */
function updateCardDisplay() {
  if (currentCardIndex >= quizCards.length) {
    endGame();
    return;
  }

  const currentCard = quizCards[currentCardIndex];
  questionText.textContent = currentCard.question;
  currentCardElement.textContent = currentCardIndex + 1;

  // Update option buttons with new question data
  optionButtons.forEach((button, index) => {
    const optionLetter = button.querySelector('.option-letter');
    const optionText = button.querySelector('.option-text');
    
    optionLetter.textContent = String.fromCharCode(65 + index) + '.';
    optionText.textContent = currentCard.options[index];
    
    // Reset button state for new question
    button.classList.remove('selected', 'correct', 'incorrect');
    button.disabled = false;
  });
}

// ===== ANSWER SELECTION AND VALIDATION =====
/**
 * Handle user selection of an answer option
 * Validates answer, updates scores, and progresses to next question
 * @param {HTMLElement} selectedButton - The button element that was clicked
 */
function selectOption(selectedButton) {
  const selectedIndex = Array.from(optionButtons).indexOf(selectedButton);
  const currentCard = quizCards[currentCardIndex];
  
  // Disable all buttons to prevent multiple selections
  optionButtons.forEach(button => {
    button.disabled = true;
  });

  // Mark selected button
  selectedButton.classList.add('selected');

  // Check if answer is correct and update scores
  const isCorrect = selectedIndex === currentCard.correctAnswer;
  
  if (isCorrect) {
    selectedButton.classList.add('correct');
    playerScores.you.correct++;
  } else {
    selectedButton.classList.add('incorrect');
    playerScores.you.incorrect++;
    
    // Show correct answer when user selects wrong option
    optionButtons[currentCard.correctAnswer].classList.add('correct');
  }

  // Update score display
  updateScoreDisplay();

  // Simulate opponent's answer (for demo purposes)
  setTimeout(() => {
    simulateWendyAnswer(currentCard);
  }, 1000);

  // Move to next question after delay
  setTimeout(() => {
    nextCard();
  }, 2000);
}

// ===== OPPONENT AI SIMULATION =====
/**
 * Simulate the opponent's answer for demonstration
 * In a real multiplayer game, this would be replaced with actual opponent responses
 * @param {Object} currentCard - The current question card object
 */
function simulateWendyAnswer(currentCard) {
  const isCorrect = Math.random() > 0.5; // 50% chance of being correct
  
  if (isCorrect) {
    playerScores.wendy.correct++;
  } else {
    playerScores.wendy.incorrect++;
  }
  
  updateScoreDisplay();
}

// ===== SCORE MANAGEMENT =====
/**
 * Update the score display for both players
 * Updates the visual score indicators in the player cards
 */
function updateScoreDisplay() {
  // Update current player's scores
  playerScoreElements.you.correct.textContent = playerScores.you.correct;
  playerScoreElements.you.incorrect.textContent = playerScores.you.incorrect;
  
  // Update opponent's scores
  playerScoreElements.wendy.correct.textContent = playerScores.wendy.correct;
  playerScoreElements.wendy.incorrect.textContent = playerScores.wendy.incorrect;
}

// ===== GAME PROGRESSION =====
/**
 * Move to the next question or end the game
 * Increments question index and updates display or ends game if complete
 */
function nextCard() {
  currentCardIndex++;
  
  if (currentCardIndex >= quizCards.length) {
    endGame();
  } else {
    updateCardDisplay();
  }
}

// ===== GAME END MANAGEMENT =====
/**
 * End the game and show final results
 * Clears timer, displays final scores, and redirects to lobby
 */
function endGame() {
  clearInterval(timerInterval);
  
  const yourScore = playerScores.you.correct;
  const wendyScore = playerScores.wendy.correct;
  
  // Create result message
  let message = `Game Over!\n\nFinal Scores:\nYou: ${yourScore} correct\nWendy: ${wendyScore} correct\n\n`;
  
  // Determine winner
  if (yourScore > wendyScore) {
    message += "You won! 🎉";
  } else if (wendyScore > yourScore) {
    message += "Wendy won! 🎉";
  } else {
    message += "It's a tie! 🤝";
  }
  
  alert(message);
  
  // Redirect back to co-op lobby
  window.location.href = 'cooplobby.php';
}

// ===== PAGE INITIALIZATION =====
// Start the game when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', init);
