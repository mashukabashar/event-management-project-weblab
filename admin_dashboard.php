<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: register.php");
    exit;
}

// You can use $_SESSION['user_name'] and $_SESSION['user_role'] here
echo "<h1>Welcome, " . htmlspecialchars($_SESSION['user_name']) . "</h1>";
echo "<p>Role: " . htmlspecialchars($_SESSION['user_role']) . "</p>";
?>
