/* ===== Quiz Cards • Game Script =====
   Powers the Quiz Cards experience: URL parsing, timer,
   question generation, scoring, option handling, and modals.
*/

// ===== Global State =====
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

// ===== Initialization =====
/**
 * Initializes the quiz game on DOM ready: loads deck data,
 * starts the timer, and wires event listeners.
 */
function init() {
    getDeckDataFromURL();
    startTimer();
    setupEventListeners();
}

// ===== Deck Data Management =====
/**
 * Parses deck information from URL parameters and updates title.
 */
function getDeckDataFromURL() {
    const urlParams = new URLSearchParams(window.location.search);
    deckData = {
        deckId: urlParams.get('deckId'),
        subjectName: urlParams.get('subjectName'),
        cardCount: parseInt(urlParams.get('cardCount')) || 4,
        deckName: urlParams.get('deckName'),
        type: urlParams.get('type')
    };

    // Update page title and total cards display
    if (pageTitle) {
        pageTitle.textContent = `${deckData.deckName || deckData.subjectName} - Quiz Cards`;
    }
    
    // Update total cards display
    if (totalCardsElement) {
        totalCardsElement.textContent = deckData.cardCount;
    }

    // Generate quiz questions for the specific deck
    generateQuizCardsForDeck();
}

// ===== Quiz Content Generation =====
/**
 * Generates quiz questions for the specific deck based on deck type and subject.
 * Creates appropriate multiple-choice questions for each deck.
 */
function generateQuizCardsForDeck() {
    if (!deckData) return;
    
    const cards = [];
    const { deckName, subjectName, cardCount } = deckData;
    
    // Generate quiz questions based on the deck name and subject
    if (deckName === 'Calculus Quiz') {
        cards.push(
            {
                question: "What is the derivative of x²?",
                options: ["x", "2x", "2x²", "x²"],
                correctAnswer: 1
            },
            {
                question: "What is the integral of 2x?",
                options: ["x²", "x² + C", "2x²", "2x² + C"],
                correctAnswer: 1
            },
            {
                question: "What is the limit of (x² - 1)/(x - 1) as x approaches 1?",
                options: ["0", "1", "2", "Undefined"],
                correctAnswer: 2
            },
            {
                question: "What is the derivative of sin(x)?",
                options: ["cos(x)", "-cos(x)", "sin(x)", "-sin(x)"],
                correctAnswer: 0
            },
            {
                question: "What is the integral of cos(x)?",
                options: ["sin(x)", "sin(x) + C", "-sin(x)", "-sin(x) + C"],
                correctAnswer: 1
            },
            {
                question: "What is the derivative of e^x?",
                options: ["e^x", "xe^x", "ln(x)", "1/x"],
                correctAnswer: 0
            },
            {
                question: "What is the chain rule for f(g(x))?",
                options: ["f'(x)g'(x)", "f'(g(x))g'(x)", "f(g'(x))", "f'(x)g(x)"],
                correctAnswer: 1
            },
            {
                question: "What is the product rule for f(x)g(x)?",
                options: ["f'(x)g'(x)", "f'(x)g(x) + f(x)g'(x)", "f(x)g'(x)", "f'(x)g(x)"],
                correctAnswer: 1
            },
            {
                question: "What is the derivative of ln(x)?",
                options: ["1/x", "x", "e^x", "1"],
                correctAnswer: 0
            },
            {
                question: "What is the integral of 1/x?",
                options: ["ln(x)", "ln(x) + C", "1/x²", "x"],
                correctAnswer: 1
            },
            {
                question: "What is the derivative of tan(x)?",
                options: ["sec²(x)", "tan²(x)", "cot(x)", "csc(x)"],
                correctAnswer: 0
            },
            {
                question: "What is the limit of sin(x)/x as x approaches 0?",
                options: ["0", "1", "∞", "Undefined"],
                correctAnswer: 1
            },
            {
                question: "What is the derivative of sec(x)?",
                options: ["sec(x)tan(x)", "sec²(x)", "csc(x)", "cot(x)"],
                correctAnswer: 0
            },
            {
                question: "What is the integral of sec²(x)?",
                options: ["tan(x)", "tan(x) + C", "sec(x)", "sec(x) + C"],
                correctAnswer: 1
            },
            {
                question: "What is the derivative of arcsin(x)?",
                options: ["1/√(1-x²)", "1/√(1+x²)", "1/(1-x²)", "1/(1+x²)"],
                correctAnswer: 0
            },
            {
                question: "What is the integral of 1/√(1-x²)?",
                options: ["arcsin(x)", "arcsin(x) + C", "arccos(x)", "arctan(x)"],
                correctAnswer: 1
            },
            {
                question: "What is the derivative of x^n?",
                options: ["nx^(n-1)", "nx^n", "x^(n-1)", "n"],
                correctAnswer: 0
            },
            {
                question: "What is the integral of x^n?",
                options: ["x^(n+1)/(n+1)", "x^(n+1)/(n+1) + C", "nx^(n-1)", "nx^(n-1) + C"],
                correctAnswer: 1
            }
        );
    } else if (deckName === 'Statistics Test') {
        cards.push(
            {
                question: "What is the mean of the numbers 2, 4, 6, 8, 10?",
                options: ["5", "6", "7", "8"],
                correctAnswer: 1
            },
            {
                question: "What is the median of the numbers 1, 3, 5, 7, 9?",
                options: ["3", "5", "7", "9"],
                correctAnswer: 1
            },
            {
                question: "What is the mode of the numbers 2, 2, 3, 4, 4, 4, 5?",
                options: ["2", "3", "4", "5"],
                correctAnswer: 2
            },
            {
                question: "What is the range of the numbers 10, 15, 20, 25, 30?",
                options: ["15", "20", "25", "30"],
                correctAnswer: 1
            },
            {
                question: "What is the standard deviation of the numbers 1, 2, 3, 4, 5?",
                options: ["1", "1.58", "2", "2.24"],
                correctAnswer: 1
            },
            {
                question: "What is the variance of the numbers 1, 2, 3, 4, 5?",
                options: ["1", "2", "2.5", "3"],
                correctAnswer: 1
            },
            {
                question: "What is the probability of rolling a 6 on a fair die?",
                options: ["1/6", "1/3", "1/2", "1"],
                correctAnswer: 0
            },
            {
                question: "What is the probability of flipping heads twice in a row?",
                options: ["1/4", "1/2", "3/4", "1"],
                correctAnswer: 0
            },
            {
                question: "What is the z-score for a value that is 2 standard deviations above the mean?",
                options: ["-2", "-1", "1", "2"],
                correctAnswer: 3
            },
            {
                question: "What is the confidence interval for a 95% confidence level?",
                options: ["±1.96σ", "±1.64σ", "±2.58σ", "±3.29σ"],
                correctAnswer: 0
            },
            {
                question: "What is the null hypothesis in hypothesis testing?",
                options: ["There is a difference", "There is no difference", "The sample is biased", "The population is normal"],
                correctAnswer: 1
            },
            {
                question: "What is a Type I error?",
                options: ["Rejecting a true null hypothesis", "Accepting a false null hypothesis", "Rejecting a false null hypothesis", "Accepting a true null hypothesis"],
                correctAnswer: 0
            },
            {
                question: "What is a Type II error?",
                options: ["Rejecting a true null hypothesis", "Accepting a false null hypothesis", "Rejecting a false null hypothesis", "Accepting a true null hypothesis"],
                correctAnswer: 1
            },
            {
                question: "What is the correlation coefficient range?",
                options: ["-1 to 1", "0 to 1", "-∞ to ∞", "0 to ∞"],
                correctAnswer: 0
            },
            {
                question: "What is the coefficient of determination (R²)?",
                options: ["The correlation coefficient", "The square of the correlation coefficient", "The standard deviation", "The variance"],
                correctAnswer: 1
            },
            {
                question: "What is the normal distribution also called?",
                options: ["Bell curve", "Gaussian distribution", "Both A and B", "Neither A nor B"],
                correctAnswer: 2
            },
            {
                question: "What is the empirical rule for normal distributions?",
                options: ["68-95-99.7", "70-90-95", "60-80-90", "50-75-90"],
                correctAnswer: 0
            },
            {
                question: "What is the central limit theorem about?",
                options: ["Sample means approach normal distribution", "Population means are always normal", "Sample sizes don't matter", "Standard deviation is always 1"],
                correctAnswer: 0
            },
            {
                question: "What is a p-value?",
                options: ["The probability of the null hypothesis being true", "The probability of the alternative hypothesis being true", "The probability of getting the observed result or more extreme", "The confidence level"],
                correctAnswer: 2
            },
            {
                question: "What is the significance level (α)?",
                options: ["The probability of rejecting the null hypothesis", "The probability of accepting the null hypothesis", "The probability of a Type I error", "The probability of a Type II error"],
                correctAnswer: 2
            },
            {
                question: "What is the power of a statistical test?",
                options: ["1 - α", "1 - β", "α", "β"],
                correctAnswer: 1
            },
            {
                question: "What is a confidence interval?",
                options: ["A range of values that contains the population parameter", "A range of values that contains the sample statistic", "The margin of error", "The standard error"],
                correctAnswer: 0
            },
            {
                question: "What is the margin of error?",
                options: ["Half the width of the confidence interval", "The width of the confidence interval", "The standard error", "The standard deviation"],
                correctAnswer: 0
            },
            {
                question: "What is the standard error?",
                options: ["The standard deviation of the population", "The standard deviation of the sample", "The standard deviation of the sampling distribution", "The variance of the sample"],
                correctAnswer: 2
            },
            {
                question: "What is the chi-square test used for?",
                options: ["Testing means", "Testing proportions", "Testing independence", "Testing correlation"],
                correctAnswer: 2
            }
        );
    }
    
    // Ensure we have the correct number of cards
    while (cards.length < cardCount) {
        const cardNumber = cards.length + 1;
        cards.push({
            question: `Question ${cardNumber} about ${deckName || subjectName}`,
            options: [`Option A for question ${cardNumber}`, `Option B for question ${cardNumber}`, `Option C for question ${cardNumber}`, `Option D for question ${cardNumber}`],
                correctAnswer: Math.floor(Math.random() * 4)
            });
        }
    
    // Limit to the specified card count
    cards.splice(cardCount);
    
    // Store cards globally for navigation
    window.quizCards = cards;
    
    // Update the first card
    updateQuizCardDisplay();
}


/**
 * Updates question text, options, and progress label.
 */
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

/**
 * Clears selection/feedback styles and re-enables all options.
 */
function resetOptionStates() {
    [optionA, optionB, optionC, optionD].forEach(option => {
        option.classList.remove('selected', 'correct', 'incorrect');
        option.disabled = false;
    });
    selectedOption = null;
    isAnswered = false;
}

/**
 * Handles option selection and triggers answer checking after a delay.
 */
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

/**
 * Validates the selected option, updates score, and shows feedback.
 */
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

/**
 * Advances to the next question or shows the final score modal.
 */
function nextCard() {
    currentCardIndex++;
    
    if (currentCardIndex >= window.quizCards.length) {
        // Quiz completed
        showScoreModal();
    } else {
        updateQuizCardDisplay();
    }
}

// ===== Timer =====
/**
 * Starts the session countdown and ends quiz at zero.
 */
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

/**
 * Renders remaining time in mm:ss format.
 */
function updateTimerDisplay() {
    const minutes = Math.floor(timeLeft / 60);
    const seconds = timeLeft % 60;
    timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
}

// ===== Modals =====
/**
 * Populates and reveals the final score modal overlay.
 */
function showScoreModal() {
    clearInterval(timer);
    
    document.getElementById('finalCorrect').textContent = correctCount;
    document.getElementById('finalIncorrect').textContent = incorrectCount;
    
    scoreModal.classList.add('show');
}

// ===== Event Wiring =====
/**
 * Binds button, modal, and navigation interactions.
 */
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
        // Return to the previous page (teacher_subjects or student_enrolled)
        if (document.referrer.includes('teacher_subjects')) {
            window.location.href = 'teacher_subjects.php';
        } else if (document.referrer.includes('student_enrolled')) {
            window.location.href = 'student_enrolled.php';
        } else {
        window.location.href = 'student_yourcards.php';
        }
    });
    
    document.getElementById('exitBtn').addEventListener('click', () => {
        menuModal.classList.remove('show');
        // Return to the previous page (teacher_subjects or student_enrolled)
        if (document.referrer.includes('teacher_subjects')) {
            window.location.href = 'teacher_subjects.php';
        } else if (document.referrer.includes('student_enrolled')) {
            window.location.href = 'student_enrolled.php';
        } else {
        window.location.href = 'student_yourcards.php';
        }
    });
    
    // Score modal return home
    document.getElementById('returnHome').addEventListener('click', () => {
        // Return to the previous page (teacher_subjects or student_enrolled)
        if (document.referrer.includes('teacher_subjects')) {
            window.location.href = 'teacher_subjects.php';
        } else if (document.referrer.includes('student_enrolled')) {
            window.location.href = 'student_enrolled.php';
        } else {
        window.location.href = 'student_yourcards.php';
        }
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
