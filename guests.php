<?php
session_start();
$conn = new mysqli("localhost", "root", "", "Event-management");

$editing = false;
$edit_id = '';
$edit_name = '';
$edit_contact = '';

if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $contact = $_POST['contact'];

    if (!empty($_POST['edit_id'])) {
        $edit_id = $_POST['edit_id'];
        $conn->query("UPDATE guests SET name='$name', contact='$contact' WHERE id=$edit_id");
    } else {
        $conn->query("INSERT INTO guests (user_id, name, contact) VALUES (1, '$name', '$contact')");
    }
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM guests WHERE id = $id");
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

if (isset($_GET['edit'])) {
    $editing = true;
    $edit_id = $_GET['edit'];
    $edit_data = $conn->query("SELECT * FROM guests WHERE id = $edit_id")->fetch_assoc();
    $edit_name = $edit_data['name'];
    $edit_contact = $edit_data['contact'];
}

$result = $conn->query("SELECT * FROM guests WHERE user_id = 1");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Guest List</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    * { box-sizing: border-box; }
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f0f2f5;
      padding: 40px;
      color: #333;
    }

    h2 {
      text-align: center;
      color: #333;
      margin-bottom: 30px;
    }

    form {
      background: #fff;
      padding: 20px 30px;
      border-radius: 10px;
      max-width: 500px;
      margin: auto;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      justify-content: center;
    }

    form input {
      padding: 10px;
      font-size: 16px;
      width: 45%;
      border: 1px solid #ccc;
      border-radius: 8px;
    }

    form button {
      padding: 10px 20px;
      background: #007bff;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s;
    }

    form button:hover {
      background: #0056b3;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 40px;
      background: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    th, td {
      padding: 14px 20px;
      text-align: left;
    }

    th {
      background: #343a40;
      color: white;
    }

    tr:nth-child(even) {
      background: #f9f9f9;
    }

    tr:hover {
      background: #eef2f5;
    }

    .action-link {
      color: #007bff;
      text-decoration: none;
      font-weight: bold;
      margin-right: 10px;
    }

    .action-link:hover {
      text-decoration: underline;
    }

    .delete-link {
      color: #dc3545;
    }

    @media (max-width: 600px) {
      form {
        flex-direction: column;
        gap: 10px;
      }

      form input {
        width: 100%;
      }
    }
  </style>
</head>
<body>

<h2><?= $editing ? 'Edit Guest' : 'Add Guest' ?></h2>

<form method="POST">
  <input type="text" name="name" placeholder="Guest Name" value="<?= htmlspecialchars($edit_name) ?>" required>
  <input type="text" name="contact" placeholder="Contact Info" value="<?= htmlspecialchars($edit_contact) ?>" required>
  <input type="hidden" name="edit_id" value="<?= $edit_id ?>">
  <button type="submit" name="add"><?= $editing ? 'Update' : 'Add Guest' ?></button>
</form>

<table>
  <tr>
    <th>Name</th>
    <th>Contact</th>
    <th>Status</th>
    <th>Action</th>
  </tr>
  <?php while($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($row['name']) ?></td>
      <td><?= htmlspecialchars($row['contact']) ?></td>
      <td><?= htmlspecialchars($row['rsvp_status']) ?: 'Pending' ?></td>
      <td>
        <a class="action-link" href="?edit=<?= $row['id'] ?>">Edit</a>
        <a class="action-link delete-link" href="?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this guest?')">Delete</a>
      </td>
    </tr>
  <?php endwhile; ?>
</table>

</body>
</html>
