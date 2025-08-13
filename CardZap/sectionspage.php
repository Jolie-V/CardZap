<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CardZap • Sections</title>
    
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
      
      /* CardZap logo link styling */
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
      
      /* ===== SECTIONS GRID ===== */
      /* Grid layout for section cards (4 columns) */
      .grid { 
        display: grid; 
        grid-template-columns: repeat(4, minmax(140px, 1fr)); 
        gap: 16px; 
        max-width: 880px; 
      }
      
      /* ===== SECTION CARDS ===== */
      /* Individual section card styling */
      .section-card { 
        border: 1px solid #ccc; 
        background: #fafafa; 
        border-radius: 6px; 
        padding: 16px; 
        text-align: center; 
        cursor: pointer; 
        transition: background-color 0.2s; 
      }
      .section-card:hover { 
        background: #f0f0f0; 
      }
      
      /* Section name styling */
      .section-name { 
        font-size: 14px; 
        color: #444; 
        margin: 0 0 8px 0; 
        font-weight: 600; 
      }
      
      /* Section student count styling */
      .section-count { 
        font-size: 36px; 
        color: #2b6777; 
        margin: 0; 
        font-weight: bold; 
      }
      
      /* Section label styling */
      .section-label { 
        font-size: 13px; 
        color: #6d8a96; 
        margin: 0; 
      }
      
      /* ===== ADD SECTION BUTTON ===== */
      /* Dashed border button for adding new sections */
      .add-section-btn { 
        border: 2px dashed #ccc; 
        background: #fafafa; 
        border-radius: 6px; 
        height: 140px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        color: #777; 
        cursor: pointer; 
        transition: background-color 0.2s; 
      }
      .add-section-btn:hover { 
        background: #f0f0f0; 
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
        <!-- CardZap logo/brand -->
        <div><a class="logo-link" href="admin_homepage.php"><strong>CardZap</strong></a></div>
        
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
        <div class="page-title">Sections</div>
      </header>

      <!-- ===== MAIN CONTENT AREA ===== -->
      <main class="content">
        <!-- ===== SECTIONS GRID ===== -->
        <div class="grid" id="sectionsGrid">
          <!-- Add Section button - always appears first -->
          <div class="add-section-btn" onclick="openAddSectionModal()">+ Add Section</div>
        </div>
      </main>

      <!-- ===== ADD SECTION MODAL ===== -->
      <div id="addSectionModal" class="modal">
        <div class="modal-content">
          <!-- Modal header with title and close button -->
          <div class="modal-header">
            <h3>Add New Section</h3>
            <span class="close" onclick="closeModal('addSectionModal')">&times;</span>
          </div>
          
          <!-- Add section form -->
          <form id="addSectionForm">
            <div class="form-group">
              <label for="sectionName">Section Name:</label>
              <input type="text" id="sectionName" required placeholder="e.g., BSN 1A">
            </div>
            <div style="text-align: right;">
              <button type="button" class="modal-btn btn-secondary" onclick="closeModal('addSectionModal')">Cancel</button>
              <button type="submit" class="modal-btn btn-primary">Add Section</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- ===== JAVASCRIPT FUNCTIONALITY ===== -->
    <script>
      // ===== GLOBAL VARIABLES =====
      // Array to store all sections data
      let sections = [];
      // Currently selected section (for future use)
      let currentSection = null;

      // ===== LOGOUT FUNCTIONALITY =====
      // Handle logout button click - redirect to visitor homepage
      const logoutBtn = document.querySelector('.logout-btn');
      if (logoutBtn) {
        logoutBtn.addEventListener('click', () => {
          window.location.href = 'visitor_homepage.php';
        });
      }

      // ===== MODAL FUNCTIONS =====
      // Open the add section modal
      function openAddSectionModal() {
        document.getElementById('addSectionModal').style.display = 'block';
      }

      // Close modal and reset form
      function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
        // Clear form inputs when closing
        if (modalId === 'addSectionModal') {
          document.getElementById('addSectionForm').reset();
        }
      }

      // ===== MODAL EVENT HANDLERS =====
      // Close modal when clicking outside of it
      window.onclick = function(event) {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
          if (event.target === modal) {
            modal.style.display = 'none';
          }
        });
      }

      // ===== FORM SUBMISSION HANDLERS =====
      // Handle add section form submission
      document.getElementById('addSectionForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const sectionName = document.getElementById('sectionName').value;

        // Create new section object
        const newSection = {
          id: Date.now(), // Use timestamp as unique ID
          name: sectionName,
          studentCount: 0, // Start with 0 students
          students: [] // Empty array for students
        };

        // Add to sections array and update display
        sections.push(newSection);
        renderSections();
        closeModal('addSectionModal');
      });

      // ===== RENDERING FUNCTIONS =====
      // Render the sections grid with all section cards
      function renderSections() {
        const grid = document.getElementById('sectionsGrid');
        grid.innerHTML = '';

        // Always add the "Add Section" button first
        const addBtn = document.createElement('div');
        addBtn.className = 'add-section-btn';
        addBtn.onclick = openAddSectionModal;
        addBtn.textContent = '+ Add Section';
        grid.appendChild(addBtn);

        // Add section cards for each section
        sections.forEach(section => {
          const card = document.createElement('div');
          card.className = 'section-card';
          card.onclick = () => openStudentList(section);
          
          // Set card content with section info
          card.innerHTML = `
            <div class="section-name">${section.name}</div>
            <div class="section-count">${section.studentCount}</div>
            <div class="section-label">students</div>
          `;
          
          grid.appendChild(card);
        });
      }

      // ===== NAVIGATION FUNCTIONS =====
      // Navigate to section students page
      function openStudentList(section) {
        // Store section data in localStorage to pass to the students page
        localStorage.setItem('currentSection', JSON.stringify(section));
        localStorage.setItem('allSections', JSON.stringify(sections));
        window.location.href = 'section_students.php';
      }

      // ===== PAGE INITIALIZATION =====
      // Initialize the page by rendering sections
      renderSections();
    </script>
  </body>
</html>


