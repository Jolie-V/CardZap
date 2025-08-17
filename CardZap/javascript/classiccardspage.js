// === Global Variables ===
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

// === Flashcard Flip ===
flashcard.addEventListener('click', () => {
  isFlipped = !isFlipped;
  flashcard.classList.toggle('flipped', isFlipped);
});

// === Answer Areas ===
answerLeft.addEventListener('click', () => {
  incorrectCount++;
  updateScoreDisplay();
  nextCard();
});

answerRight.addEventListener('click', () => {
  correctCount++;
  updateScoreDisplay();
  nextCard();
});



// === Menu Functionality ===
menuBtn.addEventListener('click', () => menuModal.classList.add('show'));
menuModal.addEventListener('click', (e) => {
  if (e.target === menuModal) menuModal.classList.remove('show');
});

document.getElementById('saveBtn').addEventListener('click', () => {
  menuModal.classList.remove('show');
  console.log('Save clicked');
});

document.getElementById('saveExitBtn').addEventListener('click', () => {
  menuModal.classList.remove('show');
  window.location.href = 'yourcardspage.php';
});

document.getElementById('exitBtn').addEventListener('click', () => {
  menuModal.classList.remove('show');
  window.location.href = 'yourcardspage.php';
});

// === Timer ===
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

function updateTimerDisplay() {
  const minutes = Math.floor(timeLeft / 60);
  const seconds = timeLeft % 60;
  timer.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
}

// === Score Handling ===
function updateScoreDisplay() {
  correctCountElement.textContent = correctCount;
  incorrectCountElement.textContent = incorrectCount;
}

function showScoreModal() {
  finalIncorrectElement.textContent = incorrectCount;
  finalCorrectElement.textContent = correctCount;
  scoreModal.classList.add('show');
}

// === Score Modal Events ===
returnHomeElement.addEventListener('click', () => {
  scoreModal.classList.remove('show');
  window.location.href = 'yourcardspage.php';
});

scoreModal.addEventListener('click', (e) => {
  if (e.target === scoreModal) scoreModal.classList.remove('show');
});

// === Keyboard Shortcuts ===
document.addEventListener('keydown', (e) => {
  switch (e.key) {
    case ' ':
      e.preventDefault();
      flashcard.click();
      break;
    case 'ArrowRight':
      correctCount++;
      updateScoreDisplay();
      nextCard();
      break;
    case 'ArrowLeft':
      incorrectCount++;
      updateScoreDisplay();
      nextCard();
      break;
    case 'Escape':
      menuModal.classList.remove('show');
      scoreModal.classList.remove('show');
      break;
  }
});

// === Card Navigation ===
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
function getDeckDataFromURL() {
  const urlParams = new URLSearchParams(window.location.search);
  const deckId = urlParams.get('deckId');
  const subjectName = urlParams.get('subjectName');
  const cardCount = urlParams.get('cardCount');
  const cardColor = urlParams.get('cardColor');
  const type = urlParams.get('type');
  const content = urlParams.get('content');
  
  if (deckId && subjectName && cardCount) {
    deckData = {
      deckId,
      subjectName,
      cardCount: parseInt(cardCount),
      cardColor,
      type,
      content
    };
    
    // Update page title and total cards
    pageTitle.textContent = `${subjectName} - Classic Cards`;
    totalCards = deckData.cardCount;
    totalCardsElement.textContent = totalCards;
    
    // Generate cards based on the content
    generateCardsFromContent();
  }
}

// === Card Generation ===
function generateCardsFromContent() {
  if (!deckData || !deckData.content) return;
  
  // For now, we'll create simple question-answer pairs
  // In a real application, you might want to use AI to generate questions from the text
  const cards = [];
  const content = deckData.content;
  
  // Split content into sentences and create basic cards
  const sentences = content.split(/[.!?]+/).filter(s => s.trim().length > 10);
  
  for (let i = 0; i < Math.min(deckData.cardCount, sentences.length); i++) {
    const sentence = sentences[i].trim();
    cards.push({
      question: `What is the main idea of: "${sentence}"?`,
      answer: sentence
    });
  }
  
  // If we don't have enough sentences, create generic cards
  while (cards.length < deckData.cardCount) {
    const cardNumber = cards.length + 1;
    cards.push({
      question: `Question ${cardNumber} about ${deckData.subjectName}`,
      answer: `Answer ${cardNumber} about ${deckData.subjectName}`
    });
  }
  
  // Store cards globally for navigation
  window.deckCards = cards;
  
  // Update the first card
  updateCardDisplay();
}

// === Card Display ===
function updateCardDisplay() {
  if (!window.deckCards || !window.deckCards[currentCardIndex - 1]) return;
  
  const currentCard = window.deckCards[currentCardIndex - 1];
  document.getElementById('cardFront').textContent = currentCard.question;
  document.getElementById('cardBack').textContent = currentCard.answer;
}

// === Initialization ===
function init() {
  getDeckDataFromURL();
  updateScoreDisplay();
  updateTimerDisplay();
  startTimer();
}

document.addEventListener('DOMContentLoaded', init);