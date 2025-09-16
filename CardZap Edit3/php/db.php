<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "cardzap";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function require_user_type($allowed_types) {
    if (!isset($_SESSION['user_type']) || !in_array($_SESSION['user_type'], $allowed_types)) {
        header('Location: login.php'); // or an error page
        exit();
    }
}

?>