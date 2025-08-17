// ===== GLOBAL VARIABLES =====
let sections = [];
let currentSection = null;

// ===== LOGOUT =====
const logoutBtn = document.querySelector('.logout-btn');
if (logoutBtn) {
  logoutBtn.addEventListener('click', () => {
    window.location.href = 'visitor_homepage.php';
  });
}

// ===== MODAL =====
function openAddSectionModal() {
  document.getElementById('addSectionModal').style.display = 'block';
}

function closeModal(modalId) {
  document.getElementById(modalId).style.display = 'none';
  if (modalId === 'addSectionModal') {
    document.getElementById('addSectionForm').reset();
  }
}

window.onclick = function(event) {
  const modals = document.querySelectorAll('.modal');
  modals.forEach(modal => {
    if (event.target === modal) {
      modal.style.display = 'none';
    }
  });
};

// ===== FORM HANDLING =====
document.getElementById('addSectionForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const sectionName = document.getElementById('sectionName').value;

  const newSection = {
    id: Date.now(),
    name: sectionName,
    studentCount: 0,
    students: []
  };

  sections.push(newSection);
  renderSections();
  closeModal('addSectionModal');
});

// ===== RENDER SECTIONS =====
function renderSections() {
  const grid = document.getElementById('sectionsGrid');
  grid.innerHTML = '';

  const addBtn = document.createElement('div');
  addBtn.className = 'add-section-btn';
  addBtn.onclick = openAddSectionModal;
  addBtn.textContent = '+ Add Section';
  grid.appendChild(addBtn);

  sections.forEach(section => {
    const card = document.createElement('div');
    card.className = 'section-card';
    card.onclick = () => openStudentList(section);

    card.innerHTML = `
      <div class="section-name">${section.name}</div>
      <div class="section-count">${section.studentCount}</div>
      <div class="section-label">students</div>
    `;

    grid.appendChild(card);
  });
}

// ===== NAVIGATION =====
function openStudentList(section) {
  localStorage.setItem('currentSection', JSON.stringify(section));
  localStorage.setItem('allSections', JSON.stringify(sections));
  window.location.href = 'section_students.php';
}

// ===== INIT =====
renderSections();