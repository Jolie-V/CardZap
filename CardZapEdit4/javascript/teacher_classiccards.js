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
const flashcard = document.getElementById('flashcard');
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
  if (ignoreNextClick) {
    ignoreNextClick = false;
    return;
  }
  // Single tap toggles flip state
  isFlipped = !isFlipped;
  flashcard.classList.toggle('flipped', isFlipped);
  updateAnswerAreaFeedback();
});

// === Drag to Score (Hold and drag left/right after flipping) ===
const COMMIT_THRESHOLD_PX = 120;
const MOVE_SUPPRESS_CLICK_PX = 8;

function onDragStart(x, y) {
  dragStartX = x; dragStartY = y; isDragging = true; hasDragged = false;
  // Disable transition during drag for smooth follow
  flashcard.style.transition = 'transform 0s';
  // Prevent text selection artifacts during drag
  document.body.classList.add('no-select');
}

function onDragMove(x, y) {
  if (!isDragging) return;
  const dx = x - dragStartX;
  const dy = y - dragStartY;
  if (Math.abs(dx) > MOVE_SUPPRESS_CLICK_PX || Math.abs(dy) > MOVE_SUPPRESS_CLICK_PX) {
    hasDragged = true; ignoreNextClick = true;
  }
  if (!isFlipped) return; // Only allow scoring drag after flipped
  // Apply translate with slight tilt to the faces container via CSS variable
  const tilt = Math.max(-10, Math.min(10, dx / 10));
  flashcard.style.transform = `translateX(${dx}px) rotate(${tilt}deg)`;
}

function resetCardTransform() {
  // Re-enable transition and reset transform to CSS-driven state
  flashcard.style.transition = '';
  flashcard.style.transform = '';
}

function onDragEnd(x, y) {
  if (!isDragging) return;
  isDragging = false;
  const dx = x - dragStartX;
  const dy = y - dragStartY;
  const absDx = Math.abs(dx);
  const absDy = Math.abs(dy);
  // If not flipped, prompt and snap back
  if (!isFlipped) { resetCardTransform(); showFlipPrompt(); return; }
  // Decide commit vs snap-back
  if (absDx >= COMMIT_THRESHOLD_PX && absDy < 120) {
    // Commit score based on direction
    if (dx > 0) {
      correctCount++;
    } else {
      incorrectCount++;
    }
    updateScoreDisplay();
    // Animate a quick slide out then go next
    flashcard.style.transition = 'transform 0.25s ease';
    const offX = dx > 0 ? 600 : -600;
    flashcard.style.transform = `translateX(${offX}px) rotate(${dx > 0 ? 12 : -12}deg)`;
    setTimeout(() => {
      resetCardTransform();
      nextCard();
    }, 200);
  } else {
    // Snap back to center
    flashcard.style.transition = 'transform 0.25s ease';
    flashcard.style.transform = `translateX(0px) rotate(0deg)`;
    setTimeout(() => { resetCardTransform(); }, 250);
  }
  // Re-enable selection
  document.body.classList.remove('no-select');
}

// Touch handlers
flashcard.addEventListener('touchstart', (e) => {
  const t = e.touches && e.touches[0]; if (!t) return;
  onDragStart(t.clientX, t.clientY);
}, { passive: true });
flashcard.addEventListener('touchmove', (e) => {
  const t = e.touches && e.touches[0]; if (!t) return;
  onDragMove(t.clientX, t.clientY);
}, { passive: true });
flashcard.addEventListener('touchend', (e) => {
  const t = (e.changedTouches && e.changedTouches[0]) || null; if (!t) return;
  onDragEnd(t.clientX, t.clientY);
});

// Mouse (desktop) handlers
flashcard.addEventListener('mousedown', (e) => { onDragStart(e.clientX, e.clientY); });
document.addEventListener('mousemove', (e) => { if (isDragging) onDragMove(e.clientX, e.clientY); });
document.addEventListener('mouseup', (e) => { onDragEnd(e.clientX, e.clientY); });

// === Answer Areas (Left = Incorrect, Right = Correct) ===
// Handles quick marking by clicking on left/right sides of the stage.
// Only works when the card is flipped to show the answer.
answerLeft.addEventListener('click', () => {
  if (isFlipped) {
    incorrectCount++;
    updateScoreDisplay();
    nextCard();
  } else {
    // Show visual feedback that card needs to be flipped first
    showFlipPrompt();
  }
});

answerRight.addEventListener('click', () => {
  if (isFlipped) {
    correctCount++;
    updateScoreDisplay();
    nextCard();
  } else {
    // Show visual feedback that card needs to be flipped first
    showFlipPrompt();
  }
});



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
    flashcard.classList.remove('flipped');
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
        correctCount++;
        updateScoreDisplay();
        nextCard();
      } else {
        showFlipPrompt();
      }
      break;
    case 'ArrowLeft':
      if (isFlipped) {
        incorrectCount++;
        updateScoreDisplay();
        nextCard();
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
    flashcard.classList.remove('flipped');
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
  const cardFront = document.getElementById('cardFront');
  const cardBack = document.getElementById('cardBack');
  
  // Update card content
  cardFront.textContent = currentCard.question;
  cardBack.textContent = currentCard.answer;
  
  // Reset flip state and update visual feedback
  isFlipped = false;
  flashcard.classList.remove('flipped');
  updateAnswerAreaFeedback();
}

// === Visual Feedback Functions ===
/**
 * Updates the visual feedback for answer areas based on flip state
 */
function updateAnswerAreaFeedback() {
  if (isFlipped) {
    // Card is flipped - show that scoring is available
    answerLeft.classList.add('ready-for-scoring');
    answerRight.classList.add('ready-for-scoring');
    answerLeft.classList.remove('needs-flip');
    answerRight.classList.remove('needs-flip');
    
    // Update flashcard appearance
    flashcard.classList.add('ready-for-scoring');
    flashcard.classList.remove('needs-flip');
  } else {
    // Card is not flipped - show that it needs to be flipped first
    answerLeft.classList.remove('ready-for-scoring');
    answerRight.classList.remove('ready-for-scoring');
    answerLeft.classList.add('needs-flip');
    answerRight.classList.add('needs-flip');
    
    // Update flashcard appearance
    flashcard.classList.remove('ready-for-scoring');
    flashcard.classList.add('needs-flip');
  }
}

// === Card Color Theme ===
function applyCardColorTheme(colorKey) {
  const cardFront = document.getElementById('cardFront');
  const cardBack = document.getElementById('cardBack');
  const pageTitle = document.getElementById('pageTitle');
  const progressBar = document.querySelector('.progress-bar');
  
  const gradients = {
    blue: 'linear-gradient(135deg, #60a5fa 0%, #2563eb 100%)',
    green: 'linear-gradient(135deg, #34d399 0%, #059669 100%)',
    red: 'linear-gradient(135deg, #f87171 0%, #dc2626 100%)',
    yellow: 'linear-gradient(135deg, #fde047 0%, #f59e0b 100%)',
    purple: 'linear-gradient(135deg, #a78bfa 0%, #7c3aed 100%)'
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
  
  const chosenGradient = gradients[colorKey] || 'linear-gradient(135deg, #ffd700 0%, #ffa500 100%)';
  const chosenTextColor = textColors[colorKey] || '#8b4513';
  const chosenBg = bgThemes[colorKey] || '#f5f5dc';
  const chosenProgress = progressThemes[colorKey] || '#8b4513';
  
  [cardFront, cardBack].forEach(el => { 
    if (el) {
      el.style.background = chosenGradient;
      el.style.color = chosenTextColor;
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
    radial-gradient(circle at 20% 30%, rgba(0, 0, 0, 0.1) 2px, transparent 2px),
    radial-gradient(circle at 80% 70%, rgba(0, 0, 0, 0.1) 2px, transparent 2px)
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