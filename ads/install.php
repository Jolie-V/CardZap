<?php
// Install script to create database and tables
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$db_host = getenv('DB_HOST') ?: 'localhost';
$db_name = getenv('DB_NAME') ?: 'flashlearn';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASS') ?: '';
$db_port = (int)(getenv('DB_PORT') ?: 3306);

try {
	$root = new mysqli($db_host, $db_user, $db_pass, '', $db_port);
	$root->set_charset('utf8mb4');
	$root->query('CREATE DATABASE IF NOT EXISTS `'.$db_name.'` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
	$root->close();
	$conn = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);
	$conn->set_charset('utf8mb4');
} catch (Throwable $e) {
	die('Database connection failed: '.$e->getMessage());
}

function q($sql){ global $conn; $conn->query($sql); }

// Core tables (from spec + additions)
q('CREATE TABLE IF NOT EXISTS user_info (
	user_info_id INT AUTO_INCREMENT PRIMARY KEY,
	photo VARCHAR(255) NULL,
	full_name VARCHAR(120) NOT NULL,
	e_mail VARCHAR(120) NOT NULL UNIQUE,
	pass_word VARCHAR(255) NOT NULL,
	contact_no VARCHAR(50) NULL,
	course VARCHAR(100) NULL,
	user_type ENUM("S","T","A") NOT NULL,
	user_status ENUM("A","IA") NOT NULL DEFAULT "A",
	date_created DATETIME NULL,
	date_updated DATETIME NULL
) ENGINE=InnoDB');

q('CREATE TABLE IF NOT EXISTS login_logs (
	login_id INT AUTO_INCREMENT PRIMARY KEY,
	user_info_id INT NULL,
	date_login DATETIME NOT NULL,
	INDEX(user_info_id),
	FOREIGN KEY (user_info_id) REFERENCES user_info(user_info_id) ON DELETE SET NULL
) ENGINE=InnoDB');

q('CREATE TABLE IF NOT EXISTS friends (
	friends_id INT AUTO_INCREMENT PRIMARY KEY,
	user_one INT NOT NULL,
	user_two INT NOT NULL,
	UNIQUE KEY unique_pair (LEAST(user_one,user_two), GREATEST(user_one,user_two)),
	FOREIGN KEY (user_one) REFERENCES user_info(user_info_id) ON DELETE CASCADE,
	FOREIGN KEY (user_two) REFERENCES user_info(user_info_id) ON DELETE CASCADE
) ENGINE=InnoDB');

q('CREATE TABLE IF NOT EXISTS friends_requests (
	fr_id INT AUTO_INCREMENT PRIMARY KEY,
	sender INT NOT NULL,
	receiver INT NOT NULL,
	FOREIGN KEY (sender) REFERENCES user_info(user_info_id) ON DELETE CASCADE,
	FOREIGN KEY (receiver) REFERENCES user_info(user_info_id) ON DELETE CASCADE
) ENGINE=InnoDB');

// Subjects and enrollments
q('CREATE TABLE IF NOT EXISTS subjects (
	subject_id INT AUTO_INCREMENT PRIMARY KEY,
	owner_teacher_user_id INT NOT NULL,
	subject_name VARCHAR(160) NOT NULL,
	subject_photo_url VARCHAR(255) NULL,
	subject_code VARCHAR(32) NOT NULL UNIQUE,
	date_created DATETIME NOT NULL,
	date_updated DATETIME NOT NULL,
	FOREIGN KEY (owner_teacher_user_id) REFERENCES user_info(user_info_id) ON DELETE CASCADE
) ENGINE=InnoDB');

q('CREATE TABLE IF NOT EXISTS enrollments (
	enrollment_id INT AUTO_INCREMENT PRIMARY KEY,
	subject_id INT NOT NULL,
	student_user_id INT NOT NULL,
	status ENUM("PENDING","ACCEPTED","DECLINED") NOT NULL DEFAULT "PENDING",
	date_created DATETIME NOT NULL,
	UNIQUE KEY unique_enroll (subject_id, student_user_id),
	FOREIGN KEY (subject_id) REFERENCES subjects(subject_id) ON DELETE CASCADE,
	FOREIGN KEY (student_user_id) REFERENCES user_info(user_info_id) ON DELETE CASCADE
) ENGINE=InnoDB');

q('CREATE TABLE IF NOT EXISTS card_decks (
	deck_id INT AUTO_INCREMENT PRIMARY KEY,
	owner_user_id INT NOT NULL,
	title VARCHAR(160) NOT NULL,
	color VARCHAR(16) NULL,
	game_mode ENUM("classic","quiz") NOT NULL DEFAULT "classic",
	date_created DATETIME NOT NULL,
	date_updated DATETIME NOT NULL,
	FOREIGN KEY (owner_user_id) REFERENCES user_info(user_info_id) ON DELETE CASCADE
) ENGINE=InnoDB');

q('CREATE TABLE IF NOT EXISTS cards (
	card_id INT AUTO_INCREMENT PRIMARY KEY,
	deck_id INT NOT NULL,
	front_text TEXT NOT NULL,
	back_text TEXT NOT NULL,
	order_index INT NOT NULL DEFAULT 0,
	FOREIGN KEY (deck_id) REFERENCES card_decks(deck_id) ON DELETE CASCADE
) ENGINE=InnoDB');

q('CREATE TABLE IF NOT EXISTS subject_decks (
	id INT AUTO_INCREMENT PRIMARY KEY,
	subject_id INT NOT NULL,
	deck_id INT NOT NULL,
	UNIQUE KEY unique_pair (subject_id, deck_id),
	FOREIGN KEY (subject_id) REFERENCES subjects(subject_id) ON DELETE CASCADE,
	FOREIGN KEY (deck_id) REFERENCES card_decks(deck_id) ON DELETE CASCADE
) ENGINE=InnoDB');

// Progress analytics
q('CREATE TABLE IF NOT EXISTS deck_progress (
	progress_id INT AUTO_INCREMENT PRIMARY KEY,
	deck_id INT NOT NULL,
	user_id INT NOT NULL,
	correct_count INT NOT NULL DEFAULT 0,
	total_answered INT NOT NULL DEFAULT 0,
	UNIQUE KEY unique_user_deck (deck_id, user_id),
	FOREIGN KEY (deck_id) REFERENCES card_decks(deck_id) ON DELETE CASCADE,
	FOREIGN KEY (user_id) REFERENCES user_info(user_info_id) ON DELETE CASCADE
) ENGINE=InnoDB');

// Co-op scaffolding
q('CREATE TABLE IF NOT EXISTS coop_lobbies (
	lobby_id INT AUTO_INCREMENT PRIMARY KEY,
	host_user_id INT NOT NULL,
	lobby_code VARCHAR(16) NOT NULL UNIQUE,
	created_at DATETIME NOT NULL,
	FOREIGN KEY (host_user_id) REFERENCES user_info(user_info_id) ON DELETE CASCADE
) ENGINE=InnoDB');

q('CREATE TABLE IF NOT EXISTS coop_members (
	id INT AUTO_INCREMENT PRIMARY KEY,
	lobby_id INT NOT NULL,
	user_id INT NOT NULL,
	UNIQUE KEY unique_member (lobby_id, user_id),
	FOREIGN KEY (lobby_id) REFERENCES coop_lobbies(lobby_id) ON DELETE CASCADE,
	FOREIGN KEY (user_id) REFERENCES user_info(user_info_id) ON DELETE CASCADE
) ENGINE=InnoDB');

// Recent decks (for recent pages)
q('CREATE TABLE IF NOT EXISTS recent_decks (
	id INT AUTO_INCREMENT PRIMARY KEY,
	user_id INT NOT NULL,
	deck_id INT NOT NULL,
	accessed_at DATETIME NOT NULL,
	UNIQUE KEY unique_recent (user_id, deck_id),
	FOREIGN KEY (user_id) REFERENCES user_info(user_info_id) ON DELETE CASCADE,
	FOREIGN KEY (deck_id) REFERENCES card_decks(deck_id) ON DELETE CASCADE
) ENGINE=InnoDB');

echo '<!doctype html><meta charset="utf-8"><style>body{font-family:system-ui;padding:24px;background:#0b1220;color:#e5e7eb}</style>';
echo '<h1>Installation complete</h1>';
echo '<p>Database and tables are ready.</p>';
// Create default admin if not exists
$exists = $conn->query("SELECT user_info_id FROM user_info WHERE e_mail='admin@local'");
if ($exists->num_rows === 0) {
    $hash = password_hash('admin123', PASSWORD_BCRYPT);
    $stmt = $conn->prepare('INSERT INTO user_info (full_name, e_mail, pass_word, user_type, user_status, date_created, date_updated) VALUES ("Administrator", "admin@local", ?, "A", "A", NOW(), NOW())');
    $stmt->bind_param('s', $hash);
    $stmt->execute();
    echo '<p>Default admin created: <code>admin@local</code> / <code>admin123</code></p>';
}
echo '<p><a href="app.php?route=signup">Create your first account</a></p>';


