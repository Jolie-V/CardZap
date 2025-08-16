let currentSection = null;
let allSections = [];

// ===== INITIALIZATION =====
window.onload = function() {
  const sectionData = localStorage.getItem('currentSection');
  const sectionsData = localStorage.getItem('allSections');

  if (sectionData && sectionsData) {
    currentSection = JSON.parse(sectionData);
    allSections = JSON.parse(sectionsData);
    document.getElementById('sectionTitle').textContent = currentSection.name;
    renderStudentTable();
  } else {
    window.location.href = 'sectionspage.php';
  }
};

// ===== LOGOUT =====
document.querySelector('.logout-btn').addEventListener('click', () => {
  window.location.href = 'visitor_homepage.php';
});

// ===== MODAL =====
function openAddStudentModal() {
  document.getElementById('addStudentModal').style.display = 'block';
}
function closeModal() {
  document.getElementById('addStudentModal').style.display = 'none';
  document.getElementById('addStudentForm').reset();
}
window.onclick = function(event) {
  const modal = document.getElementById('addStudentModal');
  if (event.target === modal) closeModal();
};

// ===== FORM SUBMIT =====
document.getElementById('addStudentForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const studentName = document.getElementById('studentName').value;

  if (currentSection) {
    const newStudent = { id: Date.now(), name: studentName };
    currentSection.students.push(newStudent);
    currentSection.studentCount = currentSection.students.length;

    const sectionIndex = allSections.findIndex(s => s.id === currentSection.id);
    if (sectionIndex !== -1) allSections[sectionIndex] = currentSection;

    localStorage.setItem('currentSection', JSON.stringify(currentSection));
    localStorage.setItem('allSections', JSON.stringify(allSections));

    renderStudentTable();
    closeModal();
  }
});

// ===== RENDER STUDENT TABLE =====
function renderStudentTable() {
  const tableBody = document.getElementById('studentTableBody');
  const emptyMessage = document.getElementById('emptyMessage');
  tableBody.innerHTML = '';

  if (currentSection && currentSection.students.length > 0) {
    currentSection.students.forEach(student => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>
          <div style="display: flex; align-items: center;">
            <div class="student-avatar" style="margin-right: 10px;"></div>
            ${student.name}
          </div>
        </td>
        <td>
          <button class="btn-small btn-profile" onclick="viewProfile('${student.name}')">Profile</button>
          <button class="btn-small btn-delete" onclick="deleteStudent(${student.id})">Delete</button>
        </td>
      `;
      tableBody.appendChild(row);
    });
    emptyMessage.style.display = 'none';
  } else {
    emptyMessage.style.display = 'block';
  }
}

// ===== STUDENT ACTIONS =====
function viewProfile(studentName) {
  alert(`Viewing profile for ${studentName}`);
}
function deleteStudent(studentId) {
  if (confirm('Are you sure you want to delete this student from the section?')) {
    currentSection.students = currentSection.students.filter(s => s.id !== studentId);
    currentSection.studentCount = currentSection.students.length;

    const sectionIndex = allSections.findIndex(s => s.id === currentSection.id);
    if (sectionIndex !== -1) allSections[sectionIndex] = currentSection;

    localStorage.setItem('currentSection', JSON.stringify(currentSection));
    localStorage.setItem('allSections', JSON.stringify(allSections));

    renderStudentTable();
  }
}