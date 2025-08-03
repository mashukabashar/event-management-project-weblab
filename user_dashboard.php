<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'couple') {
    header("Location: login.php");
    exit;
}

$user_name = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f2f4f7;
      margin: 0;
      padding: 50px;
    }

    .dashboard {
      max-width: 700px;
      margin: auto;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      text-align: center;
    }

    h2 {
      color: #4a148c;
      margin-bottom: 10px;
    }

    .links {
      display: flex;
      flex-direction: column;
      gap: 15px;
      margin-top: 30px;
    }

    a {
      background: #764ba2;
      color: white;
      text-decoration: none;
      padding: 14px;
      border-radius: 8px;
      font-weight: bold;
      transition: background 0.3s ease;
    }

    a:hover {
      background: #5a3a8c;
    }

    .logout {
      margin-top: 30px;
      font-size: 14px;
    }

    .logout a {
      color:white;
      text-decoration: none;
    }
  </style>
</head>
<body>

<div class="dashboard">
  <h2>Welcome, <?= htmlspecialchars($user_name) ?> 👋</h2>
  <p>Your wedding planning dashboard</p>

  <div class="links">
    <a href="guests.php">👥 Guest List</a>
    <a href="budget.php">💰 Budget Tracker</a>
  </div>

  <div class="logout">
    <p><a href="logout.php">Logout</a></p>
  </div>
</div>

</body>
</html>
