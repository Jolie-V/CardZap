<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Log in • FlashLearn</title>
    <style>
      :root { --border: #e5e7eb; --bg: #f3f4f6; --card: #ffffff; --text: #111827; --muted: #6b7280; --primary: #2563eb; }
      * { box-sizing: border-box; }
      html, body { height: 100%; }
      body { margin: 0; font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji"; background: var(--bg); color: var(--text); }
      .wrap { min-height: 100%; display: grid; place-items: center; padding: 24px; }
      .card { width: 100%; max-width: 380px; background: var(--card); border: 1px solid var(--border); border-radius: 12px; padding: 20px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.08), 0 4px 6px -4px rgba(0,0,0,0.06); }
      .title { margin: 0 0 16px; font-size: 20px; text-align: center; }
      .field { display: grid; gap: 6px; margin-bottom: 12px; }
      label { font-size: 12px; color: var(--muted); }
      input { padding: 10px 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 14px; }
      .actions { display: grid; gap: 10px; margin-top: 8px; }
      .btn { appearance: none; border: 1px solid var(--primary); background: var(--primary); color: #fff; padding: 10px 14px; border-radius: 8px; font-weight: 600; cursor: pointer; }
      .btn:hover { filter: brightness(0.95); }
      .link { text-align: center; font-size: 14px; }
      .link a { color: var(--primary); text-decoration: none; }
      .topnav { position: fixed; top: 0; left: 0; right: 0; display: flex; justify-content: space-between; align-items: center; padding: 10px 16px; background: #ffffff; border-bottom: 1px solid var(--border); }
      .brand { font-weight: 700; }
      .home-link { text-decoration: none; color: var(--text); padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px; }
    </style>
  </head>
  <body>
    <header class="topnav">
      <div class="brand">FlashLearn</div>
    </header>
    <main class="wrap">
      <form class="card" method="post" action="#">
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
          <div class="link">New here? <a href="signinpage.php">Create an account</a></div>
        </div>
      </form>
    </main>
  </body>
  </html>


