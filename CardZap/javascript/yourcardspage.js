document.addEventListener("DOMContentLoaded", () => {
    const addCardBtn = document.getElementById("addCardBtn");
    const cardModal = document.getElementById("cardModal");
    const closeModal = document.getElementById("closeModal");
    const cardForm = document.getElementById("cardForm");
    const cardsList = document.getElementById("cards-list");
  
    // Open modal
    addCardBtn.addEventListener("click", () => {
      cardModal.classList.remove("hidden");
    });
  
    // Close modal
    closeModal.addEventListener("click", () => {
      cardModal.classList.add("hidden");
    });
  
    // Save new card
    cardForm.addEventListener("submit", (e) => {
      e.preventDefault();
      const question = document.getElementById("question").value;
      const answer = document.getElementById("answer").value;
  
      const card = document.createElement("div");
      card.classList.add("card-item");
      card.innerHTML = `
        <h3>${question}</h3>
        <p>${answer}</p>
      `;
  
      cardsList.appendChild(card);
  
      // Reset and close
      cardForm.reset();
      cardModal.classList.add("hidden");
    });
  });
  