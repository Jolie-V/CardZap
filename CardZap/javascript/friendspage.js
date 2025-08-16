// Logout functionality
const logoutBtn = document.querySelector('.logout-btn');
if (logoutBtn) {
  logoutBtn.addEventListener('click', () => {
    window.location.href = 'visitor_homepage.php';
  });
}

// Notification popup
const notificationBtn = document.querySelector('.notification-btn');
const notificationPopup = document.querySelector('.notification-popup');

if (notificationBtn && notificationPopup) {
  notificationBtn.addEventListener('click', () => {
    notificationPopup.classList.toggle('show');
  });
}

// Tab switching
const tabs = document.querySelectorAll('.tab');
tabs.forEach(tab => {
  tab.addEventListener('click', () => {
    tabs.forEach(t => t.classList.remove('active'));
    tab.classList.add('active');
  });
});