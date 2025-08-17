/* ===== QUIZ CARDS GAME LOGIC ===== */
/* This file handles the individual quiz game functionality including:
   - URL parameter parsing for deck data
   - Timer management
   - Question progression and answer validation
   - Score tracking
   - Modal interactions
   - Game state management */

// ===== GLOBAL VARIABLES =====
let deckData = null;              // Stores deck information from URL parameters
let currentCardIndex = 0;         // Current question being displayed
let correctCount = 0;             // Number of correct answers
let incorrectCount = 0;           // Number of incorrect answers
let timer = null;                 // Timer interval reference
let timeLeft = 300;               // Game timer in seconds (5 minutes)
let selectedOption = null;        // Currently selected answer option
let isAnswered = false;           // Flag to prevent multiple answers per question

// ===== DOM ELEMENT REFERENCES =====
const pageTitle = document.getElementById('pageTitle');
const timerElement = document.getElementById('timer');
const menuBtn = document.getElementById('menuBtn');
const menuModal = document.getElementById('menuModal');
const scoreModal = document.getElementById('scoreModal');
const correctCountElement = document.getElementById('correctCount');
const incorrectCountElement = document.getElementById('incorrectCount');
const currentCardElement = document.getElementById('currentCard');
const totalCardsElement = document.getElementById('totalCards');
const quizQuestion = document.getElementById('quizQuestion');
const optionA = document.getElementById('optionA');
const optionB = document.getElementById('optionB');
const optionC = document.getElementById('optionC');
const optionD = document.getElementById('optionD');
const optionAText = document.getElementById('optionAText');
const optionBText = document.getElementById('optionBText');
const optionCText = document.getElementById('optionCText');
const optionDText = document.getElementById('optionDText');

// ===== INITIALIZATION =====
/**
 * Initialize the quiz game when the page loads
 * Sets up deck data, starts timer, and configures event listeners
 */
function init() {
    getDeckDataFromURL();
    startTimer();
    setupEventListeners();
}

// ===== DECK DATA MANAGEMENT =====
/**
 * Parse deck information from URL parameters
 * Extracts deck details passed from the "Your Cards" page
 */
function getDeckDataFromURL() {
    const urlParams = new URLSearchParams(window.location.search);
    deckData = {
        deckId: urlParams.get('deckId'),
        subjectName: urlParams.get('subjectName'),
        cardCount: parseInt(urlParams.get('cardCount')) || 4,
        cardColor: urlParams.get('cardColor'),
        type: urlParams.get('type'),
        content: urlParams.get('content')
    };

    // Update page title and total cards display
    if (pageTitle) {
        pageTitle.textContent = deckData.subjectName || 'Quiz Cards';
    }
    if (totalCardsElement) {
        totalCardsElement.textContent = deckData.cardCount;
    }

    // Generate quiz questions from deck content
    generateQuizCardsFromContent();
}

// ===== QUIZ CONTENT GENERATION =====
/**
 * Generate quiz questions from deck content or use fallback data
 * Creates multiple choice questions based on provided content
 */
function generateQuizCardsFromContent() {
    if (!deckData.content) {
        // Fallback to sample quiz cards if no content provided
        window.quizCards = [
            {
                question: "What is the capital of France?",
                options: ["London", "Paris", "Berlin", "Madrid"],
                correctAnswer: 1 // Index 1 = "Paris"
            },
            {
                question: "Which planet is known as the Red Planet?",
                options: ["Venus", "Mars", "Jupiter", "Saturn"],
                correctAnswer: 1 // Index 1 = "Mars"
            },
            {
                question: "What is 2 + 2?",
                options: ["3", "4", "5", "6"],
                correctAnswer: 1 // Index 1 = "4"
            },
            {
                question: "Who wrote Romeo and Juliet?",
                options: ["Charles Dickens", "William Shakespeare", "Jane Austen", "Mark Twain"],
                correctAnswer: 1 // Index 1 = "William Shakespeare"
            }
        ];
    } else {
        // Parse content and create quiz cards from provided text
        const sentences = deckData.content.split(/[.!?]+/).filter(s => s.trim().length > 10);
        window.quizCards = [];
        
        for (let i = 0; i < Math.min(deckData.cardCount, sentences.length); i++) {
            const sentence = sentences[i].trim();
            // Create a simple quiz card with the sentence as question
            // In a real implementation, you might want to generate multiple choice options
            window.quizCards.push({
                question: sentence,
                options: [
                    "Option A",
                    "Option B", 
                    "Option C",
                    "Option D"
                ],
                correctAnswer: Math.floor(Math.random() * 4) // Random correct answer for demo
            });
        }
    }

    // Update the display
    updateQuizCardDisplay();
}

// Update quiz card display
function updateQuizCardDisplay() {
    if (!window.quizCards || currentCardIndex >= window.quizCards.length) {
        return;
    }

    const currentCard = window.quizCards[currentCardIndex];
    
    // Update question
    quizQuestion.textContent = currentCard.question;
    
    // Update options
    optionAText.textContent = currentCard.options[0];
    optionBText.textContent = currentCard.options[1];
    optionCText.textContent = currentCard.options[2];
    optionDText.textContent = currentCard.options[3];
    
    // Update progress
    currentCardElement.textContent = currentCardIndex + 1;
    
    // Reset option states
    resetOptionStates();
}

// Reset option button states
function resetOptionStates() {
    [optionA, optionB, optionC, optionD].forEach(option => {
        option.classList.remove('selected', 'correct', 'incorrect');
        option.disabled = false;
    });
    selectedOption = null;
    isAnswered = false;
}

// Handle option selection
function selectOption(optionElement, optionIndex) {
    if (isAnswered) return;
    
    // Remove previous selection
    [optionA, optionB, optionC, optionD].forEach(option => {
        option.classList.remove('selected');
    });
    
    // Select new option
    optionElement.classList.add('selected');
    selectedOption = optionIndex;
    
    // Check answer after a short delay
    setTimeout(() => {
        checkAnswer();
    }, 500);
}

// Check the selected answer
function checkAnswer() {
    if (selectedOption === null || isAnswered) return;
    
    isAnswered = true;
    const currentCard = window.quizCards[currentCardIndex];
    const isCorrect = selectedOption === currentCard.correctAnswer;
    
    // Update score
    if (isCorrect) {
        correctCount++;
        correctCountElement.textContent = correctCount;
    } else {
        incorrectCount++;
        incorrectCountElement.textContent = incorrectCount;
    }
    
    // Show correct/incorrect feedback
    [optionA, optionB, optionC, optionD].forEach((option, index) => {
        option.disabled = true;
        if (index === currentCard.correctAnswer) {
            option.classList.add('correct');
        } else if (index === selectedOption && !isCorrect) {
            option.classList.add('incorrect');
        }
    });
    
    // Move to next card after delay
    setTimeout(() => {
        nextCard();
    }, 2000);
}

// Move to next card
function nextCard() {
    currentCardIndex++;
    
    if (currentCardIndex >= window.quizCards.length) {
        // Quiz completed
        showScoreModal();
    } else {
        updateQuizCardDisplay();
    }
}

// Start timer
function startTimer() {
    timer = setInterval(() => {
        timeLeft--;
        updateTimerDisplay();
        
        if (timeLeft <= 0) {
            clearInterval(timer);
            showScoreModal();
        }
    }, 1000);
}

// Update timer display
function updateTimerDisplay() {
    const minutes = Math.floor(timeLeft / 60);
    const seconds = timeLeft % 60;
    timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
}

// Show score modal
function showScoreModal() {
    clearInterval(timer);
    
    document.getElementById('finalCorrect').textContent = correctCount;
    document.getElementById('finalIncorrect').textContent = incorrectCount;
    
    scoreModal.classList.add('show');
}

// Setup event listeners
function setupEventListeners() {
    // Option buttons
    optionA.addEventListener('click', () => selectOption(optionA, 0));
    optionB.addEventListener('click', () => selectOption(optionB, 1));
    optionC.addEventListener('click', () => selectOption(optionC, 2));
    optionD.addEventListener('click', () => selectOption(optionD, 3));
    
    // Menu button
    menuBtn.addEventListener('click', () => {
        menuModal.classList.add('show');
    });
    
    // Menu modal buttons
    document.getElementById('saveBtn').addEventListener('click', () => {
        menuModal.classList.remove('show');
    });
    
    document.getElementById('saveExitBtn').addEventListener('click', () => {
        menuModal.classList.remove('show');
        window.location.href = 'yourcardspage.php';
    });
    
    document.getElementById('exitBtn').addEventListener('click', () => {
        menuModal.classList.remove('show');
        window.location.href = 'yourcardspage.php';
    });
    
    // Score modal return home
    document.getElementById('returnHome').addEventListener('click', () => {
        window.location.href = 'yourcardspage.php';
    });
    
    // Close modals when clicking outside
    menuModal.addEventListener('click', (e) => {
        if (e.target === menuModal) {
            menuModal.classList.remove('show');
        }
    });
    
    scoreModal.addEventListener('click', (e) => {
        if (e.target === scoreModal) {
            scoreModal.classList.remove('show');
        }
    });
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', init);
