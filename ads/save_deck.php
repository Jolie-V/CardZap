<?php
session_start();
require_once __DIR__ . '/db.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user'])) { echo json_encode(['error'=>'unauth']); exit; }
$user = $_SESSION['user'];

$payload = json_decode(file_get_contents('php://input'), true) ?: [];
$title = trim($payload['title'] ?? 'Untitled');
$color = preg_replace('/[^0-9a-fA-F]/','', (string)($payload['color'] ?? '0ea5e9'));
$game = in_array(($payload['gameMode'] ?? 'classic'), ['classic','quiz'], true) ? $payload['gameMode'] : 'classic';

$stmt = db()->prepare('INSERT INTO card_decks (owner_user_id, title, color, game_mode, date_created, date_updated) VALUES (?, ?, ?, ?, NOW(), NOW())');
$stmt->bind_param('isss', $user['user_info_id'], $title, $color, $game);
$stmt->execute();
$did = db()->insert_id;

// Create 5 placeholder cards
for($i=1;$i<=5;$i++){
	$front = 'Question '.$i;
	$back = 'Answer '.$i;
	$stmt = db()->prepare('INSERT INTO cards (deck_id, front_text, back_text, order_index) VALUES (?, ?, ?, ?)');
	$stmt->bind_param('issi', $did, $front, $back, $i);
	$stmt->execute();
}

echo json_encode(['ok'=>true,'did'=>$did]);
exit;


