<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CardZap • Sections</title>
    <link rel="stylesheet" href="../css/sectionspage.css" />
  </head>
  
  <body>
    <div class="app">
      
      <!-- ===== SIDEBAR ===== -->
      <aside class="sidebar">
        <div>
          <a class="logo-link" href="admin_homepage.php"><strong>CardZap</strong></a>
        </div>

        <nav>
          <ul class="nav-list">
            <li><a class="nav-item" href="admin_homepage.php">Dashboard</a></li>
            <li><a class="nav-item" href="studentspage.php">Students</a></li>
            <li><a class="nav-item active" href="sectionspage.php">Sections</a></li>
          </ul>
        </nav>

        <button class="logout-btn">Log out</button>
      </aside>

      <!-- ===== TOPBAR ===== -->
      <header class="topbar">
        <div class="page-title">Sections</div>
      </header>

      <!-- ===== MAIN CONTENT ===== -->
      <main class="content">
        <div class="grid" id="sectionsGrid">
          <div class="add-section-btn" onclick="openAddSectionModal()">+ Add Section</div>
        </div>
      </main>

      <!-- ===== ADD SECTION MODAL ===== -->
      <div id="addSectionModal" class="modal">
        <div class="modal-content">
          <div class="modal-header">
            <h3>Add New Section</h3>
            <span class="close" onclick="closeModal('addSectionModal')">&times;</span>
          </div>
          
          <form id="addSectionForm">
            <div class="form-group">
              <label for="sectionName">Section Name:</label>
              <input type="text" id="sectionName" required placeholder="e.g., BSN 1A">
            </div>
            <div class="modal-actions">
              <button type="button" class="modal-btn btn-secondary" onclick="closeModal('addSectionModal')">Cancel</button>
              <button type="submit" class="modal-btn btn-primary">Add Section</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script src="../javascript/sectionspage.js"></script>
  </body>
</html>