// === Classic Cards • Game Script ===
// This script powers the Classic Cards experience: timer, card navigation,
// score tracking, simple content parsing, and modal interactions.

// === Global State ===
let isFlipped = false;
let correctCount = 0;
let incorrectCount = 0;
let currentCardIndex = 1;
let totalCards = 4;
let timerInterval;
let timeLeft = 300; // 5 minutes in seconds
let deckData = null;

// === DOM Elements ===
const flashcard = document.getElementById('cc-card');
const cardInner = document.getElementById('cc-card-inner');
const cardFront = document.getElementById('cc-front');
const cardBack = document.getElementById('cc-back');
const menuBtn = document.getElementById('menuBtn');
const menuModal = document.getElementById('menuModal');
const scoreModal = document.getElementById('scoreModal');
const timer = document.getElementById('timer');
const correctCountElement = document.getElementById('correctCount');
const incorrectCountElement = document.getElementById('incorrectCount');
const currentCardElement = document.getElementById('currentCard');
const totalCardsElement = document.getElementById('totalCards');
const finalIncorrectElement = document.getElementById('finalIncorrect');
const finalCorrectElement = document.getElementById('finalCorrect');
const returnHomeElement = document.getElementById('returnHome');
const answerLeft = document.getElementById('answerLeft');
const answerRight = document.getElementById('answerRight');
const pageTitle = document.getElementById('pageTitle');
let dragStartX = null;
let dragStartY = null;
let isDragging = false;
let hasDragged = false;
let ignoreNextClick = false;

flashcard.addEventListener('click', (e) => {
  // avoid treating a drag-end click as a flip
  if (drag.active || suppressNextClick) {
    suppressNextClick = false;
    return;
  }
  flipCard();
});

function flipCard() {
  isFlipped = !isFlipped;
  flashcard.classList.toggle('is-flipped', isFlipped);
  updateAnswerAreaFeedback();
}

// === Drag to Score (Hold and drag left/right after flipping) ===

// Touch and mouse drag handlers for grading
flashcard.addEventListener('mousedown', onPointerDown);
window.addEventListener('mousemove', onPointerMove);
window.addEventListener('mouseup', onPointerUp);
flashcard.addEventListener('touchstart', onPointerDown, {passive: true});
window.addEventListener('touchmove', onPointerMove, {passive: true});
window.addEventListener('touchend', onPointerUp);

// === Drag to Score (Hold and drag left/right after flipping) ===
const COMMIT_THRESHOLD_PX = 120;
const MOVE_SUPPRESS_CLICK_PX = 8;

let drag = {active: false, startX: 0, currentX: 0, moved: false};
let suppressNextClick = false; // prevents flip after a swipe release

/**
 * Handles pointer down events (mouse/touch start)
 * Initializes drag tracking
 */
function onPointerDown(e) {
  if (!isFlipped) return;
  drag.active = true;
  drag.startX = (e.touches ? e.touches[0].clientX : e.clientX);
  drag.currentX = drag.startX;
  drag.moved = false;
}

/**
 * Handles pointer move events during drag
 * Updates card position and visual feedback
 */
function onPointerMove(e) {
  if (!drag.active) return;
  drag.currentX = (e.touches ? e.touches[0].clientX : e.clientX);
  const dx = drag.currentX - drag.startX;
  if (!drag.moved && Math.abs(dx) > 3) { drag.moved = true; }
  const rot = Math.max(-20, Math.min(20, dx / 8));
  flashcard.style.transform = `translateX(${dx}px) rotate(${rot}deg)`;
  flashcard.style.opacity = String(Math.max(0.55, 1 - Math.abs(dx) / 420));
  flashcard.classList.toggle("drag-right", dx > 10);
  flashcard.classList.toggle("drag-left", dx < -10);
}

/**
 * Handles pointer up events (mouse/touch end)
 * Processes swipe gesture and grades answer
 */
function onPointerUp() {
  if (!drag.active) return;
  drag.active = false;
  const dx = drag.currentX - drag.startX;
  flashcard.classList.remove("drag-left", "drag-right");
  
  // Threshold to accept swipe (slightly easier to trigger)
  if (Math.abs(dx) > 90) {
    suppressNextClick = true; // avoid click-to-flip being triggered by release
    if (dx > 0) { markAnswer(true); }  // Swipe right = correct
    else { markAnswer(false); }    // Swipe left = wrong
  } else {
    // any drag movement should not trigger a flip on click
    if (drag.moved) { suppressNextClick = true; }
    // snap back to original position
    flashcard.style.transform = "";
    flashcard.style.opacity = "";
  }
  drag.moved = false;
}

/**
 * Marks the current answer as correct or wrong
 * Updates score and animates card exit
 * @param {boolean} isCorrect - Whether the answer is correct
 */
function markAnswer(isCorrect) {
  if (isCorrect) correctCount++; else incorrectCount++;
  updateScoreDisplay();
  
  // Animate card exit with direction based on correctness
  const direction = isCorrect ? 1 : -1;
  flashcard.style.transition = "transform .22s ease-out, opacity .22s ease-out";
  requestAnimationFrame(() => {
    flashcard.style.transform = `translate(${direction * 560}px, -36px) rotate(${direction * 22}deg)`;
    flashcard.style.opacity = "0";
  });
  
  // Move to next card after animation
  setTimeout(() => {
    flashcard.style.transition = "";
    flashcard.style.transform = "";
    flashcard.style.opacity = "";
    nextCard();
  }, 220);
}



// === Menu Functionality ===
// Opens/closes the in-session menu; provides basic actions.
menuBtn.addEventListener('click', () => menuModal.classList.add('show'));
menuModal.addEventListener('click', (e) => {
  if (e.target === menuModal) menuModal.classList.remove('show');
});

function saveProgress() {
  // Persist minimal progress data per deck in localStorage
  const progressKey = deckData && deckData.deckId
    ? `classiccards_progress_${deckData.deckId}`
    : 'classiccards_progress_generic';
  const payload = {
    deckId: deckData && deckData.deckId,
    deckName: deckData && deckData.deckName,
    subjectName: deckData && deckData.subjectName,
    currentCardIndex,
    totalCards,
    correctCount,
    incorrectCount,
    timeLeft,
    savedAt: new Date().toISOString()
  };
  try {
    localStorage.setItem(progressKey, JSON.stringify(payload));
  } catch (err) {
    console.warn('Unable to save progress:', err);
  }
}

function navigateToYourCards() {
  // Return to the appropriate "Your Cards" page based on user type
  if (document.referrer.includes('teacher_subjects') || document.referrer.includes('teacher_yourcards')) {
    window.location.href = 'teacher_yourcards.php';
    return;
  }
  if (document.referrer.includes('student_enrolled') || document.referrer.includes('student_yourcards')) {
    window.location.href = 'student_yourcards.php';
    return;
  }
  const urlParams = new URLSearchParams(window.location.search);
  const type = urlParams.get('type');
  if (type === 'teacher') {
    window.location.href = 'teacher_yourcards.php';
  } else {
    window.location.href = 'student_yourcards.php';
  }
}

document.getElementById('saveBtn').addEventListener('click', () => {
  saveProgress();
  menuModal.classList.remove('show');
});

document.getElementById('saveExitBtn').addEventListener('click', () => {
  saveProgress();
  menuModal.classList.remove('show');
  navigateToYourCards();
});

document.getElementById('exitBtn').addEventListener('click', () => {
  menuModal.classList.remove('show');
  navigateToYourCards();
});

// === Timer ===
/**
 * Starts the countdown timer for the study session.
 * Decrements every second, updates UI, and ends session at 0.
 */
function startTimer() {
  timerInterval = setInterval(() => {
    timeLeft--;
    updateTimerDisplay();
    if (timeLeft <= 0) {
      clearInterval(timerInterval);
      showScoreModal();
    }
  }, 1000);
}

/**
 * Updates the on-screen timer text in mm:ss format.
 */
function updateTimerDisplay() {
  const minutes = Math.floor(timeLeft / 60);
  const seconds = timeLeft % 60;
  timer.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
}

// === Score Handling ===
/**
 * Re-renders the correct/incorrect counters in the header.
 */
function updateScoreDisplay() {
  correctCountElement.textContent = correctCount;
  incorrectCountElement.textContent = incorrectCount;
}

/**
 * Populates and shows the final score modal.
 */
function showScoreModal() {
  finalIncorrectElement.textContent = incorrectCount;
  finalCorrectElement.textContent = correctCount;
  scoreModal.classList.add('show');
}

// === Score Modal Events ===
returnHomeElement.addEventListener('click', () => {
  scoreModal.classList.remove('show');
  navigateToYourCards();
});

const tryAgainBtn = document.getElementById('tryAgainBtn');
if (tryAgainBtn) {
  tryAgainBtn.addEventListener('click', () => {
    // Reset progress for classic session
    currentCardIndex = 1;
    correctCount = 0;
    incorrectCount = 0;
    isFlipped = false;
    updateScoreDisplay();
    flashcard.classList.remove('is-flipped');
    updateCardDisplay();
    // Restart timer
    clearInterval(timerInterval);
    timeLeft = 300;
    updateTimerDisplay();
    startTimer();
    // Hide modal
    scoreModal.classList.remove('show');
  });
}

scoreModal.addEventListener('click', (e) => {
  if (e.target === scoreModal) scoreModal.classList.remove('show');
});

// === Keyboard Shortcuts ===
// Space: flip, ArrowRight: mark correct, ArrowLeft: mark incorrect, Esc: close modals
document.addEventListener('keydown', (e) => {
  switch (e.key) {
    case ' ':
      e.preventDefault();
      flashcard.click();
      break;
    case 'ArrowRight':
      if (isFlipped) {
        markAnswer(true);
      } else {
        showFlipPrompt();
      }
      break;
    case 'ArrowLeft':
      if (isFlipped) {
        markAnswer(false);
      } else {
        showFlipPrompt();
      }
      break;
    case 'Escape':
      menuModal.classList.remove('show');
      scoreModal.classList.remove('show');
      break;
  }
});

// === Card Navigation ===
/**
 * Advances to the next card, or ends the session if finished.
 */
function nextCard() {
  if (currentCardIndex < totalCards) {
    currentCardIndex++;
    currentCardElement.textContent = currentCardIndex;
    isFlipped = false;
    flashcard.classList.remove('is-flipped');
    updateCardDisplay();
  } else {
    showScoreModal();
  }
}

// === URL Parameter Handling ===
/**
 * Reads deck info from URL parameters and prepares page state.
 * Updates title, totals, and triggers card generation.
 */
function getDeckDataFromURL() {
  const urlParams = new URLSearchParams(window.location.search);
  const deckId = urlParams.get('deckId');
  const subjectName = urlParams.get('subjectName');
  const cardCount = urlParams.get('cardCount');
  const deckName = urlParams.get('deckName');
  const type = urlParams.get('type');
  const cardColor = urlParams.get('cardColor');
  
  if (deckId && subjectName && cardCount) {
    deckData = {
      deckId,
      subjectName,
      cardCount: parseInt(cardCount),
      deckName,
      type,
      cardColor
    };
    
    // Update page title and total cards
    pageTitle.textContent = `${deckName || subjectName} - Classic Cards`;
    totalCards = deckData.cardCount;
    totalCardsElement.textContent = totalCards;
    
    // Generate cards for the specific deck
    generateCardsForDeck();

    // Apply card color theme
    applyCardColorTheme(deckData.cardColor);
  }
}

// === Card Generation ===
/**
 * Generates cards for the specific deck based on deck type and subject.
 * Creates appropriate question-answer pairs for each deck.
 */
function generateCardsForDeck() {
  if (!deckData) return;
  
  const cards = [];
  const { deckName, subjectName, cardCount } = deckData;
  
  // Generate cards based on the deck name and subject
  if (deckName === 'Mathematics Basics' || deckName === 'Algebra Basics') {
    cards.push(
      { question: 'What is the basic form of a linear equation?', answer: 'y = mx + b' },
      { question: 'What does the variable "m" represent in y = mx + b?', answer: 'Slope' },
      { question: 'What does the variable "b" represent in y = mx + b?', answer: 'Y-intercept' },
      { question: 'How do you solve for x in 2x + 5 = 13?', answer: 'Subtract 5 from both sides, then divide by 2: x = 4' },
      { question: 'What is the slope of a horizontal line?', answer: '0' },
      { question: 'What is the slope of a vertical line?', answer: 'Undefined' },
      { question: 'What is the formula for slope?', answer: 'm = (y₂ - y₁) / (x₂ - x₁)' },
      { question: 'What is the point-slope form of a line?', answer: 'y - y₁ = m(x - x₁)' },
      { question: 'How do you find the x-intercept?', answer: 'Set y = 0 and solve for x' },
      { question: 'How do you find the y-intercept?', answer: 'Set x = 0 and solve for y' },
      { question: 'What is the standard form of a linear equation?', answer: 'Ax + By = C' },
      { question: 'What is the slope-intercept form?', answer: 'y = mx + b' },
      { question: 'How do you graph a line using slope-intercept form?', answer: 'Plot the y-intercept, then use slope to find another point' },
      { question: 'What is the relationship between parallel lines?', answer: 'They have the same slope' },
      { question: 'What is the relationship between perpendicular lines?', answer: 'Their slopes are negative reciprocals' }
    );
  } else if (deckName === 'Advanced Algebra' || deckName === 'Quadratic Equations') {
    cards.push(
      { question: 'What is the standard form of a quadratic equation?', answer: 'ax² + bx + c = 0' },
      { question: 'What is the quadratic formula?', answer: 'x = (-b ± √(b² - 4ac)) / 2a' },
      { question: 'What is the discriminant?', answer: 'b² - 4ac' },
      { question: 'What does a positive discriminant tell you?', answer: 'Two real solutions' },
      { question: 'What does a zero discriminant tell you?', answer: 'One real solution (repeated root)' },
      { question: 'What does a negative discriminant tell you?', answer: 'No real solutions (complex roots)' },
      { question: 'How do you complete the square?', answer: 'Add (b/2a)² to both sides' },
      { question: 'What is the vertex form of a quadratic?', answer: 'y = a(x - h)² + k' },
      { question: 'What are the coordinates of the vertex?', answer: '(h, k)' },
      { question: 'How do you find the axis of symmetry?', answer: 'x = h or x = -b/2a' },
      { question: 'What is the maximum/minimum point called?', answer: 'Vertex' },
      { question: 'How do you determine if a parabola opens up or down?', answer: 'If a > 0, opens up; if a < 0, opens down' },
      { question: 'What is the y-intercept of a quadratic?', answer: 'c (the constant term)' },
      { question: 'How do you factor a quadratic equation?', answer: 'Find two numbers that multiply to c and add to b' },
      { question: 'What is the difference of squares formula?', answer: 'a² - b² = (a + b)(a - b)' },
      { question: 'What is the perfect square trinomial formula?', answer: 'a² + 2ab + b² = (a + b)²' },
      { question: 'How do you solve x² = 16?', answer: 'x = ±4' },
      { question: 'What is the square root property?', answer: 'If x² = k, then x = ±√k' },
      { question: 'How do you find the roots of a quadratic?', answer: 'Use factoring, completing the square, or quadratic formula' },
      { question: 'What is the relationship between roots and factors?', answer: 'If (x - r) is a factor, then r is a root' }
    );
  } else if (deckName === 'Geometry Fundamentals' || deckName === 'Linear Functions') {
    cards.push(
      { question: 'What is a function?', answer: 'A relation where each input has exactly one output' },
      { question: 'What is the domain of a function?', answer: 'All possible input values (x-values)' },
      { question: 'What is the range of a function?', answer: 'All possible output values (y-values)' },
      { question: 'What is a linear function?', answer: 'A function with a constant rate of change' },
      { question: 'What is the rate of change in a linear function?', answer: 'The slope (m)' },
      { question: 'What is function notation?', answer: 'f(x) = mx + b' },
      { question: 'How do you evaluate f(3) if f(x) = 2x + 1?', answer: 'f(3) = 2(3) + 1 = 7' },
      { question: 'What is the difference between a relation and a function?', answer: 'A function has exactly one output for each input' },
      { question: 'What is a vertical line test?', answer: 'A test to determine if a graph represents a function' },
      { question: 'What is function composition?', answer: 'f(g(x)) means apply g first, then f' },
      { question: 'What is the inverse of a function?', answer: 'A function that "undoes" the original function' },
      { question: 'What is a piecewise function?', answer: 'A function defined by different rules for different intervals' },
      { question: 'What is the absolute value function?', answer: 'f(x) = |x|' },
      { question: 'What is a step function?', answer: 'A function that changes value at specific points' },
      { question: 'What is a constant function?', answer: 'A function where f(x) = c for all x' },
      { question: 'What is the identity function?', answer: 'f(x) = x' }
    );
  }
  
  // Ensure we have the correct number of cards
  while (cards.length < cardCount) {
    const cardNumber = cards.length + 1;
    cards.push({
      question: `Question ${cardNumber} about ${deckName || subjectName}`,
      answer: `Answer ${cardNumber} about ${deckName || subjectName}`
    });
  }
  
  // Limit to the specified card count
  cards.splice(cardCount);
  
  // Store cards globally for navigation
  window.deckCards = cards;
  
  // Update the first card
  updateCardDisplay();
}

// === Card Display ===
/**
 * Renders the current card's front and back text to the DOM.
 */
function updateCardDisplay() {
  if (!window.deckCards || !window.deckCards[currentCardIndex - 1]) return;
  
  const currentCard = window.deckCards[currentCardIndex - 1];
  
  // Update card content
  cardFront.textContent = currentCard.question;
  cardBack.textContent = currentCard.answer;
  
  // Reset flip state and update visual feedback
  isFlipped = false;
  flashcard.classList.remove('is-flipped');
  updateAnswerAreaFeedback();
}

// === Visual Feedback Functions ===
/**
 * Updates the visual feedback for answer areas based on flip state
 */
function updateAnswerAreaFeedback() {
  // Visual feedback is now handled by drag interactions
  // This function is kept for compatibility but does nothing
}

// === Card Color Theme ===
function applyCardColorTheme(colorKey) {
  const pageTitle = document.getElementById('pageTitle');
  const progressBar = document.querySelector('.progress-bar');
  const cardFaces = document.querySelectorAll('.cc-face');
  
  const gradients = {
    blue: 'linear-gradient(145deg, #60a5fa, #2563eb)',
    green: 'linear-gradient(145deg, #34d399, #059669)',
    red: 'linear-gradient(145deg, #f87171, #dc2626)',
    yellow: 'linear-gradient(145deg, #fde047, #f59e0b)',
    purple: 'linear-gradient(145deg, #a78bfa, #7c3aed)'
  };
  const textColors = {
    blue: '#ffffff',
    green: '#ffffff', 
    red: '#ffffff',
    yellow: '#1f2937',
    purple: '#ffffff'
  };
  const bgThemes = {
    blue: '#1e3a8a',
    green: '#14532d',
    red: '#7f1d1d',
    yellow: '#a16207',
    purple: '#581c87'
  };
  const progressThemes = {
    blue: '#1e40af',
    green: '#166534',
    red: '#991b1b',
    yellow: '#92400e',
    purple: '#6b21a8'
  };
  
  const chosenGradient = gradients[colorKey] || 'linear-gradient(145deg, #a78bfa, #7c3aed)';
  const chosenTextColor = textColors[colorKey] || '#ffffff';
  const chosenBg = bgThemes[colorKey] || '#4b1f7f';
  const chosenProgress = progressThemes[colorKey] || '#5b2ca0';
  
  // Apply card face styling
  cardFaces.forEach(face => {
    if (face) {
      face.style.background = chosenGradient;
      face.style.color = chosenTextColor;
    }
  });
  
  // Apply page title color (always white)
  if (pageTitle) {
    pageTitle.style.color = '#ffffff';
  }
  
  // Apply menu button color (always white)
  const menuBtn = document.getElementById('menuBtn');
  if (menuBtn) {
    menuBtn.style.color = '#ffffff';
  }
  
  // Apply progress bar styling
  if (progressBar) {
    progressBar.style.background = chosenProgress;
    progressBar.style.color = '#ffffff';
  }
  
  // Apply background theme to body
  document.body.style.background = chosenBg;
  document.body.style.backgroundImage = `
    radial-gradient(circle at 20% 30%, rgba(255, 255, 255, 0.06) 2px, transparent 2px),
    radial-gradient(circle at 80% 70%, rgba(255, 255, 255, 0.06) 2px, transparent 2px)
  `;
}

/**
 * Shows a visual prompt that the card needs to be flipped first
 */
function showFlipPrompt() {
  // Create a temporary visual feedback
  const flashcard = document.getElementById('flashcard');
  flashcard.classList.add('shake');
  
  // Remove the shake class after animation completes
  setTimeout(() => {
    flashcard.classList.remove('shake');
  }, 500);
}

// === Initialization ===
/**
 * Bootstraps page: reads URL state, initializes counters and timer.
 */
function init() {
  getDeckDataFromURL();
  updateScoreDisplay();
  updateTimerDisplay();
  startTimer();
}

document.addEventListener('DOMContentLoaded', init);
