// ===== LOGOUT FUNCTIONALITY =====
const logoutBtn = document.querySelector('.logout-btn');
if (logoutBtn) {
  logoutBtn.addEventListener('click', () => {
    window.location.href = 'visitor_homepage.php';
  });
}