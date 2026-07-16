<?php
session_start();

// Hardcoded admin credentials
$admin_username = 'admin';
$admin_password = 'password';

// Check if logged in
function check_login() {
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header('Location: login.php');
        exit;
    }
}
?>
