<?php
session_start();

$conn = new mysqli("localhost", "root", "", "Event-management");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $conn->real_escape_string($_POST['role']);

    // Insert user
    $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
    if ($conn->query($sql) === TRUE) {
        // Get inserted user id
        $user_id = $conn->insert_id;

        // Set session variables
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_role'] = $role;

        // Redirect based on role
        if ($role === 'admin') {
            header("Location: admin_dashboard.php");
        } elseif ($role === 'vendor') {
            header("Location: vendor_dashboard.php");
        } else {
            header("Location: user_dashboard.php");
        }
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Register | Event Management</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap');
        * {
            box-sizing: border-box;
        }
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Montserrat', sans-serif;
            margin: 0; 
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
        }
        .container {
            background: #fff;
            padding: 40px 30px;
            border-radius: 12px;
            width: 380px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        h2 {
            margin-bottom: 24px;
            font-weight: 600;
            text-align: center;
            color: #4a148c;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            font-weight: 600;
            margin-bottom: 6px;
            color: #555;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            padding: 10px 14px;
            margin-bottom: 20px;
            border: 1.8px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        select:focus {
            border-color: #764ba2;
            outline: none;
        }
        button {
            background-color: #764ba2;
            color: white;
            border: none;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #5a3573;
        }
        .success {
            background-color: #d4edda;
            border: 1.5px solid #c3e6cb;
            color: #155724;
            padding: 12px 15px;
            border-radius: 8px;
            margin-top: 15px;
            text-align: center;
            font-weight: 600;
        }
        /* Responsive */
        @media (max-width: 420px) {
            .container {
                width: 90%;
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Create Your Account</h2>
    <form method="POST" action="">
        <label for="name">Full Name</label>
        <input id="name" name="name" type="text" placeholder="Enter Name" required />

        <label for="email">Email Address</label>
        <input id="email" name="email" type="email" placeholder="Enter email" required />

        <label for="password">Password</label>
        <input id="password" name="password" type="password" placeholder="••••••••" required />

        <label for="role">Select Role</label>
        <select id="role" name="role" required>
            <option value="" disabled selected>Select your role</option>
            <option value="client">Client</option>
            <option value="vendor">Vendor</option>
            <option value="admin">Admin</option>
        </select>

        <button type="submit">Register</button>
    </form>
    
    <p style="text-align:center; margin-top: 20px;">
    Already have an account? <a href="login.php" style="color:#764ba2; font-weight:bold; text-decoration:none;">Login</a>
    </p>

</div>

</body>
</html>
