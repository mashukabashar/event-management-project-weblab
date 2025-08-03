<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Prevent caching (for back button)
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Location: login.php");
exit;
