<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Event-management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Dummy logged-in user (replace with $_SESSION['user_id'] in real app)
$user_id = 1;

$message = "";
$message_type = "";

// Handle vendor selection
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['vendor_id'])) {
    $vendor_id = $_POST['vendor_id'];

    // Check if selected user is a vendor
    $check = $conn->prepare("SELECT role FROM users WHERE id = ?");
    $check->bind_param("i", $vendor_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['role'] === 'vendor') {
            // Insert into vendor_selections
            $stmt = $conn->prepare("INSERT INTO vendor_selections (user_id, vendor_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $user_id, $vendor_id);
            if ($stmt->execute()) {
                $message = "Vendor selected successfully!";
                $message_type = "success";
            } else {
                $message = "Error selecting vendor: " . $stmt->error;
                $message_type = "error";
            }
            $stmt->close();
        } else {
            $message = "Selected user is not a vendor.";
            $message_type = "error";
        }
    } else {
        $message = "Vendor not found.";
        $message_type = "error";
    }
    $check->close();
}

// Get all vendors
$sql = "SELECT id, name FROM users WHERE role = 'vendor'";
$result = $conn->query($sql);

$vendors = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Dummy values for category/rating
        $row['category'] = 'General';
        $row['rating'] = '4.5';
        $vendors[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Select Vendors</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #333;
            text-align: center;
            padding: 14px;
        }
        .navbar a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            display: inline-block;
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        .container {
            max-width: 1000px;
            margin: 30px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
        }
        .message-box {
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
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
        .vendor-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .vendor-card {
            width: 280px;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
        }
        .vendor-card h3 {
            margin-top: 0;
            color: #007bff;
        }
        .vendor-card button {
            width: 100%;
            background: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .vendor-card button:hover {
            background: #218838;
        }
    </style>
</head>
<body>


<div class="container">
    <h1 style="text-align:center;">Select Vendors</h1>
    <p style="text-align:center;">Choose a vendor for your event</p>

    <?php if (!empty($message)): ?>
        <div class="message-box <?= $message_type; ?>">
            <?= htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <?php if (count($vendors) > 0): ?>
        <div class="vendor-list">
            <?php foreach ($vendors as $vendor): ?>
                <div class="vendor-card">
                    <h3><?= htmlspecialchars($vendor['name']); ?></h3>
                    <p><strong>Category:</strong> <?= htmlspecialchars($vendor['category']); ?></p>
                    <p><strong>Rating:</strong> <?= htmlspecialchars($vendor['rating']); ?></p>
                    <form method="POST">
                        <input type="hidden" name="vendor_id" value="<?= $vendor['id']; ?>">
                        <button type="submit">Select Vendor</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p style="text-align:center;">No vendors found.</p>
    <?php endif; ?>
</div>

</body>
</html>
