// CardZap Main JavaScript Framework

// Global variables
let currentUser = null;

// Utility functions
const Utils = {
    $(selector) {
        return document.querySelector(selector);
    },
    
    $$(selector) {
        return document.querySelectorAll(selector);
    },
    
    on(element, event, handler) {
        if (element) {
            element.addEventListener(event, handler);
        }
    },
    
    setStorage(key, value) {
        try {
            localStorage.setItem(key, JSON.stringify(value));
        } catch (error) {
            console.error('Storage error:', error);
        }
    },
    
    getStorage(key, defaultValue = null) {
        try {
            const item = localStorage.getItem(key);
            return item ? JSON.parse(item) : defaultValue;
        } catch (error) {
            return defaultValue;
        }
    },
    
    validateEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    },
    
    formatDate(date) {
        return new Intl.DateTimeFormat('en-US').format(new Date(date));
    }
};

// Modal system
const Modal = {
    show(modalId) {
        const modal = Utils.$(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    },
    
    hide() {
        const modals = Utils.$$('.modal');
        modals.forEach(modal => {
            modal.classList.add('hidden');
        });
        document.body.style.overflow = '';
    },
    
    showStep(stepId) {
        const steps = Utils.$$('[id^="step"]');
        steps.forEach(step => step.style.display = 'none');
        
        const currentStep = Utils.$(stepId);
        if (currentStep) {
            currentStep.style.display = 'block';
        }
    }
};

// Notification system
const Notification = {
    show(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            max-width: 400px;
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 5000);
    },
    
    success(message) {
        this.show(message, 'success');
    },
    
    error(message) {
        this.show(message, 'error');
    }
};

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    currentUser = Utils.getStorage('user');
    setupGlobalListeners();
    initializePageFeatures();
    registerServiceWorker();
});

// Register service worker for PWA functionality
async function registerServiceWorker() {
    if ('serviceWorker' in navigator) {
        try {
            const registration = await navigator.serviceWorker.register('/sw.js');
            console.log('Service Worker registered successfully:', registration);
            
            // Check for updates
            registration.addEventListener('updatefound', () => {
                const newWorker = registration.installing;
                newWorker.addEventListener('statechange', () => {
                    if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                        // New content is available, show update notification
                        showUpdateNotification();
                    }
                });
            });
        } catch (error) {
            console.error('Service Worker registration failed:', error);
        }
    }
}

// Show update notification
function showUpdateNotification() {
    const notification = document.createElement('div');
    notification.className = 'update-notification';
    notification.innerHTML = `
        <div class="update-content">
            <span>New version available!</span>
            <button onclick="window.location.reload()" class="btn btn-primary btn-sm">Update</button>
        </div>
    `;
    notification.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: white;
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: var(--spacing-3);
        box-shadow: var(--shadow-lg);
        z-index: 1000;
        animation: slideIn 0.3s ease-out;
    `;
    
    document.body.appendChild(notification);
    
    // Auto-hide after 10 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 10000);
}

function setupGlobalListeners() {
    // Logout button
    const logoutBtn = Utils.$('.logout-btn');
    if (logoutBtn) {
        Utils.on(logoutBtn, 'click', () => {
            Utils.setStorage('auth_token', null);
            Utils.setStorage('user', null);
            window.location.href = 'loginpage.php';
        });
    }
    
    // Mobile menu
    const menuBtn = Utils.$('.mobile-menu-btn');
    const sidebar = Utils.$('.sidebar');
    
    if (menuBtn && sidebar) {
        Utils.on(menuBtn, 'click', () => {
            sidebar.classList.toggle('open');
        });
    }
    
    // Close modals on backdrop click
    Utils.on(document, 'click', (e) => {
        if (e.target.classList.contains('modal')) {
            Modal.hide();
        }
    });
    
    // Close modals on escape key
    Utils.on(document, 'keydown', (e) => {
        if (e.key === 'Escape') {
            Modal.hide();
        }
    });
}

function initializePageFeatures() {
    const currentPage = window.location.pathname.split('/').pop();
    
    switch (currentPage) {
        case 'loginpage.php':
            initializeLoginPage();
            break;
        case 'signinpage.php':
            initializeSigninPage();
            break;
        case 'admin_homepage.php':
            initializeAdminHomepage();
            break;
        case 'student_yourcards.php':
        case 'teacher_yourcards.php':
            initializeYourCardsPage();
            break;
    }
}

function initializeLoginPage() {
    const form = Utils.$('form');
    if (form) {
        Utils.on(form, 'submit', (e) => {
            const email = Utils.$('input[name="email"]').value;
            const password = Utils.$('input[name="password"]').value;
            
            if (!Utils.validateEmail(email)) {
                e.preventDefault();
                Notification.error('Please enter a valid email address');
                return;
            }
            
            if (password.length < 6) {
                e.preventDefault();
                Notification.error('Password must be at least 6 characters');
                return;
            }
        });
    }
}

function initializeSigninPage() {
    const form = Utils.$('form');
    if (form) {
        Utils.on(form, 'submit', (e) => {
            const email = Utils.$('input[name="email"]').value;
            const password = Utils.$('input[name="password"]').value;
            const fullName = Utils.$('input[name="full_name"]').value;
            
            if (!fullName.trim()) {
                e.preventDefault();
                Notification.error('Full name is required');
                return;
            }
            
            if (!Utils.validateEmail(email)) {
                e.preventDefault();
                Notification.error('Please enter a valid email address');
                return;
            }
            
            if (password.length < 6) {
                e.preventDefault();
                Notification.error('Password must be at least 6 characters');
                return;
            }
        });
    }
}

function initializeAdminHomepage() {
    // Load dashboard data
    const data = {
        students: 150,
        teachers: 25,
        subjects: 45
    };
    updateDashboardUI(data);
}

function updateDashboardUI(data) {
    const metrics = ['students', 'teachers', 'subjects'];
    metrics.forEach(metric => {
        const element = Utils.$(`.metric-${metric}`);
        if (element && data[metric] !== undefined) {
            element.textContent = data[metric].toLocaleString();
        }
    });
}

function initializeYourCardsPage() {
    setupCreateCardModal();
}

function setupCreateCardModal() {
    const addBtn = Utils.$('#addCardBtn');
    const modal = Utils.$('#cardModal');
    
    if (addBtn && modal) {
        Utils.on(addBtn, 'click', () => {
            Modal.show('#cardModal');
        });
        
        setupMultiStepModal();
    }
}

function setupMultiStepModal() {
    const nextBtn = Utils.$('#nextBtn');
    const nextTextBtn = Utils.$('#nextTextBtn');
    const nextFileBtn = Utils.$('#nextFileBtn');
    const createDeckBtn = Utils.$('#createDeckBtn');
    
    if (nextBtn) {
        Utils.on(nextBtn, 'click', () => {
            const textChecked = Utils.$('#textCheckbox').checked;
            const fileChecked = Utils.$('#fileCheckbox').checked;
            
            if (textChecked) {
                Modal.showStep('step2');
            } else if (fileChecked) {
                Modal.showStep('step3');
            }
        });
    }
    
    if (nextTextBtn) {
        Utils.on(nextTextBtn, 'click', () => {
            Modal.showStep('step4');
        });
    }
    
    if (nextFileBtn) {
        Utils.on(nextFileBtn, 'click', () => {
            Modal.showStep('step4');
        });
    }
    
    if (createDeckBtn) {
        Utils.on(createDeckBtn, 'click', () => {
            createNewDeck();
        });
    }
}

function createNewDeck() {
    const deckName = Utils.$('#subjectName').value;
    const cardColor = Utils.$('#cardColor').value;
    const gameMode = Utils.$('#classicCheckbox').checked ? 'classic' : 'quiz';
    
    if (!deckName.trim()) {
        Notification.error('Please enter a deck name');
        return;
    }
    
    Notification.success('Deck created successfully!');
    Modal.hide();
    
    // In a real implementation, you would send this to the server
    console.log('Creating deck:', { deckName, cardColor, gameMode });
}

// Global functions for HTML onclick
window.playDeck = function(deckId) {
    window.location.href = `classiccards.php?deck=${deckId}`;
};

window.editDeck = function(deckId) {
    window.location.href = `editclassic.php?deck=${deckId}`;
};

window.deleteDeck = function(deckId) {
    if (confirm('Are you sure you want to delete this deck?')) {
        Notification.success('Deck deleted successfully');
        console.log('Deleting deck:', deckId);
    }
};

// Export for use in other files
window.CardZap = {
    Utils,
    Modal,
    Notification
};
