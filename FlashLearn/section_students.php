<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>FlashLearn • Section Students</title>
    
    <!-- ===== CSS STYLES ===== -->
    <style>
      /* ===== BASE STYLES ===== */
      body { 
        margin: 0; 
        font-family: Arial, sans-serif; 
      }
      
      /* ===== LAYOUT GRID ===== */
      /* Main application grid: sidebar (280px) + main content area */
      .app { 
        display: grid; 
        grid-template-columns: 280px 1fr; 
        grid-template-rows: auto 1fr; 
        min-height: 100vh; 
      }
      
      /* ===== SIDEBAR STYLES ===== */
      /* Left sidebar with navigation */
      .sidebar { 
        grid-column: 1; 
        grid-row: 1 / -1; 
        background: #f0f0f0; 
        padding: 20px; 
        border-right: 1px solid #ccc; 
      }
      
      /* Navigation list styling */
      .nav-list { 
        list-style: none; 
        padding: 0; 
        margin: 0; 
      }
      
      /* Navigation item styling with hover effects */
      .nav-item { 
        padding: 10px 0; 
        text-decoration: none; 
        color: #333; 
        display: block; 
      }
      .nav-item:hover { 
        background: #ddd; 
        padding-left: 10px; 
      }
      .nav-item.active { 
        background: #ddd; 
        padding-left: 10px; 
      }
      
      /* Logout button styling */
      .logout-btn { 
        margin-top: 20px; 
        width: 100%; 
        padding: 10px; 
        background: #dc3545; 
        color: white; 
        border: none; 
        cursor: pointer; 
      }
      
      /* FlashLearn logo link styling */
      .logo-link { 
        color: inherit; 
        text-decoration: none; 
      }
      
      /* ===== TOPBAR STYLES ===== */
      /* Header bar with page title */
      .topbar { 
        grid-column: 2; 
        grid-row: 1; 
        background: #e0e0e0; 
        padding: 16px 24px; 
        border-bottom: 1px solid #ccc; 
      }
      
      .page-title { 
        font-size: 24px; 
        font-weight: bold; 
      }
      
      /* ===== MAIN CONTENT AREA ===== */
      /* Right side content area */
      .content { 
        grid-column: 2; 
        grid-row: 2; 
        padding: 24px; 
        display: grid; 
        gap: 16px; 
        align-content: start; 
        background: #fff; 
      }
      
      /* ===== STUDENT TABLE ===== */
      /* Table container card */
      .student-table { 
        border: 1px solid #ccc; 
        background: #fafafa; 
        border-radius: 6px; 
        overflow: hidden; 
      }
      
      /* Table styling */
      table { 
        width: 100%; 
        border-collapse: collapse; 
      }
      
      /* Table header styling */
      thead { 
        background: #eef6f6; 
      }
      
      /* Table cell styling */
      th, td { 
        padding: 12px 16px; 
        border-bottom: 1px solid #e5e5e5; 
        text-align: left; 
        font-size: 14px; 
      }
      
      /* Narrow columns for actions */
      th.small { 
        width: 100px; 
      }
      
      /* ===== STUDENT AVATARS ===== */
      /* Colored square avatars for students */
      .student-avatar { 
        width: 30px; 
        height: 30px; 
        border-radius: 4px; 
        background: linear-gradient(45deg, #3498db, #2ecc71); 
      }
      
      /* ===== BUTTON STYLES ===== */
      /* Small action buttons */
      .btn-small { 
        padding: 5px 10px; 
        font-size: 12px; 
        border: none; 
        border-radius: 3px; 
        cursor: pointer; 
        margin: 2px; 
      }
      .btn-profile { 
        background-color: #17a2b8; 
        color: white; 
      }
      .btn-delete { 
        background-color: #dc3545; 
        color: white; 
      }
      
      /* Add student button */
      .btn-add-student { 
        background-color: #28a745; 
        color: white; 
        padding: 8px 16px; 
        border: none; 
        border-radius: 4px; 
        cursor: pointer; 
        margin-bottom: 16px; 
      }
      
      /* ===== EMPTY STATE ===== */
      /* Message shown when no students exist */
      .empty-hint { 
        padding: 12px 16px; 
        color: #777; 
        font-size: 14px; 
        text-align: center; 
      }
      
      /* ===== MODAL STYLES ===== */
      /* Modal overlay */
      .modal { 
        display: none; 
        position: fixed; 
        z-index: 1000; 
        left: 0; 
        top: 0; 
        width: 100%; 
        height: 100%; 
        background-color: rgba(0,0,0,0.5); 
      }
      
      /* Modal content container */
      .modal-content { 
        background-color: #fefefe; 
        margin: 15% auto; 
        padding: 20px; 
        border: 1px solid #888; 
        width: 300px; 
        border-radius: 8px; 
      }
      
      /* Modal header with title and close button */
      .modal-header { 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        margin-bottom: 20px; 
      }
      
      /* Close button styling */
      .close { 
        color: #aaa; 
        font-size: 28px; 
        font-weight: bold; 
        cursor: pointer; 
      }
      .close:hover { 
        color: #000; 
      }
      
      /* ===== FORM STYLES ===== */
      /* Form group container */
      .form-group { 
        margin-bottom: 15px; 
      }
      
      /* Form label styling */
      .form-group label { 
        display: block; 
        margin-bottom: 5px; 
        font-weight: bold; 
      }
      
      /* Form input styling */
      .form-group input { 
        width: 100%; 
        padding: 8px; 
        border: 1px solid #ccc; 
        border-radius: 4px; 
        box-sizing: border-box; 
      }
      
      /* Modal button styling */
      .modal-btn { 
        padding: 10px 20px; 
        margin: 5px; 
        border: none; 
        border-radius: 4px; 
        cursor: pointer; 
      }
      .btn-primary { 
        background-color: #007bff; 
        color: white; 
      }
      .btn-secondary { 
        background-color: #6c757d; 
        color: white; 
      }
    </style>
  </head>
  
  <body>
    <!-- ===== MAIN APPLICATION CONTAINER ===== -->
    <div class="app">
      
      <!-- ===== LEFT SIDEBAR ===== -->
      <aside class="sidebar">
        <!-- FlashLearn logo/brand -->
        <div><a class="logo-link" href="admin_homepage.php"><strong>FlashLearn</strong></a></div>
        
        <!-- Navigation menu -->
        <nav>
          <ul class="nav-list">
            <li><a class="nav-item" href="admin_homepage.php">Dashboard</a></li>
            <li><a class="nav-item" href="studentspage.php">Students</a></li>
            <li><a class="nav-item active" href="sectionspage.php">Sections</a></li>
          </ul>
        </nav>
        
        <!-- Logout button -->
        <button class="logout-btn">Log out</button>
      </aside>

      <!-- ===== TOP HEADER BAR ===== -->
      <header class="topbar">
        <div class="page-title" id="sectionTitle">Section Students</div>
      </header>

      <!-- ===== MAIN CONTENT AREA ===== -->
      <main class="content">
        <!-- ===== ADD STUDENT BUTTON ===== -->
        <button class="btn-add-student" onclick="openAddStudentModal()">+ Add Student</button>
        
        <!-- ===== STUDENT TABLE ===== -->
        <div class="student-table">
          <table>
            <!-- Table header with column names -->
            <thead>
              <tr>
                <th>NAME</th>
                <th class="small">ACTIONS</th>
              </tr>
            </thead>
            <!-- Table body for student data -->
            <tbody id="studentTableBody">
              <!-- Student rows will be populated here -->
            </tbody>
          </table>
          <!-- Empty state message -->
          <div id="emptyMessage" class="empty-hint" style="display: none;">No students in this section yet.</div>
        </div>
      </main>

      <!-- ===== ADD STUDENT MODAL ===== -->
      <div id="addStudentModal" class="modal">
        <div class="modal-content">
          <!-- Modal header with title and close button -->
          <div class="modal-header">
            <h3>Add Student to Section</h3>
            <span class="close" onclick="closeModal()">&times;</span>
          </div>
          
          <!-- Add student form -->
          <form id="addStudentForm">
            <div class="form-group">
              <label for="studentName">Student Name:</label>
              <input type="text" id="studentName" required placeholder="Enter student name">
            </div>
            <div style="text-align: right;">
              <button type="button" class="modal-btn btn-secondary" onclick="closeModal()">Cancel</button>
              <button type="submit" class="modal-btn btn-primary">Add Student</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- ===== JAVASCRIPT FUNCTIONALITY ===== -->
    <script>
      // ===== GLOBAL VARIABLES =====
      // Currently selected section data
      let currentSection = null;
      // Array of all sections (for data synchronization)
      let allSections = [];

      // ===== PAGE INITIALIZATION =====
      // Load section data from localStorage when page loads
      window.onload = function() {
        const sectionData = localStorage.getItem('currentSection');
        const sectionsData = localStorage.getItem('allSections');
        
        if (sectionData && sectionsData) {
          // Parse and set the current section and all sections data
          currentSection = JSON.parse(sectionData);
          allSections = JSON.parse(sectionsData);
          
          // Update page title with section name
          document.getElementById('sectionTitle').textContent = currentSection.name;
          renderStudentTable();
        } else {
          // If no data found, redirect back to sections page
          window.location.href = 'sectionspage.php';
        }
      };

      // ===== LOGOUT FUNCTIONALITY =====
      // Handle logout button click - redirect to visitor homepage
      const logoutBtn = document.querySelector('.logout-btn');
      if (logoutBtn) {
        logoutBtn.addEventListener('click', () => {
          window.location.href = 'visitor_homepage.php';
        });
      }

      // ===== MODAL FUNCTIONS =====
      // Open the add student modal
      function openAddStudentModal() {
        document.getElementById('addStudentModal').style.display = 'block';
      }

      // Close modal and reset form
      function closeModal() {
        document.getElementById('addStudentModal').style.display = 'none';
        document.getElementById('addStudentForm').reset();
      }

      // ===== MODAL EVENT HANDLERS =====
      // Close modal when clicking outside of it
      window.onclick = function(event) {
        const modal = document.getElementById('addStudentModal');
        if (event.target === modal) {
          closeModal();
        }
      }

      // ===== FORM SUBMISSION HANDLERS =====
      // Handle add student form submission
      document.getElementById('addStudentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const studentName = document.getElementById('studentName').value;

        if (currentSection) {
          // Create new student object
          const newStudent = {
            id: Date.now(), // Use timestamp as unique ID
            name: studentName
          };

          // Add student to current section
          currentSection.students.push(newStudent);
          currentSection.studentCount = currentSection.students.length;
          
          // Update the section in the allSections array
          const sectionIndex = allSections.findIndex(s => s.id === currentSection.id);
          if (sectionIndex !== -1) {
            allSections[sectionIndex] = currentSection;
          }

          // Update localStorage with new data
          localStorage.setItem('currentSection', JSON.stringify(currentSection));
          localStorage.setItem('allSections', JSON.stringify(allSections));

          // Refresh the table display
          renderStudentTable();
          closeModal();
        }
      });

      // ===== RENDERING FUNCTIONS =====
      // Render the student table with current section's students
      function renderStudentTable() {
        const tableBody = document.getElementById('studentTableBody');
        const emptyMessage = document.getElementById('emptyMessage');
        
        tableBody.innerHTML = '';

        if (currentSection && currentSection.students.length > 0) {
          // Create table rows for each student
          currentSection.students.forEach(student => {
            const row = document.createElement('tr');
            
            // Set row content with student info and action buttons
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
          // Show empty state message
          emptyMessage.style.display = 'block';
        }
      }

      // ===== STUDENT MANAGEMENT FUNCTIONS =====
      // View student profile (placeholder function)
      function viewProfile(studentName) {
        alert(`Viewing profile for ${studentName}`);
        // This would typically open a profile modal or navigate to a profile page
      }

      // Delete student from section
      function deleteStudent(studentId) {
        if (confirm('Are you sure you want to delete this student from the section?')) {
          // Remove student from current section
          currentSection.students = currentSection.students.filter(s => s.id !== studentId);
          currentSection.studentCount = currentSection.students.length;
          
          // Update the section in the allSections array
          const sectionIndex = allSections.findIndex(s => s.id === currentSection.id);
          if (sectionIndex !== -1) {
            allSections[sectionIndex] = currentSection;
          }

          // Update localStorage with modified data
          localStorage.setItem('currentSection', JSON.stringify(currentSection));
          localStorage.setItem('allSections', JSON.stringify(allSections));

          // Refresh the table display
          renderStudentTable();
        }
      }
    </script>
  </body>
</html>
