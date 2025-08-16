<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sign up • CardZap</title>
  <!-- Link to external CSS -->
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <header class="topnav">
    <div class="brand">CardZap</div>
  </header>

  <main class="wrap">
    <form class="card" method="post" action="#">
      <h1 class="title">Sign up</h1>

      <div class="field">
        <label for="su-username">Username</label>
        <input id="su-username" name="username" type="text" required />
      </div>

      <div class="field">
        <label for="su-email">Email</label>
        <input id="su-email" name="email" type="email" required />
      </div>

      <div class="field">
        <label for="su-password">Password</label>
        <input id="su-password" name="password" type="password" required />
      </div>

      <div class="field">
        <label for="su-password2">Re-type password</label>
        <input id="su-password2" name="password2" type="password" required />
      </div>

      <div class="user-type-field">
        <label>I am a:</label>
        <div class="user-type-options">
          <div class="user-type-option">
            <input type="radio" id="student" name="user_type" value="student" required>
            <label for="student">Student</label>
          </div>
          <div class="user-type-option">
            <input type="radio" id="teacher" name="user_type" value="teacher" required>
            <label for="teacher">Teacher</label>
          </div>
        </div>
      </div>

      <div class="actions">
        <button class="btn" type="submit" id="submitBtn" disabled>
          Create account
        </button>
        <div class="link">
          Already a user? <a href="loginpage.php">Log in</a>
        </div>
      </div>
    </form>
  </main>
</body>
</html>
