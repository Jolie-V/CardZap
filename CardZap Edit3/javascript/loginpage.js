document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form");
  
    form.addEventListener("submit", (e) => {
      // Example: Client-side check (not real auth!)
      const username = document.getElementById("username").value.trim();
      const password = document.getElementById("password").value.trim();
  
      if (!username || !password) {
        e.preventDefault();
        alert("Please enter both username and password.");
      }
    });
  });  