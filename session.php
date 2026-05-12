<?php
// session.php - Handle user authentication and sessions

session_start();

include 'config.php';

// Function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['role']);
}

// Function to check if user has specific role
function hasRole($role) {
    return isset($_SESSION['role']) && $_SESSION['role'] === $role;
}

// Function to require specific role
function requireRole($role) {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit();
    }
    if (!hasRole($role) && !hasRole('admin')) {
        header('Location: index.php?error=unauthorized');
        exit();
    }
}

// Function to require login
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit();
    }
}

// Function to logout
function logout() {
    session_destroy();
    header('Location: login.php');
    exit();
}
?>