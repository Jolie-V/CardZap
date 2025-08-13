<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>FlashLearn • Your Cards</title>
    <style>
      body {
        margin: 0;
        font-family: Arial, sans-serif;
      }
      
      .app {
        display: grid;
        grid-template-columns: 280px 1fr;
        grid-template-rows: auto 1fr;
        min-height: 100vh;
      }
      
      .sidebar {
        grid-column: 1;
        grid-row: 1 / -1;
        background: #f0f0f0;
        padding: 20px;
        border-right: 1px solid #ccc;
      }
      
      .topbar {
        grid-column: 2;
        grid-row: 1;
        background: #e0e0e0;
        padding: 16px 24px;
        border-bottom: 1px solid #ccc;
      }
      
      .content {
        grid-column: 2;
        grid-row: 2;
        padding: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
      }
      
      .add-card {
        width: 280px;
        height: 210px;
        border: 2px dashed #999;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 64px;
        color: #999;
        background: white;
        cursor: pointer;
      }
      
      .nav-list {
        list-style: none;
        padding: 0;
        margin: 0;
      }
      
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
      
      .logout-btn {
        margin-top: 20px;
        width: 100%;
        padding: 10px;
        background: #dc3545;
        color: white;
        border: none;
        cursor: pointer;
      }
      
      .page-title {
        font-size: 24px;
        font-weight: bold;
      }
      
      .notification-container {
        position: relative;
        float: right;
      }
      
      .notification-btn {
        padding: 8px 16px;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
      }
      
      .notification-popup {
        position: absolute;
        top: 100%;
        right: 0;
        margin-top: 8px;
        background: white;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        min-width: 250px;
        z-index: 1000;
        display: none;
      }
      
      .notification-popup.show {
        display: block;
      }
      
      .notification-header {
        padding: 16px 20px;
        border-bottom: 1px solid #ccc;
        font-weight: bold;
        color: #333;
      }
      
      .notification-content {
        padding: 20px;
        color: #666;
        text-align: center;
      }
      
      /* Popup styles */
      .popup-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        z-index: 2000;
        align-items: center;
        justify-content: center;
      }
      
      .popup-overlay.show {
        display: flex;
      }
      
      .popup {
        background: white;
        border-radius: 8px;
        padding: 32px;
        max-width: 500px;
        width: 90%;
        max-height: 80vh;
        overflow-y: auto;
      }
      
      .popup-title {
        font-size: 24px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 24px;
        color: #333;
      }
      
      .form-group {
        margin-bottom: 20px;
      }
      
      .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #333;
      }
      
      .form-input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
        box-sizing: border-box;
      }
      
      .form-input:focus {
        outline: none;
        border-color: #007bff;
      }
      
      .checkbox-group {
        margin-bottom: 16px;
      }
      
      .checkbox-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 12px;
      }
      
      .checkbox-item input[type="checkbox"] {
        margin-right: 12px;
        margin-top: 2px;
      }
      
      .checkbox-label {
        color: #333;
      }
      
      .checkbox-sublabel {
        display: block;
        font-size: 14px;
        color: #666;
        margin-top: 4px;
      }
      
      .next-btn {
        width: 100%;
        padding: 12px;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        margin-top: 16px;
      }
      
      .next-btn:hover {
        background: #0056b3;
      }
      
      .next-btn:disabled {
        background: #ccc;
        cursor: not-allowed;
      }
      
      /* Step 2: Text Input */
      .text-input-area {
        width: 100%;
        min-height: 200px;
        padding: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
        font-family: Arial, sans-serif;
        resize: vertical;
        box-sizing: border-box;
      }
      
      .text-input-area:focus {
        outline: none;
        border-color: #007bff;
      }
      
      .create-btn {
        width: 100%;
        padding: 12px;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        margin-top: 16px;
      }
      
      .create-btn:hover {
        background: #0056b3;
      }
      
      /* Step 2: File Upload */
      .file-upload-area {
        border: 2px dashed #ccc;
        border-radius: 8px;
        padding: 32px;
        text-align: center;
        background: #f8f9fa;
      }
      
      .file-input-container {
        display: flex;
        gap: 12px;
        margin-bottom: 16px;
      }
      
      .file-input {
        flex: 1;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background: white;
      }
      
      .browse-btn {
        padding: 12px 24px;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        white-space: nowrap;
      }
      
      .browse-btn:hover {
        background: #0056b3;
      }
      
      /* Deck display styles */
      .decks-container {
        display: flex;
        flex-wrap: wrap;
        gap: 24px;
        justify-content: flex-start;
        align-items: flex-start;
        width: 100%;
        max-width: 1200px;
      }
      
      .deck-card {
        width: 280px;
        height: 210px;
        background: white;
        border: 1px solid #ccc;
        border-radius: 8px;
        position: relative;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
      }
      
      .deck-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      }
      
      .deck-stack {
        position: relative;
        width: 100%;
        height: 140px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border-radius: 8px 8px 0 0;
      }
      
      .deck-card-top {
        position: absolute;
        width: 200px;
        height: 120px;
        background: #ff8c00;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 16px;
        text-align: center;
        padding: 16px;
        box-sizing: border-box;
        z-index: 3;
      }
      
      .deck-card-middle {
        position: absolute;
        width: 200px;
        height: 120px;
        background: #e6e6e6;
        border-radius: 8px;
        transform: translateY(2px);
        z-index: 2;
      }
      
      .deck-card-bottom {
        position: absolute;
        width: 200px;
        height: 120px;
        background: #d4d4d4;
        border-radius: 8px;
        transform: translateY(4px);
        z-index: 1;
      }
      
      .deck-info {
        padding: 16px;
        text-align: center;
      }
      
      .deck-title {
        font-weight: bold;
        color: #333;
        margin: 0 0 4px 0;
        font-size: 16px;
      }
      
      .deck-details {
        color: #666;
        font-size: 14px;
        margin: 0;
      }
      
      /* Context menu styles */
      .context-menu {
        position: fixed;
        background: white;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        z-index: 3000;
        display: none;
        min-width: 150px;
      }
      
      .context-menu.show {
        display: block;
      }
      
      .context-menu-item {
        padding: 12px 16px;
        cursor: pointer;
        border-bottom: 1px solid #eee;
        color: #333;
      }
      
      .context-menu-item:last-child {
        border-bottom: none;
      }
      
      .context-menu-item:hover {
        background: #f8f9fa;
      }
      
      .context-menu-item.delete {
        color: #dc3545;
      }
      
      .context-menu-item.delete:hover {
        background: #f8d7da;
      }
      
      /* Edit deck popup styles */
      .edit-popup {
        background: white;
        border-radius: 8px;
        padding: 32px;
        max-width: 500px;
        width: 90%;
        max-height: 80vh;
        overflow-y: auto;
      }
      
      .edit-popup-title {
        font-size: 24px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 24px;
        color: #333;
      }
      
      .save-btn {
        width: 100%;
        padding: 12px;
        background: #28a745;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        margin-top: 16px;
      }
      
      .save-btn:hover {
        background: #218838;
      }
    </style>
  </head>
  <body>
    <div class="app">
      <!-- Sidebar -->
      <aside class="sidebar">
        <div>
          <strong>FlashLearn</strong>
        </div>
        <nav>
          <ul class="nav-list">
            <li><a class="nav-item" href="profilepage.php">Profile</a></li>
            <li><a class="nav-item" href="friendspage.php">Friends</a></li>
            <li><a class="nav-item active" href="yourcardspage.php">Your Cards</a></li>
            <li><a class="nav-item" href="recentpage.php">Recent</a></li>
            <li><a class="nav-item" href="settingspage.php">Settings</a></li>
          </ul>
        </nav>
        <button class="logout-btn">Log out</button>
      </aside>

      <!-- Header -->
      <header class="topbar">
        <div class="page-title">Your Cards</div>
        <div class="notification-container">
          <button class="notification-btn">🔔</button>
          <div class="notification-popup">
            <div class="notification-header">Notifications</div>
            <div class="notification-content">No new notifications.</div>
          </div>
        </div>
      </header>

      <!-- Main content -->
      <main class="content">
        <div class="decks-container" id="decksContainer">
          <!-- Sample deck (will be removed when real decks are added) -->
          <div class="deck-card" data-deck-id="sample">
            <div class="deck-stack">
              <div class="deck-card-top">Sample question</div>
              <div class="deck-card-middle"></div>
              <div class="deck-card-bottom"></div>
            </div>
            <div class="deck-info">
              <div class="deck-title">Title of deck</div>
              <div class="deck-details">Subject • Classic • Created May 5</div>
            </div>
          </div>
          
          <!-- Add New Card Button -->
          <button class="add-card">+</button>
        </div>
      </main>
    </div>

    <!-- Context Menu -->
    <div class="context-menu" id="contextMenu">
      <div class="context-menu-item" id="editDeck">Edit Deck</div>
      <div class="context-menu-item delete" id="deleteDeck">Delete Deck</div>
    </div>

    <!-- Popup Overlay -->
    <div class="popup-overlay" id="popupOverlay">
      <div class="popup">
        <!-- Step 1: Add New Deck Form -->
        <div id="step1">
          <h2 class="popup-title">Add New Deck</h2>
          
          <div class="form-group">
            <label class="form-label">Subject Name</label>
            <input type="text" class="form-input" id="subjectName" placeholder="Enter subject name">
          </div>
          
          <div class="form-group">
            <label class="form-label">Reading Material</label>
            <div class="checkbox-group">
              <div class="checkbox-item">
                <input type="checkbox" id="textCheckbox" name="readingMaterial" value="text">
                <div>
                  <label class="checkbox-label" for="textCheckbox">Text</label>
                  <div class="checkbox-sublabel">Maximum of 10,000 characters</div>
                </div>
              </div>
              <div class="checkbox-item">
                <input type="checkbox" id="fileCheckbox" name="readingMaterial" value="file">
                <div>
                  <label class="checkbox-label" for="fileCheckbox">File Upload</label>
                  <div class="checkbox-sublabel">Maximum of 25MB</div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label class="form-label">Number of Cards</label>
            <input type="number" class="form-input" id="cardCount" min="1" placeholder="Enter number of cards">
          </div>
          
          <div class="form-group">
            <label class="form-label">Card Color</label>
            <select class="form-input" id="cardColor">
              <option value="blue">Blue</option>
              <option value="green">Green</option>
              <option value="red">Red</option>
              <option value="yellow">Yellow</option>
              <option value="purple">Purple</option>
            </select>
          </div>
          
          <button class="next-btn" id="nextBtn" disabled>Next</button>
        </div>

                 <!-- Step 2: Text Input -->
         <div id="step2" style="display: none;">
           <h2 class="popup-title">Paste Text</h2>
           <textarea class="text-input-area" id="textInput" placeholder="Value"></textarea>
           <button class="next-btn" id="nextTextBtn">Next</button>
         </div>

         <!-- Step 2: File Upload -->
         <div id="step3" style="display: none;">
           <h2 class="popup-title">Upload your file!</h2>
           <div class="file-upload-area">
             <div class="file-input-container">
               <input type="text" class="file-input" id="fileDisplay" placeholder="Choose File" readonly>
               <button class="browse-btn" id="browseBtn">Browse...</button>
             </div>
             <input type="file" id="fileInput" style="display: none;" accept=".txt,.pdf,.doc,.docx">
           </div>
           <button class="next-btn" id="nextFileBtn">Next</button>
         </div>

         <!-- Step 3: Questioning Type Selection -->
         <div id="step4" style="display: none;">
           <h2 class="popup-title">Choose Questioning Type</h2>
           
           <div class="checkbox-group">
             <div class="checkbox-item">
               <input type="checkbox" id="classicCheckbox" name="questioningType" value="classic">
               <div>
                 <label class="checkbox-label" for="classicCheckbox">Classic</label>
               </div>
             </div>
             <div class="checkbox-item">
               <input type="checkbox" id="quizCheckbox" name="questioningType" value="quiz">
               <div>
                 <label class="checkbox-label" for="quizCheckbox">Quiz</label>
               </div>
             </div>
           </div>
           
           <button class="create-btn" id="createDeckBtn" disabled>Create</button>
         </div>
        </div>
      </div>

     <!-- Edit Deck Popup Overlay -->
     <div class="popup-overlay" id="editPopupOverlay">
       <div class="edit-popup">
         <h2 class="edit-popup-title">Edit Deck</h2>
         
         <div class="form-group">
           <label class="form-label">Subject Name</label>
           <input type="text" class="form-input" id="editSubjectName" placeholder="Enter subject name">
         </div>
         
         <div class="form-group">
           <label class="form-label">Number of Cards</label>
           <input type="number" class="form-input" id="editCardCount" min="1" placeholder="Enter number of cards">
         </div>
         
         <div class="form-group">
           <label class="form-label">Card Color</label>
           <select class="form-input" id="editCardColor">
             <option value="">Select a color</option>
             <option value="blue">Blue</option>
             <option value="green">Green</option>
             <option value="red">Red</option>
             <option value="yellow">Yellow</option>
             <option value="purple">Purple</option>
           </select>
         </div>
         
         <button class="save-btn" id="saveEditBtn">Save Changes</button>
       </div>
     </div>

    <script>
      const logoutBtn = document.querySelector('.logout-btn');
      if (logoutBtn) {
        logoutBtn.addEventListener('click', () => {
          window.location.href = 'visitor_homepage.php';
        });
      }

      // Notification popup functionality
      const notificationBtn = document.querySelector('.notification-btn');
      const notificationPopup = document.querySelector('.notification-popup');

      if (notificationBtn && notificationPopup) {
        notificationBtn.addEventListener('click', () => {
          notificationPopup.classList.toggle('show');
        });
      }

             // Popup functionality
       const addCardBtn = document.querySelector('.add-card');
       const popupOverlay = document.getElementById('popupOverlay');
       const nextBtn = document.getElementById('nextBtn');
       const textCheckbox = document.getElementById('textCheckbox');
       const fileCheckbox = document.getElementById('fileCheckbox');
       const step1 = document.getElementById('step1');
       const step2 = document.getElementById('step2');
       const step3 = document.getElementById('step3');
       const step4 = document.getElementById('step4');
       const browseBtn = document.getElementById('browseBtn');
       const fileInput = document.getElementById('fileInput');
       const fileDisplay = document.getElementById('fileDisplay');
       const classicCheckbox = document.getElementById('classicCheckbox');
       const quizCheckbox = document.getElementById('quizCheckbox');

      // Open popup when clicking the add card button
      addCardBtn.addEventListener('click', () => {
        popupOverlay.classList.add('show');
        resetForm();
      });

      // Close popup when clicking outside
      popupOverlay.addEventListener('click', (e) => {
        if (e.target === popupOverlay) {
          popupOverlay.classList.remove('show');
          resetForm();
        }
      });

      // Handle checkbox selection (only one can be selected)
      textCheckbox.addEventListener('change', () => {
        if (textCheckbox.checked) {
          fileCheckbox.checked = false;
        }
        updateNextButton();
      });

      fileCheckbox.addEventListener('change', () => {
        if (fileCheckbox.checked) {
          textCheckbox.checked = false;
        }
        updateNextButton();
      });

             // Handle next button click
       nextBtn.addEventListener('click', () => {
         if (textCheckbox.checked) {
           step1.style.display = 'none';
           step2.style.display = 'block';
         } else if (fileCheckbox.checked) {
           step1.style.display = 'none';
           step3.style.display = 'block';
         }
       });

       // Handle next buttons for text and file steps
       document.getElementById('nextTextBtn').addEventListener('click', () => {
         step2.style.display = 'none';
         step4.style.display = 'block';
       });

       document.getElementById('nextFileBtn').addEventListener('click', () => {
         step3.style.display = 'none';
         step4.style.display = 'block';
       });

       // Handle file browse button
       browseBtn.addEventListener('click', () => {
         fileInput.click();
       });

       // Handle file selection
       fileInput.addEventListener('change', (e) => {
         if (e.target.files.length > 0) {
           fileDisplay.value = e.target.files[0].name;
         }
       });

       // Handle questioning type selection
       classicCheckbox.addEventListener('change', () => {
         if (classicCheckbox.checked) {
           quizCheckbox.checked = false;
         }
         updateCreateButton();
       });

       quizCheckbox.addEventListener('change', () => {
         if (quizCheckbox.checked) {
           classicCheckbox.checked = false;
         }
         updateCreateButton();
       });

       // Handle create deck button
       document.getElementById('createDeckBtn').addEventListener('click', () => {
         const deckData = {
           subjectName: document.getElementById('subjectName').value,
           cardCount: document.getElementById('cardCount').value,
           cardColor: document.getElementById('cardColor').value,
           type: textCheckbox.checked ? 'Text' : 'File',
           content: textCheckbox.checked ? 
             document.getElementById('textInput').value : 
             document.getElementById('fileDisplay').value || 'No File Selected',
           questioningType: classicCheckbox.checked ? 'Classic' : 'Quiz'
         };
         
         createDeck(deckData);
         popupOverlay.classList.remove('show');
         resetForm();
       });

             // Update next button state
       function updateNextButton() {
         const subjectName = document.getElementById('subjectName').value.trim();
         const cardCount = document.getElementById('cardCount').value.trim();
         const cardColor = document.getElementById('cardColor').value;
         const hasReadingMaterial = textCheckbox.checked || fileCheckbox.checked;

         nextBtn.disabled = !(subjectName && cardCount && cardColor && hasReadingMaterial);
       }

       // Update create button state
       function updateCreateButton() {
         const hasQuestioningType = classicCheckbox.checked || quizCheckbox.checked;
         document.getElementById('createDeckBtn').disabled = !hasQuestioningType;
       }

       // Reset form to initial state
       function resetForm() {
         step1.style.display = 'block';
         step2.style.display = 'none';
         step3.style.display = 'none';
         step4.style.display = 'none';
         
         document.getElementById('subjectName').value = '';
         document.getElementById('cardCount').value = '';
         document.getElementById('cardColor').value = '';
         textCheckbox.checked = false;
         fileCheckbox.checked = false;
         classicCheckbox.checked = false;
         quizCheckbox.checked = false;
         document.getElementById('textInput').value = '';
         fileDisplay.value = '';
         fileInput.value = '';
         
         nextBtn.disabled = true;
         document.getElementById('createDeckBtn').disabled = true;
       }

      // Add input event listeners for form validation
      document.getElementById('subjectName').addEventListener('input', updateNextButton);
      document.getElementById('cardCount').addEventListener('input', updateNextButton);
      document.getElementById('cardColor').addEventListener('change', updateNextButton);

      // Deck management
      let decks = [];
      let nextDeckId = 1;
      let selectedDeckId = null;

      // Context menu functionality
      const contextMenu = document.getElementById('contextMenu');
      const editPopupOverlay = document.getElementById('editPopupOverlay');

      // Hide context menu when clicking elsewhere
      document.addEventListener('click', () => {
        contextMenu.classList.remove('show');
      });

      // Right-click on deck cards
      document.addEventListener('contextmenu', (e) => {
        const deckCard = e.target.closest('.deck-card');
        if (deckCard) {
          e.preventDefault();
          selectedDeckId = deckCard.dataset.deckId;
          
          // Position context menu
          contextMenu.style.left = e.pageX + 'px';
          contextMenu.style.top = e.pageY + 'px';
          contextMenu.classList.add('show');
        }
      });

      // Handle context menu actions
      document.getElementById('editDeck').addEventListener('click', () => {
        const deck = decks.find(d => d.id === selectedDeckId);
        if (deck) {
          openEditPopup(deck);
        }
        contextMenu.classList.remove('show');
      });

      document.getElementById('deleteDeck').addEventListener('click', () => {
        if (confirm('Are you sure you want to delete this deck?')) {
          deleteDeck(selectedDeckId);
        }
        contextMenu.classList.remove('show');
      });

      // Edit popup functionality
      function openEditPopup(deck) {
        document.getElementById('editSubjectName').value = deck.subjectName;
        document.getElementById('editCardCount').value = deck.cardCount;
        document.getElementById('editCardColor').value = deck.cardColor;
        editPopupOverlay.classList.add('show');
      }

      // Close edit popup when clicking outside
      editPopupOverlay.addEventListener('click', (e) => {
        if (e.target === editPopupOverlay) {
          editPopupOverlay.classList.remove('show');
        }
      });

      // Save edit changes
      document.getElementById('saveEditBtn').addEventListener('click', () => {
        const deckIndex = decks.findIndex(d => d.id === selectedDeckId);
        if (deckIndex !== -1) {
          decks[deckIndex].subjectName = document.getElementById('editSubjectName').value;
          decks[deckIndex].cardCount = document.getElementById('editCardCount').value;
          decks[deckIndex].cardColor = document.getElementById('editCardColor').value;
          
          updateDeckDisplay();
          editPopupOverlay.classList.remove('show');
        }
      });

             // Create new deck
       function createDeck(deckData) {
         const deck = {
           id: 'deck_' + nextDeckId++,
           title: deckData.subjectName, // Use subject name as initial title
           subjectName: deckData.subjectName,
           cardCount: deckData.cardCount,
           cardColor: deckData.cardColor,
           type: deckData.type,
           content: deckData.content,
           questioningType: deckData.questioningType,
           createdAt: new Date().toLocaleDateString('en-US', { 
             month: 'short', 
             day: 'numeric' 
           })
         };
         
         decks.push(deck);
         updateDeckDisplay();
       }

      // Delete deck
      function deleteDeck(deckId) {
        decks = decks.filter(d => d.id !== deckId);
        updateDeckDisplay();
      }

      // Update deck display
      function updateDeckDisplay() {
        const container = document.getElementById('decksContainer');
        const addCardBtn = container.querySelector('.add-card');
        
        // Clear existing decks (except add card button)
        container.innerHTML = '';
        
        // Add deck cards
        decks.forEach(deck => {
          const deckCard = createDeckCard(deck);
          container.appendChild(deckCard);
        });
        
        // Re-add the add card button
        container.appendChild(addCardBtn);
        
        // Re-attach event listeners
        attachDeckEventListeners();
      }

             // Create deck card element
       function createDeckCard(deck) {
         const deckCard = document.createElement('div');
         deckCard.className = 'deck-card';
         deckCard.dataset.deckId = deck.id;
         
         const colorMap = {
           blue: '#007bff',
           green: '#28a745',
           red: '#dc3545',
           yellow: '#ffc107',
           purple: '#6f42c1'
         };
         
         deckCard.innerHTML = `
           <div class="deck-stack">
             <div class="deck-card-top" style="background: ${colorMap[deck.cardColor] || '#ff8c00'}">
               ${deck.type === 'text' ? 'Text Deck' : 'File Deck'}
             </div>
             <div class="deck-card-middle"></div>
             <div class="deck-card-bottom"></div>
           </div>
           <div class="deck-info">
             <div class="deck-title" data-deck-id="${deck.id}">${deck.title}</div>
             <div class="deck-details">${deck.subjectName} • ${deck.questioningType} • Created ${deck.createdAt}</div>
           </div>
         `;
         
         return deckCard;
       }

             // Attach event listeners to deck cards
       function attachDeckEventListeners() {
         const deckCards = document.querySelectorAll('.deck-card');
         deckCards.forEach(card => {
           // Right-click context menu
           card.addEventListener('contextmenu', (e) => {
             e.preventDefault();
             selectedDeckId = card.dataset.deckId;
             
             contextMenu.style.left = e.pageX + 'px';
             contextMenu.style.top = e.pageY + 'px';
             contextMenu.classList.add('show');
           });
           
           // Double-click to edit title
           const titleElement = card.querySelector('.deck-title');
           if (titleElement) {
             titleElement.addEventListener('dblclick', (e) => {
               e.stopPropagation();
               editDeckTitle(titleElement);
             });
           }
         });
       }

       // Edit deck title inline
       function editDeckTitle(titleElement) {
         const deckId = titleElement.dataset.deckId;
         const deck = decks.find(d => d.id === deckId);
         if (!deck) return;
         
         const currentTitle = deck.title;
         const input = document.createElement('input');
         input.type = 'text';
         input.value = currentTitle;
         input.className = 'title-edit-input';
         input.style.cssText = `
           width: 100%;
           padding: 4px 8px;
           border: 1px solid #007bff;
           border-radius: 4px;
           font-size: 16px;
           font-weight: bold;
           background: white;
           color: #333;
         `;
         
         titleElement.innerHTML = '';
         titleElement.appendChild(input);
         input.focus();
         input.select();
         
         function saveTitle() {
           const newTitle = input.value.trim();
           if (newTitle && newTitle !== currentTitle) {
             deck.title = newTitle;
             updateDeckDisplay();
           } else {
             titleElement.textContent = currentTitle;
           }
         }
         
         input.addEventListener('blur', saveTitle);
         input.addEventListener('keypress', (e) => {
           if (e.key === 'Enter') {
             saveTitle();
           } else if (e.key === 'Escape') {
             titleElement.textContent = currentTitle;
           }
         });
       }

      // Remove sample deck on page load
      window.addEventListener('load', () => {
        const sampleDeck = document.querySelector('[data-deck-id="sample"]');
        if (sampleDeck) {
          sampleDeck.remove();
        }
      });
    </script>
  </body>
</html>






