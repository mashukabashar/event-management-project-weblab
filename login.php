<?php
session_start();
$conn = new mysqli("localhost", "root", "", "Event-management");

$login_error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email = '$email' LIMIT 1");

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] === 'admin') {
                header("Location: admin_dashboard.php");
            } elseif ($user['role'] === 'vendor') {
                header("Location: vendor_dashboard.php");
            } else {
                header("Location: user_dashboard.php");
            }
            exit;
        } else {
            $login_error = "Invalid password!";
        }
    } else {
        $login_error = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | Event Management</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap');
    * { box-sizing: border-box; }

    body {
        font-family: 'Montserrat', sans-serif;
        background: linear-gradient(135deg, #43cea2 0%, #185a9d 100%);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .container {
        background: #fff;
        padding: 40px;
        border-radius: 12px;
        width: 380px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    h2 {
        text-align: center;
        margin-bottom: 24px;
        color: #185a9d;
    }

    form {
        display: flex;
        flex-direction: column;
    }

    label {
        font-weight: 600;
        margin-bottom: 6px;
        color: #444;
    }

    input {
        padding: 10px 14px;
        margin-bottom: 20px;
        border: 1.8px solid #ccc;
        border-radius: 8px;
        font-size: 16px;
    }

    input:focus {
        border-color: #185a9d;
        outline: none;
    }

    button {
        background-color: #185a9d;
        color: white;
        border: none;
        padding: 12px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.3s ease;
    }

    button:hover {
        background-color: #134f7c;
    }

    .error {
        background: #ffe5e5;
        color: #d8000c;
        padding: 10px;
        border: 1px solid #d8000c;
        border-radius: 6px;
        margin-bottom: 15px;
        text-align: center;
    }

    @media (max-width: 420px) {
        .container { width: 90%; }
    }
  </style>
</head>
<body>

<div class="container">
    <h2>Login to Your Account</h2>

    <?php if ($login_error): ?>
        <div class="error"><?= $login_error ?></div>
    <?php endif; ?>

    <form method="POST">
        <label for="email">Email Address</label>
        <input id="email" type="email" name="email" placeholder="enter email" required />

        <label for="password">Password</label>
        <input id="password" type="password" name="password" placeholder="••••••••" required />

        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>
