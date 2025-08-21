<?php
// Basic MySQL connection helper for the FlashLearn app
// Reads from environment variables when available, with sensible defaults

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$db_host = getenv('DB_HOST') ?: 'localhost';
$db_name = getenv('DB_NAME') ?: 'flashlearn';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASS') ?: '';
$db_port = getenv('DB_PORT') ?: 3306;

try {
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name, (int)$db_port);
    if ($conn->connect_errno) {
        throw new Exception('Connection failed: ' . $conn->connect_error);
    }
    $conn->set_charset('utf8mb4');
} catch (Throwable $e) {
    // If database does not exist yet, $conn may be null here; installer will create it
    $conn = null;
}

function db(): mysqli {
    global $conn;
    if (!$conn) {
        throw new Exception('Database connection not initialized. Please run install.php to set up the database.');
    }
    return $conn;
}

?>


