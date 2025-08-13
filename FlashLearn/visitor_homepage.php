<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>FlashLearn</title>
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
      
      .login-btn {
        float: right;
        padding: 8px 16px;
        background: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 4px;
      }
      
      .page-title {
        font-size: 24px;
        font-weight: bold;
      }
      
      .notification-container {
        position: relative;
        float: right;
        margin-right: 16px;
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
            <li><a class="nav-item" href="yourcardspage.php">Your Cards</a></li>
            <li><a class="nav-item" href="recentpage.php">Recent</a></li>
            <li><a class="nav-item" href="settingspage.php">Settings</a></li>
              </ul>
            </nav>
        </aside>

      <!-- Header -->
      <header class="topbar">
        <div class="page-title">Home</div>
        <div class="notification-container">
          <button class="notification-btn">🔔</button>
          <div class="notification-popup">
            <div class="notification-header">Notifications</div>
            <div class="notification-content">No new notifications.</div>
          </div>
        </div>
        <a class="login-btn" href="loginpage.php">Log in</a>
      </header>

      <!-- Main content -->
        <main class="content">
        <button class="add-card">+</button>
        </main>
    </div>

    <script>
        // Notification popup functionality
        const notificationBtn = document.querySelector('.notification-btn');
        const notificationPopup = document.querySelector('.notification-popup');

        if (notificationBtn && notificationPopup) {
          notificationBtn.addEventListener('click', () => {
            notificationPopup.classList.toggle('show');
          });
        }
    </script>
  </body>
  </html>