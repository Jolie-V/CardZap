<?php
session_start();
include_once "db.php";

if (!isset($_SESSION['user_info_id'])) exit;

$currentUserId = $_SESSION['user_info_id'];
$q = "%" . trim($_POST['q'] ?? '') . "%";

$stmt = $conn->prepare("
    SELECT user_info_id, full_name, course, photo
    FROM user_info
    WHERE user_type = 'S'
      AND user_info_id != ?
      AND full_name LIKE ?
      AND user_info_id NOT IN (
        SELECT IF(user_one = ?, user_two, user_one)
        FROM friends
        WHERE user_one = ? OR user_two = ?
      )
      AND user_info_id NOT IN (
        SELECT CASE
            WHEN sender = ? THEN receiver
            ELSE sender
        END
        FROM friend_request
        WHERE (sender = ? OR receiver = ?)
          AND status = 'pending'
      )
");
$stmt->bind_param("isiiiiii", 
    $currentUserId, $q, 
    $currentUserId, $currentUserId, $currentUserId,
    $currentUserId, $currentUserId, $currentUserId
);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    echo "<tr><td colspan='4'>No students found.</td></tr>";
    exit;
}

while ($row = $res->fetch_assoc()) {
    $photo = $row['photo'] ? htmlspecialchars($row['photo']) : '../css/default-avatar.png';
    echo "
      <tr>
        <td><img src='{$photo}' class='student-avatar'></td>
        <td>" . htmlspecialchars($row['full_name']) . "</td>
        <td>" . htmlspecialchars($row['course']) . "</td>
        <td><button class='add-request-btn btn btn-primary' data-id='{$row['user_info_id']}'>Add Friend</button></td>
      </tr>
    ";
}
