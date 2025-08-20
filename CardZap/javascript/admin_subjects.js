// ===== GLOBAL VARIABLES =====
let subjects = [];

// ===== LOGOUT =====
const logoutBtn = document.querySelector('.logout-btn');
if (logoutBtn) {
  logoutBtn.addEventListener('click', () => {
    window.location.href = 'visitor_homepage.php';
  });
}

// ===== RENDER SUBJECTS =====
function renderSubjects() {
  const grid = document.getElementById('subjectsGrid');
  grid.innerHTML = '';

  subjects.forEach(subject => {
    const card = document.createElement('div');
    card.className = 'subject-card';

    const del = document.createElement('div');
    del.className = 'delete-pill';
    del.title = 'Delete subject';
    del.textContent = '🗑';
    del.onclick = (ev) => { ev.stopPropagation(); deleteSubject(subject.id); };
    card.appendChild(del);

    const banner = document.createElement('div');
    banner.className = 'subject-banner';
    card.appendChild(banner);

    const body = document.createElement('div');
    body.className = 'subject-body';
    body.innerHTML = `
      <div class="subject-name">${subject.name}</div>
      <div class="subject-sub">${subject.studentCount} students</div>
    `;
    card.appendChild(body);

    grid.appendChild(card);
  });
}

function deleteSubject(id) {
  subjects = subjects.filter(s => s.id !== id);
  renderSubjects();
}

// ===== INIT =====
// Seed with a sample subject to mirror the mock
subjects = [{ id: 1, name: 'Subject Name', studentCount: 0 }];
renderSubjects();