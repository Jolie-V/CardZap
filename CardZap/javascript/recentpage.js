// Handle logout button
const logoutBtn = document.querySelector('.logout-btn');
if (logoutBtn) {
  logoutBtn.addEventListener('click', () => {
    window.location.href = 'visitor_homepage.php';
  });
}

// Notification popup functionality
const notificationBtn = document.querySelector('.notification-btn');
const notificationPopup = document.querySelector('.notification-popup');

if (notificationBtn && notificationPopup) {
  notificationBtn.addEventListener('click', () => {
    notificationPopup.classList.toggle('show');
  });
}