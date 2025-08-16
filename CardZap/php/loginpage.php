<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Log in • FlashLearn</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
  </head>
  <body>
    <header class="topnav">
      <div class="brand">FlashLearn</div>
    </header>

    <main class="wrap">
      <form class="card" method="post" action="login.php">
        <h1 class="title">Log in</h1>

        <div class="field">
          <label for="username">Username</label>
          <input id="username" name="username" type="text" required />
        </div>

        <div class="field">
          <label for="password">Password</label>
          <input id="password" name="password" type="password" required />
        </div>

        <div class="actions">
          <button class="btn" type="submit">Log in</button>
          <div class="link">
            New here? <a href="signinpage.php">Create an account</a>
          </div>
        </div>
      </form>
    </main>
  </body>
</html>
