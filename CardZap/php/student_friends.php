<?php
session_start();
include_once "db.php";

if (!isset($_SESSION['user_info_id'])) {
    header("Location: ../php/login.php");
    exit();
}

$currentUserId = $_SESSION['user_info_id'];

/*
 * --- Handle POST actions (unfriend, add-request, accept-request, reject-request)
 * Returns simple plaintext responses: "unfriended", "request_sent", "accepted", "rejected", or "error:..."
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $targetId = intval($_POST['target_id'] ?? 0);

    // Unfriend (target_id = other user's user_info_id)
    if ($action === 'unfriend' && $targetId > 0) {
        $stmt = $conn->prepare("
            DELETE FROM friends
            WHERE (user_one = ? AND user_two = ?) OR (user_one = ? AND user_two = ?)
        ");
        $stmt->bind_param("iiii", $currentUserId, $targetId, $targetId, $currentUserId);
        if ($stmt->execute()) {
            echo "unfriended";
        } else {
            echo "error: " . $stmt->error;
        }
        exit();
    }

    // Send friend request (target_id = receiver user_info_id)
    if ($action === 'add-request' && $targetId > 0) {
        // prevent duplicate pending requests
        $check = $conn->prepare("SELECT fr_id FROM friend_request WHERE sender = ? AND receiver = ? AND status = 'pending'");
        $check->bind_param("ii", $currentUserId, $targetId);
        $check->execute();
        $check->store_result();
        if ($check->num_rows > 0) {
            echo "already_sent";
            exit();
        }

        $stmt = $conn->prepare("INSERT INTO friend_request (sender, receiver, status) VALUES (?, ?, 'pending')");
        $stmt->bind_param("ii", $currentUserId, $targetId);
        if ($stmt->execute()) {
            echo "request_sent";
        } else {
            echo "error: " . $stmt->error;
        }
        exit();
    }

    // Accept friend request (target_id = fr_id from friend_request)
    if ($action === 'accept-request' && $targetId > 0) {
        // get the sender
        $g = $conn->prepare("SELECT sender FROM friend_request WHERE fr_id = ? AND receiver = ? AND status = 'pending'");
        $g->bind_param("ii", $targetId, $currentUserId);
        $g->execute();
        $gr = $g->get_result();
        if ($row = $gr->fetch_assoc()) {
            $sender = intval($row['sender']);

            // Insert into friends. Prevent duplicate by checking first.
            $chkFriend = $conn->prepare("SELECT * FROM friends WHERE (user_one = ? AND user_two = ?) OR (user_one = ? AND user_two = ?)");
            $chkFriend->bind_param("iiii", $sender, $currentUserId, $currentUserId, $sender);
            $chkFriend->execute();
            $chkFriend->store_result();

            if ($chkFriend->num_rows === 0) {
                $ins = $conn->prepare("INSERT INTO friends (user_one, user_two) VALUES (?, ?)");
                $ins->bind_param("ii", $sender, $currentUserId);
                if (! $ins->execute()) {
                    echo "error: " . $ins->error;
                    exit();
                }
            }

            // mark request accepted
            $upd = $conn->prepare("UPDATE friend_request SET status = 'accepted' WHERE fr_id = ?");
            $upd->bind_param("i", $targetId);
            $upd->execute();

            echo "accepted";
        } else {
            echo "not_found";
        }
        exit();
    }

    // Reject friend request (target_id = fr_id)
    if ($action === 'reject-request' && $targetId > 0) {
        $upd = $conn->prepare("UPDATE friend_request SET status = 'rejected' WHERE fr_id = ? AND receiver = ?");
        $upd->bind_param("ii", $targetId, $currentUserId);
        if ($upd->execute()) {
            echo "rejected";
        } else {
            echo "error: " . $upd->error;
        }
        exit();
    }
}

/* -------------------------
 * Fetch data for rendering
 * ------------------------- */

/* Friends list */
$friendsQuery = $conn->prepare("
    SELECT ui.user_info_id, ui.full_name, ui.course, ui.photo
    FROM friends f
    JOIN user_info ui ON (ui.user_info_id = IF(f.user_one = ?, f.user_two, f.user_one))
    WHERE (f.user_one = ? OR f.user_two = ?)
      AND ui.user_info_id != ?
      AND ui.user_type = 'S'
");
$friendsQuery->bind_param("iiii", $currentUserId, $currentUserId, $currentUserId, $currentUserId);
$friendsQuery->execute();
$friendsResult = $friendsQuery->get_result();
$friends = $friendsResult->fetch_all(MYSQLI_ASSOC);

/* Students (not yet friends) */
$studentsQuery = $conn->prepare("
    SELECT ui.user_info_id, ui.full_name, ui.course, ui.photo
    FROM user_info ui
    WHERE ui.user_type = 'S'
      AND ui.user_info_id != ?
      AND ui.user_info_id NOT IN (
          SELECT IF(user_one = ?, user_two, user_one)
          FROM friends
          WHERE user_one = ? OR user_two = ?
      )
");
$studentsQuery->bind_param("iiii", $currentUserId, $currentUserId, $currentUserId, $currentUserId);
$studentsQuery->execute();
$studentsResult = $studentsQuery->get_result();
$students = $studentsResult->fetch_all(MYSQLI_ASSOC);

/* Friend requests (received) - explicitly select ui.course AS course to ensure the key exists */
$requestsQuery = $conn->prepare("
    SELECT fr.fr_id, fr.sender, ui.full_name, ui.photo, ui.course AS course
    FROM friend_request fr
    JOIN user_info ui ON fr.sender = ui.user_info_id
    WHERE fr.receiver = ? AND fr.status = 'pending'
");
$requestsQuery->bind_param("i", $currentUserId);
$requestsQuery->execute();
$requestsResult = $requestsQuery->get_result();
$requests = $requestsResult->fetch_all(MYSQLI_ASSOC);

?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>CardZap • Friends</title>
  <link rel="stylesheet" href="../css/student_friends.css" />
  <link rel="stylesheet" href="../css/main.css" />
</head>
<body>
  <div class="app">
    <!-- ===== LEFT SIDEBAR ===== -->
    <aside class="sidebar" id="sidebar">
      <div class="sidebar-header">
        <a href="admin_homepage.php" class="logo">
          <img src="../css/CardZapLogo.png" alt="Dashboard Icon" class="logo-img" />
          <span>CardZap</span>
        </a>
      </div>

      <!-- Navigation menu -->
      <nav>
        <ul class="nav-list">
          <li class="nav-item">
            <a href="student_profile.php" class="nav-link">
              <img src="https://img.icons8.com/?size=100&id=QlB1OMIqTVgl&format=png&color=f0fcfe" alt="Profile" class="nav-icon" />
              Profile
            </a>
          </li>
          <li class="nav-item">
            <a href="student_yourcards.php" class="nav-link">
              <img src="https://img.icons8.com/?size=100&id=04GSmQqf0WPl&format=png&color=f0fcfe" alt="YourCards" class="nav-icon" />
              Your Cards
            </a>
          </li>
          <li class="nav-item">
            <a href="student_friends.php" class="nav-link">
              <img src="https://img.icons8.com/?size=100&id=W0yStnm1ahyh&format=png&color=f0fcfe" alt="Friends" class="nav-icon" />
              Friends
            </a>
          </li>
          <li class="nav-item">
            <a href="student_enrolled.php" class="nav-link">
              <img src="https://img.icons8.com/?size=100&id=ssqfwv5zvoTR&format=png&color=f0fcfe" alt="Enrolled" class="nav-icon" />
              Enrolled Subjects
            </a>
          </li>
          <li class="nav-item">
            <a href="student_settings.php" class="nav-link">
              <img src="https://img.icons8.com/?size=100&id=yku81UQEXoew&format=png&color=f0fcfe" alt="Settings" class="nav-icon" />
              Settings
            </a>
          </li>
        </ul>
      </nav>

      <!-- Logout button -->
      <div class="sidebar-footer">
        <form action="logout.php" method="post" style="width: 100%;">
          <button type="submit" class="btn btn-danger" style="width: 100%;">Log out</button>
        </form>
      </div>
    </aside>

    <!-- Sidebar overlay for mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- ===== TOP HEADER BAR ===== -->
    <header class="topbar">
      <div class="page-title">Friends</div>
      <div class="topbar-actions">
        <button class="btn btn-secondary mobile-menu-btn" id="sidebarToggle" aria-label="Open sidebar">☰</button>
      </div>
    </header>

   <!-- ===== MAIN CONTENT ===== -->
    <main class="content">
      <div class="friends-container">
        <div class="friends-tabs">
          <button class="tab active" data-tab="friend-list">Friend List</button>
          <button class="tab" data-tab="search-people">Search People</button>
          <button class="tab" data-tab="requests">Requests</button>
        </div>

<!-- Friend List -->
<div class="friends-content" id="friend-list-content">
  <div class="search-section">
    <input type="text" class="search-input" placeholder="Search friends..." id="friend-search">
  </div>
  <div class="friends-table">
    <table>
      <thead>
        <tr><th>Photo</th><th>Name</th><th>Course</th><th>Actions</th></tr>
      </thead>
      <tbody id="friends-table-body">
        <?php foreach ($friends as $f): ?>
          <tr>
            <td><img src="<?= htmlspecialchars($f['photo'] ?: '../css/default-avatar.png') ?>" class="student-avatar"></td>
            <td><?= htmlspecialchars($f['full_name']) ?></td>
            <td><?= htmlspecialchars($f['course']) ?></td>
            <td>
              <button class="unfriend-btn btn btn-danger" data-id="<?= $f['user_info_id'] ?>">Unfriend</button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Search People -->
<div class="friends-content hidden" id="search-people-content">
  <div class="search-section">
    <input type="text" class="search-input" placeholder="Search for people..." id="people-search">
  </div>
  <div class="friends-table">
    <table>
      <thead>
        <tr><th>Photo</th><th>Name</th><th>Course</th><th>Actions</th></tr>
      </thead>
      <tbody id="search-results">
        <?php foreach ($students as $s): ?>
          <tr>
            <td><img src="<?= htmlspecialchars($s['photo'] ?: '../css/default-avatar.png') ?>" class="student-avatar"></td>
            <td><?= htmlspecialchars($s['full_name']) ?></td>
            <td><?= htmlspecialchars($s['course']) ?></td>
            <td>
              <button class="add-request-btn btn btn-primary" data-id="<?= $s['user_info_id'] ?>">Add Friend</button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Requests -->
<div class="friends-content hidden" id="requests-content">
  <div class="friends-table">
    <table>
      <thead>
        <tr><th>Photo</th><th>Name</th><th>Course</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php if (count($requests) > 0): ?>
          <?php foreach ($requests as $r): ?>
            <tr>
              <td><img src="<?= htmlspecialchars($r['photo'] ?: '../css/default-avatar.png') ?>" class="student-avatar"></td>
              <td><?= htmlspecialchars($r['full_name']) ?></td>
              <td><?= htmlspecialchars($r['course']) ?></td>
              <td>
                <button class="accept-request-btn btn btn-success" data-id="<?= $r['fr_id'] ?>">Accept</button>
                <button class="reject-request-btn btn btn-danger" data-id="<?= $r['fr_id'] ?>">Reject</button>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="4">No pending requests.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>


  <script src="../javascript/student_friends.js"></script>
</body>
</html>
