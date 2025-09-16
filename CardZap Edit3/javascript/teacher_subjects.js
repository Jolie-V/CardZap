// Global variables
let notifications = [];
let subjects = [
  { id: 1, name: 'Mathematics', students: 0 }
];

// DOM elements
const logoutBtn = document.querySelector('.logout-btn');
const notificationBtn = document.querySelector('.notification-btn');
const notificationPopup = document.querySelector('.notification-popup');
const notificationContent = document.querySelector('.notification-content');
const subjectsGrid = document.querySelector('.subjects-grid');
const subjectsOverview = document.getElementById('subjects-overview');
const subjectDetail = document.getElementById('subject-detail');
const detailSubjectTitle = document.getElementById('detail-subject-title');
const tabs = document.querySelectorAll('.tab');
const panels = document.querySelectorAll('.panel');

// Initialize the page
function init() {
  setupEventListeners();
  updateNotificationDisplay();
  displaySubjects();
}

// Setup event listeners
function setupEventListeners() {
  // Logout functionality
if (logoutBtn) {
  logoutBtn.addEventListener('click', () => {
    window.location.href = 'visitor_homepage.php';
  });
}

  // Notification popup
  if (notificationBtn && notificationPopup) {
    notificationBtn.addEventListener('click', () => {
      notificationPopup.classList.toggle('show');
    });
  }

  // Close notification popup when clicking outside
  document.addEventListener('click', (e) => {
    if (!notificationBtn.contains(e.target) && !notificationPopup.contains(e.target)) {
      notificationPopup.classList.remove('show');
    }
  });

  // Add subject card click handler
  if (subjectsGrid) {
    subjectsGrid.addEventListener('click', (e) => {
      if (e.target.closest('.add-subject')) {
        addNewSubject();
      } else if (e.target.closest('.subject-card:not(.add-subject)')) {
        const subjectCard = e.target.closest('.subject-card');
        const subjectId = subjectCard.dataset.subjectId;
        const subjectName = subjectCard.dataset.subjectName;
        if (subjectId) {
          openSubjectDetails(subjectId, subjectName);
        }
      }
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

  // Tab switching
  if (tabs.length > 0) {
    tabs.forEach(tab => {
      tab.addEventListener('click', () => {
        const targetTab = tab.dataset.tab;
        switchTab(targetTab);
      });
    });
  }
}

// Display subjects
function displaySubjects() {
  if (!subjectsGrid) return;

  const subjectsHTML = subjects.map(subject => `
    <div class="subject-card" data-subject-id="${subject.id}" data-subject-name="${subject.name}">
      <div class="subject-banner">
        <div class="subject-pattern"></div>
      </div>
      <div class="subject-body">
        <div class="subject-name">${subject.name}</div>
        <div class="subject-students">${subject.students} students</div>
      </div>
    </div>
  `).join('');

  const addSubjectHTML = `
    <div class="subject-card add-subject">
      <div class="subject-banner add-banner">
        <div class="add-icon">+</div>
      </div>
      <div class="subject-body">
        <div class="subject-name">Add Subject</div>
      </div>
    </div>
  `;

  subjectsGrid.innerHTML = subjectsHTML + addSubjectHTML;
}

// Add new subject
function addNewSubject() {
  const subjectName = prompt('Enter subject name:');
  if (subjectName && subjectName.trim()) {
    const newSubject = {
      id: Date.now(),
      name: subjectName.trim(),
      students: 0
    };
    
    subjects.push(newSubject);
    displaySubjects();
    
    // Add notification
    addNotification(`New subject "${subjectName}" created successfully!`, 'success');
  }
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

// Add notification
function addNotification(message, type = 'info') {
  const notification = {
    id: Date.now(),
    message,
    type,
    timestamp: new Date(),
    read: false
  };
  
  notifications.unshift(notification);
  updateNotificationDisplay();
  updateNotificationBadge();
}

// Update notification display
function updateNotificationDisplay() {
  if (!notificationContent) return;

  if (notifications.length === 0) {
    notificationContent.innerHTML = 'No new notifications.';
    return;
  }

  notificationContent.innerHTML = notifications.map(notification => `
    <div class="notification-item ${notification.read ? 'read' : 'unread'}">
      <div class="notification-message">${notification.message}</div>
      <div class="notification-time">${formatTime(notification.timestamp)}</div>
    </div>
  `).join('');
}

// Update notification badge
function updateNotificationBadge() {
  const unreadCount = notifications.filter(n => !n.read).length;
  if (unreadCount > 0) {
    notificationBtn.innerHTML = `🔔 <span class="notification-badge">${unreadCount}</span>`;
  } else {
    notificationBtn.innerHTML = '🔔';
  }
}

// Format time for notifications
function formatTime(date) {
  const now = new Date();
  const diff = now - date;
  const minutes = Math.floor(diff / 60000);
  const hours = Math.floor(diff / 3600000);
  const days = Math.floor(diff / 86400000);

  if (minutes < 1) return 'Just now';
  if (minutes < 60) return `${minutes}m ago`;
  if (hours < 24) return `${hours}h ago`;
  return `${days}d ago`;
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', init);


