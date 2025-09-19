// Duplicated from student_yourcards.js
document.addEventListener("DOMContentLoaded", () => {
  // Modal functionality
  const addCardBtn = document.getElementById('addCardBtn');
  const cardModal = document.getElementById('cardModal');
  const closeModal = document.getElementById('closeModal');
  const nextBtn = document.getElementById('nextBtn');
  const nextTextBtn = document.getElementById('nextTextBtn');
  const nextFileBtn = document.getElementById('nextFileBtn');
  const createDeckBtn = document.getElementById('createDeckBtn');
  const textCheckbox = document.getElementById('textCheckbox');
  const fileCheckbox = document.getElementById('fileCheckbox');
  const classicCheckbox = document.getElementById('classicCheckbox');
  const quizCheckbox = document.getElementById('quizCheckbox');
  const browseBtn = document.getElementById('browseBtn');
  const fileInput = document.getElementById('fileInput');
  const fileDisplay = document.getElementById('fileDisplay');

  // Debug: Check if elements are found
  console.log('Elements found:', {
    addCardBtn: !!addCardBtn,
    cardModal: !!cardModal,
    nextBtn: !!nextBtn,
    textCheckbox: !!textCheckbox,
    fileCheckbox: !!fileCheckbox
  });

  // Step elements
  const step1 = document.getElementById('step1');
  const step2 = document.getElementById('step2');
  const step3 = document.getElementById('step3');
  const step4 = document.getElementById('step4');

  // Back buttons
  const backToStep1 = document.getElementById('backToStep1');
  const backToStep1File = document.getElementById('backToStep1File');
  const backToStep1Final = document.getElementById('backToStep1Final');

  // Open modal
  addCardBtn.addEventListener('click', () => {
    cardModal.classList.remove('hidden');
    resetForm();
  });

  // Close modal
  closeModal.addEventListener('click', () => {
    cardModal.classList.add('hidden');
    resetForm();
  });

  // Close modal when clicking outside
  cardModal.addEventListener('click', (e) => {
    if (e.target === cardModal) {
      cardModal.classList.add('hidden');
      resetForm();
    }
  });

  // Handle checkbox selection (mutually exclusive)
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
  nextTextBtn.addEventListener('click', () => {
    step2.style.display = 'none';
    step4.style.display = 'block';
  });

  nextFileBtn.addEventListener('click', () => {
    step3.style.display = 'none';
    step4.style.display = 'block';
  });

  // Handle back buttons
  backToStep1.addEventListener('click', () => {
    step2.style.display = 'none';
    step1.style.display = 'block';
  });

  backToStep1File.addEventListener('click', () => {
    step3.style.display = 'none';
    step1.style.display = 'block';
  });

  backToStep1Final.addEventListener('click', () => {
    step4.style.display = 'none';
    if (textCheckbox.checked) {
      step2.style.display = 'block';
    } else if (fileCheckbox.checked) {
      step3.style.display = 'block';
    }
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
  createDeckBtn.addEventListener('click', () => {
    const deckData = {
      subjectName: document.getElementById('subjectName').value,
      cardCount: document.getElementById('cardCount').value,
      cardColor: document.getElementById('cardColor').value,
      type: textCheckbox.checked ? 'Text' : 'File',
      content: textCheckbox.checked ? document.getElementById('textInput').value : document.getElementById('fileDisplay').value || 'No File Selected',
      questioningType: classicCheckbox.checked ? 'Classic' : 'Quiz'
    };
    
    // Create new deck (same behavior)
    createDeckCard(deckData);
    cardModal.classList.add('hidden');
    resetForm();
  });

  // Create deck card function
  function createDeckCard(deckData) {
    const decksContainer = document.getElementById('decksContainer');
    const addCardBtn = decksContainer.querySelector('.add-card');
    
    // Create new deck card
    const deckCard = document.createElement('div');
    deckCard.className = 'deck-card';
    deckCard.dataset.deckId = 'deck_' + Date.now();
    
    // Store deck data for editing
    deckCard.dataset.deckData = JSON.stringify(deckData);
    
    // Color mapping
    const colorMap = {
      blue: '#007bff',
      green: '#28a745',
      red: '#dc3545',
      yellow: '#ffc107',
      purple: '#6f42c1'
    };
    
    const cardColor = colorMap[deckData.cardColor] || '#ff8c00';
    
    deckCard.innerHTML = `
      <div class="deck-stack">
        <div class="deck-card-top" style="background: ${cardColor}">
          ${deckData.type === 'Text' ? (deckData.content || 'Text Deck') : 'File Deck'}
        </div>
        <div class="deck-card-middle"></div>
        <div class="deck-card-bottom"></div>
      </div>
      <div class="deck-info">
        <div class="deck-title">${deckData.subjectName}</div>
        <div class="deck-details">${deckData.subjectName} • ${deckData.questioningType} • Created ${new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric' })}</div>
      </div>
    `;
    
    // Add right-click context menu
    deckCard.addEventListener('contextmenu', (e) => {
      e.preventDefault();
      showContextMenu(e, deckCard, deckData);
    });
    
    // Add click navigation behavior
    deckCard.addEventListener('click', () => {
      const params = new URLSearchParams({
        deckId: deckCard.dataset.deckId,
        subjectName: deckData.subjectName,
        cardCount: deckData.cardCount,
        cardColor: deckData.cardColor,
        type: deckData.type,
        content: deckData.content,
        userType: 'teacher'
      });
      if (deckData.questioningType === 'Classic') {
        window.location.href = `teacher_classiccards.php?${params.toString()}`;
      } else {
        window.location.href = `teacher_quizcards.php?${params.toString()}`;
      }
    });
    
    decksContainer.insertBefore(deckCard, addCardBtn);
  }

  function updateNextButton() {
    const subjectName = document.getElementById('subjectName').value.trim();
    const cardCount = document.getElementById('cardCount').value.trim();
    const cardColor = document.getElementById('cardColor').value;
    const hasReadingMaterial = textCheckbox.checked || fileCheckbox.checked;
    nextBtn.disabled = !(subjectName && cardCount && cardColor && hasReadingMaterial);
  }

  function updateCreateButton() {
    const hasQuestioningType = classicCheckbox.checked || quizCheckbox.checked;
    createDeckBtn.disabled = !hasQuestioningType;
  }

  function resetForm() {
    step1.style.display = 'block';
    step2.style.display = 'none';
    step3.style.display = 'none';
    step4.style.display = 'none';
    document.getElementById('subjectName').value = '';
    document.getElementById('cardCount').value = '';
    document.getElementById('cardColor').value = '';
    document.getElementById('textInput').value = '';
    fileDisplay.value = '';
    fileInput.value = '';
    textCheckbox.checked = false;
    fileCheckbox.checked = false;
    classicCheckbox.checked = false;
    quizCheckbox.checked = false;
    nextBtn.disabled = true;
    createDeckBtn.disabled = true;
  }

  // Context menu functionality
  let currentContextMenu = null;

  // Show context menu
  function showContextMenu(e, deckCard, deckData) {
    // Remove existing context menu
    if (currentContextMenu) {
      currentContextMenu.remove();
    }

    const contextMenu = document.createElement('div');
    contextMenu.className = 'context-menu';
    contextMenu.style.cssText = `
      position: fixed;
      top: ${e.clientY}px;
      left: ${e.clientX}px;
      background: white;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      z-index: 1000;
      min-width: 150px;
    `;

    const editOption = document.createElement('div');
    editOption.textContent = 'Edit Deck';
    editOption.style.cssText = `
      padding: 8px 12px;
      cursor: pointer;
      border-bottom: 1px solid #eee;
    `;
    editOption.addEventListener('click', () => {
      // Link to appropriate edit page based on deck type
      const target = (deckData && deckData.questioningType === 'Quiz') ? 'editquiz.php' : 'editclassic.php';
      const deckId = encodeURIComponent(deckCard.dataset.deckId || 'demo');
      window.location.href = `${target}?deck=${deckId}`;
    });

    const deleteOption = document.createElement('div');
    deleteOption.textContent = 'Delete Deck';
    deleteOption.style.cssText = `
      padding: 8px 12px;
      cursor: pointer;
      color: #dc3545;
    `;
    deleteOption.addEventListener('click', () => {
      deleteDeck(deckCard);
      contextMenu.remove();
      currentContextMenu = null;
    });

    contextMenu.appendChild(editOption);
    contextMenu.appendChild(deleteOption);
    document.body.appendChild(contextMenu);
    currentContextMenu = contextMenu;

    // Close context menu when clicking outside
    setTimeout(() => {
      document.addEventListener('click', closeContextMenu);
    }, 0);
  }

  // Close context menu
  function closeContextMenu() {
    if (currentContextMenu) {
      currentContextMenu.remove();
      currentContextMenu = null;
    }
    document.removeEventListener('click', closeContextMenu);
  }

  // Delete deck function
  function deleteDeck(deckCard) {
    if (confirm('Are you sure you want to delete this deck?')) {
      deckCard.remove();
    }
  }
});


