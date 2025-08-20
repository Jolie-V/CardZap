/* ===== CO-OP LOBBY FUNCTIONALITY ===== */
/* This file handles the collaborative game lobby interactions including:
   - Lobby navigation (exit functionality)
   - File upload simulation for quiz content
   - Player invitation system
   - UI state management */

// ===== DOM ELEMENT REFERENCES =====
const exitBtn = document.querySelector('.exit-btn');                    // Exit lobby button
const fileUploadCard = document.querySelector('.file-upload-card');     // File upload area
const emptySlots = document.querySelectorAll('.player-slot.empty');     // Available player slots

// ===== INITIALIZATION =====
/**
 * Initialize the lobby when the page loads
 * Sets up all event listeners for user interactions
 */
function init() {
  setupEventListeners();
}

// ===== EVENT LISTENER SETUP =====
/**
 * Configure all event listeners for lobby interactions
 * Includes exit button, file upload, and player invitation functionality
 */
function setupEventListeners() {
  // Exit lobby button functionality
  if (exitBtn) {
    exitBtn.addEventListener('click', () => {
      if (confirm('Are you sure you want to exit the lobby?')) {
        window.location.href = 'friendspage.php';
      }
    });
  }

  // File upload card functionality
  if (fileUploadCard) {
    fileUploadCard.addEventListener('click', () => {
      openFileUpload();
    });
  }

  // Empty player slot functionality (for inviting players)
  emptySlots.forEach(slot => {
    slot.addEventListener('click', () => {
      invitePlayer(slot);
    });
  });
}

// ===== FILE UPLOAD SYSTEM =====
/**
 * Open file upload dialog for quiz content
 * Creates a hidden file input element and triggers file selection
 */
function openFileUpload() {
  // Create a hidden file input element
  const fileInput = document.createElement('input');
  fileInput.type = 'file';
  fileInput.accept = '.txt,.doc,.docx,.pdf';  // Accept common document formats
  fileInput.style.display = 'none';
  
  // Handle file selection
  fileInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (file) {
      handleFileUpload(file);
    }
  });
  
  // Trigger file selection dialog
  document.body.appendChild(fileInput);
  fileInput.click();
  document.body.removeChild(fileInput);
}

/**
 * Process the uploaded file and update UI
 * Simulates file upload process with loading states and success feedback
 * @param {File} file - The selected file object
 */
function handleFileUpload(file) {
  // Show loading state during upload
  const uploadText = fileUploadCard.querySelector('.upload-text');
  const originalText = uploadText.textContent;
  uploadText.textContent = 'Uploading...';
  
  // Simulate upload process (2 second delay)
  setTimeout(() => {
    // Update UI to show successful upload
    uploadText.textContent = file.name;
    fileUploadCard.style.background = 'linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%)';
    fileUploadCard.style.borderColor = '#28a745';
    
    // Show success message to user
    alert(`File "${file.name}" uploaded successfully!`);
  }, 2000);
}

// ===== PLAYER INVITATION SYSTEM =====
/**
 * Invite a player to join the lobby
 * Prompts for player name and updates the slot with player information
 * @param {HTMLElement} slot - The empty player slot element to fill
 */
function invitePlayer(slot) {
  const playerName = prompt('Enter player name to invite:');
  if (playerName && playerName.trim()) {
    // Update the slot with player information
    slot.innerHTML = `
      <div class="player-avatar">😊</div>
      <div class="player-name">${playerName}</div>
    `;
    
    // Update slot styling to show it's occupied
    slot.classList.remove('empty');
    slot.classList.add('invited');
    
    // Show confirmation message
    alert(`Invitation sent to ${playerName}!`);
  }
}

// ===== PAGE INITIALIZATION =====
// Start the lobby when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', init);
