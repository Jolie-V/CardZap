// Global variables
let notifications = [];
let subjects = [
  { id: 1, name: 'Mathematics', students: 0 },
  { id: 2, name: 'Science', students: 0 },
  { id: 3, name: 'English', students: 0 }
];

// DOM elements
const logoutBtn = document.querySelector('.logout-btn');
const notificationBtn = document.querySelector('.notification-btn');
const notificationPopup = document.querySelector('.notification-popup');
const notificationContent = document.querySelector('.notification-content');
const subjectsGrid = document.querySelector('.subjects-grid');

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
        if (subjectId) {
          openSubjectDetails(subjectId);
        }
      }
    });
  }
}

// Display subjects
function displaySubjects() {
  if (!subjectsGrid) return;

  const subjectsHTML = subjects.map(subject => `
    <div class="subject-card" data-subject-id="${subject.id}">
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
function openSubjectDetails(subjectId) {
  const subject = subjects.find(s => s.id == subjectId);
  if (subject) {
    alert(`Subject: ${subject.name}\nStudents: ${subject.students}\n\nThis would open a detailed view of the subject.`);
    // In a real app, this would navigate to the subject details page
  }
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