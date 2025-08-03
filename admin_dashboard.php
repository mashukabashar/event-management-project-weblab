<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard | Event Management</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');
    body {
      font-family: 'Inter', sans-serif;
      background: #f5f5f7;
      margin: 0;
      padding: 0;
      color: #333;
    }
    header {
      background-color: #4a148c;
      color: white;
      padding: 20px 40px;
      text-align: center;
    }
    nav {
      background: #6a1b9a;
      padding: 10px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    nav a {
      color: white;
      text-decoration: none;
      margin-right: 20px;
      font-weight: 600;
      transition: color 0.3s;
    }
    nav a:hover {
      color: #ce93d8;
    }
    .container {
      max-width: 1000px;
      margin: 40px auto;
      background: white;
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    h1 {
      margin-top: 0;
      font-size: 2.5rem;
      color: #4a148c;
    }
    .info {
      font-size: 1.2rem;
      margin-bottom: 30px;
    }
    .logout-btn {
      background-color: #a527b8;
      border: none;
      color: white;
      padding: 10px 18px;
      font-size: 1rem;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s;
      text-decoration: none;
    }
    .logout-btn:hover {
      background-color: #7b1fa2;
    }
    .dashboard-links a {
      display: inline-block;
      margin: 10px 20px 10px 0;
      padding: 14px 22px;
      background: #7b1fa2;
      color: white;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      transition: background-color 0.3s;
    }
    .dashboard-links a:hover {
      background: #4a148c;
    }
  </style>
</head>
<body>

<header>
  <h1>Admin Dashboard</h1>
</header>

<nav>
  <div>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?></div>
  <a href="logout.php" class="logout-btn">Logout</a>
</nav>

<div class="container">
  <p class="info">You are logged in as <strong>Admin</strong>.</p>

  <div class="dashboard-links">
    <a href="manage_users.php">Manage Users</a>
    <a href="manage_vendors.php">Manage Vendors</a>
    <a href="budget.php">Budget Tracker</a>
    <a href="reports.php">View Reports</a>
    <a href="settings.php">Settings</a>
  </div>

  <p>Use the above options to manage the Event Management system effectively.</p>
</div>

</body>
</html>
