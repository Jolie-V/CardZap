// Logout
const logoutBtn = document.querySelector('.logout-btn');
if (logoutBtn) logoutBtn.addEventListener('click', () => window.location.href = 'visitor_homepage.php');

// Get deck data from URL parameters
function getDeckDataFromURL() {
  const urlParams = new URLSearchParams(window.location.search);
  const deckId = urlParams.get('deck');
  
  if (deckId) {
    // In a real application, you would fetch deck data from server
    // For now, we'll use dummy data based on the deck ID
    return {
      id: deckId,
      name: `Quiz Deck ${deckId}`,
      cards: [
        { 
          id: 1, 
          question: 'What is the capital of France?', 
          answer: 'Paris', 
          options: ['London', 'Paris', 'Berlin', 'Madrid'] 
        },
        { 
          id: 2, 
          question: 'What is 2 + 2?', 
          answer: '4', 
          options: ['3', '4', '5', '6'] 
        },
        { 
          id: 3, 
          question: 'What is the largest planet?', 
          answer: 'Jupiter', 
          options: ['Mars', 'Venus', 'Jupiter', 'Saturn'] 
        }
      ]
    };
  }
  
  return null;
}

// Load deck data or use default
const deckData = getDeckDataFromURL();
let cards = deckData ? deckData.cards : [
  { id: 1, question: 'This is a Question', answer: 'This is the Answer', options: ['This is an Option', 'This is an Option', 'This is an Option'] },
  { id: 2, question: 'This is a Question', answer: 'This is the Answer', options: ['This is an Option', 'This is an Option', 'This is an Option'] },
];

const container = document.getElementById('cardsContainer');
const saveBtn = document.getElementById('saveBtn');

function renderCards() {
  container.innerHTML = '';
  cards.forEach((c, idx) => {
    const block = document.createElement('div');
    block.className = 'card-block';
    block.innerHTML = `
      <div class="card-title">Card ${idx + 1}</div>
      <div class="trash" title="Delete">🗑</div>
      <div class="qa">
        <div class="q-text">${c.question}</div>
        <button class="edit-btn" data-type="q">Edit</button>
      </div>
      <div class="qa answer" style="margin-top: 10px;">
        <div class="a-text">${c.answer}</div>
        <button class="edit-btn" data-type="a">Edit</button>
      </div>
      ${c.options.map((opt, i) => `
        <div class="qa option" style="margin-top: 10px;">
          <div class="o-text" data-idx="${i}">${opt}</div>
          <button class="edit-btn" data-type="o" data-idx="${i}">Edit</button>
        </div>
      `).join('')}
    `;

    // Delete
    block.querySelector('.trash').onclick = () => {
      cards = cards.filter(x => x.id !== c.id);
      renderCards();
    };

    // Edit handlers
    block.querySelectorAll('.edit-btn').forEach(btn => {
      btn.onclick = () => {
        const type = btn.getAttribute('data-type');
        if (type === 'o') {
          const idxOpt = parseInt(btn.getAttribute('data-idx'), 10);
          const current = c.options[idxOpt];
          const updated = prompt('Edit Option', current);
          if (updated !== null) { c.options[idxOpt] = updated; renderCards(); }
          return;
        }
        const current = type === 'q' ? c.question : c.answer;
        const updated = prompt('Edit ' + (type === 'q' ? 'Question' : 'Answer'), current);
        if (updated !== null) {
          if (type === 'q') c.question = updated; else c.answer = updated;
          renderCards();
        }
      };
    });

    container.appendChild(block);
  });
}

// Save Deck Modal Elements
const saveDeckModal = document.getElementById('saveDeckModal');
const subjectSelect = document.getElementById('subjectSelect');
const saveDeckBtn = document.getElementById('saveDeckBtn');

// Show save deck modal when save button is clicked
saveBtn.addEventListener('click', () => {
  saveDeckModal.classList.remove('hidden');
});

// Close modal when clicking outside
saveDeckModal.addEventListener('click', (e) => {
  if (e.target === saveDeckModal) {
    saveDeckModal.classList.add('hidden');
  }
});

// Handle save deck button click
saveDeckBtn.addEventListener('click', () => {
  const selectedSubject = subjectSelect.value;
  
  if (!selectedSubject) {
    alert('Please select a subject');
    return;
  }
  
  if (selectedSubject === 'new') {
    const newSubject = prompt('Enter new subject name:');
    if (newSubject && newSubject.trim()) {
      // Here you would typically save the deck with the new subject
      alert('Quiz cards saved to new subject: ' + newSubject.trim());
    } else {
      return; // Don't proceed if no subject name entered
    }
  } else {
    // Here you would typically save the deck with the selected subject
    alert('Quiz cards saved to subject: ' + selectedSubject);
  }
  
  saveDeckModal.classList.add('hidden');
  window.location.href = 'teacher_yourcards.php';
});

renderCards();


