<?php

// Database connection details
// IMPORTANT: Replace these with your actual database credentials
$servername = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "Event-management"; // The name of your database

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = "";
    $message_type = "";

    // Create a new database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        $message = "Connection failed: " . $conn->connect_error;
        $message_type = "error";
    } else {
        // Get and sanitize form data
        $service_name = htmlspecialchars($_POST['service_name']);
        $description = htmlspecialchars($_POST['description']);
        $price = htmlspecialchars($_POST['price']);
        $category = htmlspecialchars($_POST['category']);

        // Basic validation
        if (empty($service_name) || empty($description) || empty($price) || empty($category)) {
            $message = "Please fill in all required fields.";
            $message_type = "error";
        } else {
            // Prepare an SQL statement to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO services (service_name, description, price, category) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssds", $service_name, $description, $price, $category); // 'ssds' indicates string, string, double, string

            // Execute the statement and check for success
            if ($stmt->execute()) {
                $message = "New service uploaded successfully!";
                $message_type = "success";
            } else {
                $message = "Error: " . $stmt->error;
                $message_type = "error";
            }

            // Close the statement
            $stmt->close();
        }

        // Close the database connection
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Services</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .navbar {
            background-color: #333;
            overflow: hidden;
            padding: 14px 16px;
            text-align: center;
        }
        .navbar a {
            display: inline-block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-size: 17px;
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        .container {
            padding: 20px;
            margin: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        p {
            color: #666;
            text-align: center;
            font-size: 18px;
        }
        .message-box {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input[type="text"],
        .form-group textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group textarea {
            resize: vertical;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .form-group button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="vendor_dashboard.php">Vendor Dashboard</a>
    <a href="assigned_events.php">Assigned Events</a>
    <a href="upload_services.php">Upload Services</a>
    <a href="messages.php">Messages</a>
    <a href="profile.php">Profile</a>
    <a href="logout.php">Logout</a>
</div>

<div class="container">
    <h1>Upload Services</h1>
    <p>Use this page to add new services to your profile.</p>

    <?php
    // Display the message box if a message exists
    if (!empty($message)) {
        echo "<div class='message-box {$message_type}'>{$message}</div>";
    }
    ?>

    <form action="upload_services.php" method="post">
        <div class="form-group">
            <label for="service_name">Service Name:</label>
            <input type="text" id="service_name" name="service_name" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="text" id="price" name="price" required>
        </div>
        <div class="form-group">
            <label for="category">Category:</label>
            <input type="text" id="category" name="category" required>
        </div>
        <div class="form-group">
            <button type="submit">Upload Service</button>
        </div>
    </form>
</div>

</body>
</html>
