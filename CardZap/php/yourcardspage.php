<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Your Cards • FlashLearn</title>
    <link rel="stylesheet" href="yourcardspage.css" />
    <script src="yourcardspage.js" defer></script>
  </head>
  <body>
    <header class="topnav">
      <div class="brand">FlashLearn</div>
      <nav class="nav-links">
        <a href="home.php">Home</a>
        <a href="yourcardspage.php" class="active">Your Cards</a>
        <a href="logout.php">Logout</a>
      </nav>
    </header>

    <main class="wrap">
      <section class="card-container">
        <h1 class="title">Your Flashcards</h1>
        <div id="cards-list" class="cards-grid">
          <!-- Cards will be rendered here dynamically -->
        </div>
        <button class="btn" id="addCardBtn">+ Add New Card</button>
      </section>
    </main>

    <!-- Modal -->
    <div id="cardModal" class="modal hidden">
      <div class="modal-content">
        <h2>Add New Card</h2>
        <form id="cardForm">
          <div class="field">
            <label for="question">Question</label>
            <input type="text" id="question" name="question" required />
          </div>
          <div class="field">
            <label for="answer">Answer</label>
            <input type="text" id="answer" name="answer" required />
          </div>
          <div class="actions">
            <button type="submit" class="btn">Save</button>
            <button type="button" class="btn secondary" id="closeModal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
