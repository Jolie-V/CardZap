<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CardZap • Section Students</title>
    
    <!-- External CSS -->
    <link rel="stylesheet" href="../css/section_students.css">
  </head>
  
  <body>
    <!-- ===== MAIN APPLICATION CONTAINER ===== -->
    <div class="app">
      
      <!-- ===== LEFT SIDEBAR ===== -->
      <aside class="sidebar">
        <div><a class="logo-link" href="admin_homepage.php"><strong>CardZap</strong></a></div>
        
        <nav>
          <ul class="nav-list">
            <li><a class="nav-item" href="admin_homepage.php">Dashboard</a></li>
            <li><a class="nav-item" href="studentspage.php">Students</a></li>
            <li><a class="nav-item active" href="sectionspage.php">Sections</a></li>
          </ul>
        </nav>
        
        <button class="logout-btn">Log out</button>
      </aside>

      <!-- ===== TOP HEADER BAR ===== -->
      <header class="topbar">
        <div class="page-title" id="sectionTitle">Section Students</div>
      </header>

      <!-- ===== MAIN CONTENT AREA ===== -->
      <main class="content">
        <button class="btn-add-student" onclick="openAddStudentModal()">+ Add Student</button>
        
        <div class="student-table">
          <table>
            <thead>
              <tr>
                <th>NAME</th>
                <th class="small">ACTIONS</th>
              </tr>
            </thead>
            <tbody id="studentTableBody"></tbody>
          </table>
          <div id="emptyMessage" class="empty-hint" style="display: none;">No students in this section yet.</div>
        </div>
      </main>

      <!-- ===== ADD STUDENT MODAL ===== -->
      <div id="addStudentModal" class="modal">
        <div class="modal-content">
          <div class="modal-header">
            <h3>Add Student to Section</h3>
            <span class="close" onclick="closeModal()">&times;</span>
          </div>
          
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

    <!-- External JS -->
    <script src="../javascript/section_students.js"></script>
  </body>
</html>
