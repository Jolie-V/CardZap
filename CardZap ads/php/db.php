<?php
// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'cardzap_db';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to utf8mb4
$conn->set_charset("utf8mb4");

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $database";
$conn->query($sql);

// Select the database
$conn->select_db($database);

// Create tables if they don't exist
$tables = [
    "user_info" => "
        CREATE TABLE IF NOT EXISTS user_info (
            user_info_id INT AUTO_INCREMENT PRIMARY KEY,
            photo VARCHAR(255) DEFAULT NULL,
            full_name VARCHAR(100) NOT NULL,
            e_mail VARCHAR(100) UNIQUE NOT NULL,
            pass_word VARCHAR(255) NOT NULL,
            contact_no VARCHAR(20) DEFAULT NULL,
            course VARCHAR(100) DEFAULT NULL,
            user_type ENUM('S', 'T', 'A') NOT NULL,
            user_status ENUM('A', 'IA') DEFAULT 'A',
            date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            date_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )
    ",
    
    "login_logs" => "
        CREATE TABLE IF NOT EXISTS login_logs (
            login_id INT AUTO_INCREMENT PRIMARY KEY,
            user_info_id INT,
            date_login TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_info_id) REFERENCES user_info(user_info_id) ON DELETE CASCADE
        )
    ",
    
    "friends" => "
        CREATE TABLE IF NOT EXISTS friends (
            friends_id INT AUTO_INCREMENT PRIMARY KEY,
            user_one INT NOT NULL,
            user_two INT NOT NULL,
            date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_one) REFERENCES user_info(user_info_id) ON DELETE CASCADE,
            FOREIGN KEY (user_two) REFERENCES user_info(user_info_id) ON DELETE CASCADE,
            UNIQUE KEY unique_friendship (user_one, user_two)
        )
    ",
    
    "friends_requests" => "
        CREATE TABLE IF NOT EXISTS friends_requests (
            fr_id INT AUTO_INCREMENT PRIMARY KEY,
            sender INT NOT NULL,
            receiver INT NOT NULL,
            status ENUM('pending', 'accepted', 'declined') DEFAULT 'pending',
            date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (sender) REFERENCES user_info(user_info_id) ON DELETE CASCADE,
            FOREIGN KEY (receiver) REFERENCES user_info(user_info_id) ON DELETE CASCADE
        )
    ",
    
    "subjects" => "
        CREATE TABLE IF NOT EXISTS subjects (
            subject_id INT AUTO_INCREMENT PRIMARY KEY,
            subject_name VARCHAR(100) NOT NULL,
            subject_code VARCHAR(20) UNIQUE NOT NULL,
            subject_photo VARCHAR(255) DEFAULT NULL,
            teacher_id INT NOT NULL,
            description TEXT DEFAULT NULL,
            is_active BOOLEAN DEFAULT TRUE,
            date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            date_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (teacher_id) REFERENCES user_info(user_info_id) ON DELETE CASCADE
        )
    ",
    
    "enrollments" => "
        CREATE TABLE IF NOT EXISTS enrollments (
            enrollment_id INT AUTO_INCREMENT PRIMARY KEY,
            student_id INT NOT NULL,
            subject_id INT NOT NULL,
            status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
            date_enrolled TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            date_approved TIMESTAMP NULL,
            FOREIGN KEY (student_id) REFERENCES user_info(user_info_id) ON DELETE CASCADE,
            FOREIGN KEY (subject_id) REFERENCES subjects(subject_id) ON DELETE CASCADE,
            UNIQUE KEY unique_enrollment (student_id, subject_id)
        )
    ",
    
    "card_decks" => "
        CREATE TABLE IF NOT EXISTS card_decks (
            deck_id INT AUTO_INCREMENT PRIMARY KEY,
            deck_name VARCHAR(100) NOT NULL,
            creator_id INT NOT NULL,
            subject_id INT DEFAULT NULL,
            card_color VARCHAR(20) DEFAULT 'blue',
            game_mode ENUM('classic', 'quiz') DEFAULT 'classic',
            is_public BOOLEAN DEFAULT FALSE,
            date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            date_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (creator_id) REFERENCES user_info(user_info_id) ON DELETE CASCADE,
            FOREIGN KEY (subject_id) REFERENCES subjects(subject_id) ON DELETE SET NULL
        )
    ",
    
    "cards" => "
        CREATE TABLE IF NOT EXISTS cards (
            card_id INT AUTO_INCREMENT PRIMARY KEY,
            deck_id INT NOT NULL,
            question TEXT NOT NULL,
            answer TEXT NOT NULL,
            card_order INT DEFAULT 0,
            date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (deck_id) REFERENCES card_decks(deck_id) ON DELETE CASCADE
        )
    ",
    
    "study_sessions" => "
        CREATE TABLE IF NOT EXISTS study_sessions (
            session_id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            deck_id INT NOT NULL,
            session_type ENUM('classic', 'quiz') NOT NULL,
            score INT DEFAULT 0,
            total_cards INT DEFAULT 0,
            completed_cards INT DEFAULT 0,
            start_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            end_time TIMESTAMP NULL,
            FOREIGN KEY (user_id) REFERENCES user_info(user_info_id) ON DELETE CASCADE,
            FOREIGN KEY (deck_id) REFERENCES card_decks(deck_id) ON DELETE CASCADE
        )
    ",
    
    "coop_lobbies" => "
        CREATE TABLE IF NOT EXISTS coop_lobbies (
            lobby_id INT AUTO_INCREMENT PRIMARY KEY,
            lobby_name VARCHAR(100) NOT NULL,
            creator_id INT NOT NULL,
            deck_id INT NOT NULL,
            max_players INT DEFAULT 4,
            current_players INT DEFAULT 1,
            status ENUM('waiting', 'playing', 'finished') DEFAULT 'waiting',
            date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            date_started TIMESTAMP NULL,
            date_finished TIMESTAMP NULL,
            FOREIGN KEY (creator_id) REFERENCES user_info(user_info_id) ON DELETE CASCADE,
            FOREIGN KEY (deck_id) REFERENCES card_decks(deck_id) ON DELETE CASCADE
        )
    ",
    
    "coop_participants" => "
        CREATE TABLE IF NOT EXISTS coop_participants (
            participant_id INT AUTO_INCREMENT PRIMARY KEY,
            lobby_id INT NOT NULL,
            user_id INT NOT NULL,
            score INT DEFAULT 0,
            position INT DEFAULT 0,
            joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (lobby_id) REFERENCES coop_lobbies(lobby_id) ON DELETE CASCADE,
            FOREIGN KEY (user_id) REFERENCES user_info(user_info_id) ON DELETE CASCADE,
            UNIQUE KEY unique_participant (lobby_id, user_id)
        )
    ",
    
    "recent_cards" => "
        CREATE TABLE IF NOT EXISTS recent_cards (
            recent_id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            deck_id INT NOT NULL,
            last_accessed TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES user_info(user_info_id) ON DELETE CASCADE,
            FOREIGN KEY (deck_id) REFERENCES card_decks(deck_id) ON DELETE CASCADE,
            UNIQUE KEY unique_recent (user_id, deck_id)
        )
    "
];

// Execute table creation queries
foreach ($tables as $table_name => $sql) {
    if (!$conn->query($sql)) {
        error_log("Error creating table $table_name: " . $conn->error);
    }
}

// Insert default admin user if not exists
$admin_check = $conn->query("SELECT user_info_id FROM user_info WHERE user_type = 'A' LIMIT 1");
if ($admin_check->num_rows == 0) {
    $admin_password = password_hash('admin123', PASSWORD_DEFAULT);
    $conn->query("INSERT INTO user_info (full_name, e_mail, pass_word, user_type) VALUES ('Admin User', 'admin@cardzap.com', '$admin_password', 'A')");
}

// Helper functions
function sanitize_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $conn->real_escape_string($data);
}

function generate_subject_code() {
    return 'SUBJ' . strtoupper(substr(md5(uniqid()), 0, 6));
}

function is_logged_in() {
    return isset($_SESSION['user_info_id']);
}

function require_login() {
    if (!is_logged_in()) {
        header("Location: loginpage.php");
        exit();
    }
}

function get_user_type() {
    return $_SESSION['user_type'] ?? null;
}

function require_user_type($allowed_types) {
    require_login();
    $user_type = get_user_type();
    if (!in_array($user_type, $allowed_types)) {
        header("Location: loginpage.php");
        exit();
    }
}
?>
