// Global variables
let enrolledSubjects = [
  { id: 1, name: 'Mathematics', status: 'Enrolled' }
];

// DOM elements
const logoutBtn = document.querySelector('.logout-btn');
const subjectsGrid = document.querySelector('.subjects-grid');
const subjectsOverview = document.getElementById('subjects-overview');
const subjectDetail = document.getElementById('subject-detail');
const detailSubjectTitle = document.getElementById('detail-subject-title');
const tabs = document.querySelectorAll('.tab');
const panels = document.querySelectorAll('.panel');
const subjectSearch = document.getElementById('subjectSearch');

// Initialize the page
function init() {
  setupEventListeners();
}

// Setup event listeners
function setupEventListeners() {
  // Logout functionality
  if (logoutBtn) {
    logoutBtn.addEventListener('click', () => {
      window.location.href = 'visitor_homepage.php';
    });
  }

  // Add subject card click handler
  if (subjectsGrid) {
    subjectsGrid.addEventListener('click', (e) => {
      if (e.target.closest('.subject-card')) {
        const subjectCard = e.target.closest('.subject-card');
        const subjectId = subjectCard.dataset.subjectId;
        const subjectName = subjectCard.dataset.subjectName;
        if (subjectId) {
          openSubjectDetails(subjectId, subjectName);
        }
      }
    });
  }

  // Tab switching
  if (tabs.length > 0) {
    tabs.forEach(tab => {
      tab.addEventListener('click', () => {
        const targetTab = tab.dataset.tab;
        switchTab(targetTab);
      });
    });
  }

  // Add deck card click handler for navigation to classiccards or quizcards
  const publishedPanel = document.getElementById('publishedPanel');
  if (publishedPanel) {
    publishedPanel.addEventListener('click', (e) => {
      const deckCard = e.target.closest('.deck-card');
      if (deckCard) {
        const deckId = deckCard.dataset.deckId;
        const deckName = deckCard.dataset.deckName;
        const cardCount = deckCard.dataset.cardCount;
        const deckType = deckCard.dataset.deckType;
        const subject = deckCard.dataset.subject;
        
        if (deckId && deckName && cardCount) {
          if (deckType === 'Classic') {
            navigateToClassicCards(deckId, deckName, cardCount, subject);
          } else if (deckType === 'Quiz') {
            navigateToQuizCards(deckId, deckName, cardCount, subject);
          }
        }
      }
    });
  }

  // Search functionality
  if (subjectSearch) {
    subjectSearch.addEventListener('input', (e) => {
      searchSubjects(e.target.value);
    });
  }
}

// Display enrolled subjects
function displayEnrolledSubjects() {
  if (!subjectsGrid) return;

  const subjectsHTML = enrolledSubjects.map(subject => `
    <div class="subject-card" data-subject-id="${subject.id}" data-subject-name="${subject.name}">
      <div class="subject-banner">
        <div class="subject-pattern"></div>
      </div>
      <div class="subject-body">
        <div class="subject-name">${subject.name}</div>
        <div class="subject-students">${subject.status}</div>
      </div>
    </div>
  `).join('');

  subjectsGrid.innerHTML = subjectsHTML;
}

// Open subject details
function openSubjectDetails(subjectId, subjectName) {
  if (detailSubjectTitle) {
    detailSubjectTitle.textContent = subjectName;
  }
  
  // Hide subjects overview and show subject detail
  if (subjectsOverview) subjectsOverview.style.display = 'none';
  if (subjectDetail) subjectDetail.style.display = 'block';
  
  // Reset to first tab
  switchTab('published');
}

// Show subjects overview (back button functionality)
function showSubjectsOverview() {
  if (subjectsOverview) subjectsOverview.style.display = 'block';
  if (subjectDetail) subjectDetail.style.display = 'none';
}

// Search subjects
function searchSubjects(searchTerm) {
  const subjectCards = document.querySelectorAll('.subject-card');
  
  subjectCards.forEach(card => {
    const subjectName = card.querySelector('.subject-name').textContent.toLowerCase();
    const isVisible = subjectName.includes(searchTerm.toLowerCase());
    
    card.style.display = isVisible ? 'block' : 'none';
  });
}

// Switch tabs
function switchTab(tabName) {
  // Update tab buttons
  tabs.forEach(tab => {
    tab.classList.remove('active');
    if (tab.dataset.tab === tabName) {
      tab.classList.add('active');
    }
  });

  // Show/hide panels and set proper display styles
  panels.forEach(panel => {
    panel.classList.add('hidden');
    panel.style.display = 'none';
  });

  const targetPanel = document.getElementById(`${tabName}Panel`);
  if (targetPanel) {
    targetPanel.classList.remove('hidden');
    if (tabName === 'published') {
      targetPanel.style.display = 'grid';
    } else {
      targetPanel.style.display = 'block';
    }
  }
}

// Navigate to classiccards page with deck data
function navigateToClassicCards(deckId, deckName, cardCount, subject) {
  const params = new URLSearchParams({
    deckId: deckId,
    subjectName: subject,
    cardCount: cardCount,
    deckName: deckName,
    type: 'Classic'
  });
  
  window.location.href = `classiccards.php?${params.toString()}`;
}

// Navigate to quizcards page with deck data
function navigateToQuizCards(deckId, deckName, cardCount, subject) {
  const params = new URLSearchParams({
    deckId: deckId,
    subjectName: subject,
    cardCount: cardCount,
    deckName: deckName,
    type: 'Quiz'
  });
  
  window.location.href = `quizcards.php?${params.toString()}`;
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', init);