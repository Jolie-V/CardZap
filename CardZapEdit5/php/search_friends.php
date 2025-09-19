<?php
session_start();
include_once "db.php";

if (!isset($_SESSION['user_info_id'])) exit;

$currentUserId = $_SESSION['user_info_id'];
$q = "%" . ($_POST['q'] ?? '') . "%";

$stmt = $conn->prepare("
    SELECT ui.user_info_id, ui.full_name, ui.course, ui.photo
    FROM friends f
    JOIN user_info ui ON (ui.user_info_id = IF(f.user_one = ?, f.user_two, f.user_one))
    WHERE (f.user_one = ? OR f.user_two = ?)
      AND ui.user_info_id != ?
      AND ui.user_type = 'S'
      AND ui.full_name LIKE ?
");
$stmt->bind_param("iiiis", $currentUserId, $currentUserId, $currentUserId, $currentUserId, $q);
$stmt->execute();
$res = $stmt->get_result();

while ($row = $res->fetch_assoc()) {
    $photo = $row['photo'] ? htmlspecialchars($row['photo']) : '../css/default-avatar.png';
    echo "
      <tr>
        <td><img src='{$photo}' class='student-avatar'></td>
        <td>" . htmlspecialchars($row['full_name']) . "</td>
        <td>" . htmlspecialchars($row['course']) . "</td>
        <td><button class='unfriend-btn btn btn-danger' data-id='{$row['user_info_id']}'>Unfriend</button></td>
      </tr>
    ";
}
