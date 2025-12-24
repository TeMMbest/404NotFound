<?php
$servername = "localhost";
$username = "hardcoded";
$pass = "";
$database = "store_db";


function getDBConnection() {
    global $servername, $username, $pass, $database;
    $conn = new mysqli($servername, $username, $pass, $database);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    return $conn;
}


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['username']);
}


function hasPosition($position) {
    return isLoggedIn() && $_SESSION['position'] === $position;
}


function canManageItems() {
    return hasPosition('Admin') || hasPosition('Encoder');
}


function canManageUsers() {
    return hasPosition('Admin');
}


function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit();
    }
}


function requirePosition($position) {
    requireLogin();
    if (!hasPosition($position)) {
        header('Location: dashboard.php?error=access_denied');
        exit();
    }
}

?>

