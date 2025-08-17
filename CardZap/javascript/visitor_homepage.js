// Notification popup toggle
const notificationBtn = document.querySelector('.notification-btn');
const notificationPopup = document.querySelector('.notification-popup');

if (notificationBtn && notificationPopup) {
  notificationBtn.addEventListener('click', () => {
    notificationPopup.classList.toggle('show');
  });
}