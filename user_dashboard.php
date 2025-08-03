<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name']) || !isset($_SESSION['user_role'])) {
    header("Location: login.php");
    exit;
}

$name = $_SESSION['user_name'];
$role = $_SESSION['user_role'];

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard | Eventify</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    body {
      background-color: #f9f9f9;
      color: #333;
      line-height: 1.6;
    }

    nav {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #b8be9d;
      padding: 15px 40px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      border-radius: 0 0 10px 10px;
    }
    .logo-container {
      display: flex;
      align-items: center;
      gap: 15px;
    }
    .logo {
      width: 80px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.2);
    }
    .text1 {
      font-size: 32px;
      font-weight: 700;
      color: #222;
      letter-spacing: 2px;
    }

    .menu-container {
      display: flex;
      gap: 25px;
    }
    .menu-container li {
      list-style: none;
    }
    .menu-container li a {
      text-decoration: none;
      color: #222;
      padding: 8px 12px;
      font-weight: 600;
      border-radius: 6px;
      transition: background-color 0.3s ease;
    }
    .menu-container li a:hover {
      background-color: #5a8545;
      color: white;
    }

    .banner {
      position: relative;
      background-image: url('image-mashuka/Bird-and-Floral-Art-Wallpaper-Mural-Living-Room_1204f935-1c1d-4d7e-8dd3-9b21970d9cc9.jpg');
      background-size: cover;
      background-position: center;
      height: 450px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 0 0 15px 15px;
      box-shadow: inset 0 0 0 2000px rgba(0, 0, 0, 0.35);
      margin-bottom: 40px;
    }

    .overlay-text {
      color: #fff;
      text-align: center;
      font-size: 38px;
      font-weight: 700;
      text-shadow: 3px 3px 8px rgba(0, 0, 0, 0.7);
    }

    main {
      max-width: 850px;
      margin: 0 auto 60px auto;
      padding: 30px;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    }

    main h2 {
      margin-bottom: 15px;
      color: #4a7023;
    }
    main p {
      font-size: 18px;
      line-height: 1.5;
      letter-spacing: 0.02em;
    }

    @media (max-width: 768px) {
      nav {
        flex-direction: column;
        gap: 15px;
        padding: 20px;
      }
      .menu-container {
        flex-wrap: wrap;
        justify-content: center;
      }
      .banner {
        height: 300px;
      }
      .overlay-text {
        font-size: 26px;
      }
      main {
        padding: 20px;
      }
    }
  </style>
</head>
<body>

<nav>
  <div class="logo-container">
    <img class="logo" src="image-mashuka/360_F_1112587129_wXvi0f4jnwVeZHlJiEZJ87QcdXv67GEf.jpg" alt="Eventify Logo" />
    <h1 class="text1">EVENTIFY <?php echo ucfirst($role); ?></h1>
  </div>
  <ul class="menu-container">
    <li><a href="#">Dashboard</a></li>
    <li><a href="budget.php">Budget Tracker</a></li>
    <li><a href="guests.php">Guest List</a></li>
    <li><a href="?logout=1">Logout</a></li>
  </ul>
</nav>

<section class="banner">
  <div class="overlay-text">
    <?php echo "Welcome, <span style='color:#aadd77'>" . htmlspecialchars($name) . "</span><br>Your Event Partner Awaits"; ?>
  </div>
</section>

</body>
</html>
