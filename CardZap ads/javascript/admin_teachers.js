// Logout
const logoutBtn = document.querySelector('.logout-btn');
if (logoutBtn) logoutBtn.addEventListener('click', () => window.location.href = 'visitor_homepage.php');

// Seed data to mirror the mock
let registrationRequests = [ { id: 1, name: 'Juan Jose Imperial' } ];
let registeredTeachers = [
  { id: 2, name: 'Maria Lopez' },
  { id: 3, name: 'Josh Lim' }
];

function render() {
  const requests = document.getElementById('requestsList');
  const regs = document.getElementById('registeredList');
  requests.innerHTML = '';
  regs.innerHTML = '';

  // Requests
  registrationRequests.forEach(t => {
    const row = document.createElement('div');
    row.className = 'row';
    row.innerHTML = `
      <div class="avatar"></div>
      <div class="name">${t.name}</div>
    `;
    const accept = document.createElement('button');
    accept.className = 'btn btn-accept';
    accept.textContent = 'Accept';
    accept.onclick = () => { registeredTeachers.push(t); registrationRequests = registrationRequests.filter(x => x.id !== t.id); render(); };
    const remove = document.createElement('button');
    remove.className = 'btn btn-remove';
    remove.textContent = 'Remove';
    remove.onclick = () => { registrationRequests = registrationRequests.filter(x => x.id !== t.id); render(); };
    row.appendChild(accept);
    row.appendChild(remove);
    requests.appendChild(row);
  });

  // Registered
  registeredTeachers.forEach(t => {
    const row = document.createElement('div');
    row.className = 'row';
    row.innerHTML = `
      <div class="avatar"></div>
      <div class="name">${t.name}</div>
    `;
    const profile = document.createElement('button');
    profile.className = 'btn btn-profile';
    profile.textContent = 'Profile';
    profile.onclick = () => alert('Show profile for ' + t.name);
    const remove = document.createElement('button');
    remove.className = 'btn btn-remove';
    remove.textContent = 'Remove';
    remove.onclick = () => { registeredTeachers = registeredTeachers.filter(x => x.id !== t.id); render(); };
    row.appendChild(profile);
    row.appendChild(remove);
    regs.appendChild(row);
  });
}

// Search (simple front-end filter demonstration)
document.getElementById('teacherSearchBtn').addEventListener('click', () => {
  const q = (document.getElementById('teacherSearch').value || '').toLowerCase();
  const filter = (name) => name.toLowerCase().includes(q);
  const r1 = registrationRequests.filter(t => filter(t.name));
  const r2 = registeredTeachers.filter(t => filter(t.name));
  const save1 = registrationRequests, save2 = registeredTeachers;
  registrationRequests = r1; registeredTeachers = r2; render();
  registrationRequests = save1; registeredTeachers = save2;
});

render();


