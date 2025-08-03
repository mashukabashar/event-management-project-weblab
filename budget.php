<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "Event-management");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['user_role'];

if (isset($_POST['save'])) {
    if ($user_role === 'client') {
        $cat = $conn->real_escape_string($_POST['category']);
        $amt = floatval($_POST['amount']);
        $date = $_POST['date'];
        $conn->query("INSERT INTO budget (user_id, category, amount, date) VALUES ($user_id, '$cat', $amt, '$date')");
        header("Location: budget.php");
        exit;
    } else {
        $error = "You don't have permission to add budgets.";
    }
}

if (isset($_GET['delete'])) {
    if ($user_role === 'client') {
        $del_id = intval($_GET['delete']);
        $conn->query("DELETE FROM budget WHERE id = $del_id AND user_id = $user_id");
        header("Location: budget.php");
        exit;
    } else {
        $error = "You don't have permission to delete budgets.";
    }
}

if ($user_role === 'admin') {
    $result = $conn->query("SELECT budget.*, users.name AS user_name FROM budget JOIN users ON budget.user_id = users.id ORDER BY date DESC");
} else {
    $result = $conn->query("SELECT * FROM budget WHERE user_id = $user_id ORDER BY date DESC");
}


$edit_mode = false;
if (isset($_GET['edit']) && $user_role === 'couple') {
    $edit_id = intval($_GET['edit']);
    $edit_res = $conn->query("SELECT * FROM budget WHERE id = $edit_id AND user_id = $user_id");
    if ($edit_res && $edit_res->num_rows === 1) {
        $edit_mode = true;
        $edit_row = $edit_res->fetch_assoc();
    }
}

if (isset($_POST['update'])) {
    if ($user_role === 'client') {
        $upd_id = intval($_POST['id']);
        $cat = $conn->real_escape_string($_POST['category']);
        $amt = floatval($_POST['amount']);
        $date = $_POST['date'];
        $conn->query("UPDATE budget SET category = '$cat', amount = $amt, date = '$date' WHERE id = $upd_id AND user_id = $user_id");
        header("Location: budget.php");
        exit;
    } else {
        $error = "You don't have permission to update budgets.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Budget Tracker | Event Management</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');
    * {
      box-sizing: border-box;
    }
    body {
      font-family: 'Inter', sans-serif;
      margin: 0;
      background: #f4f6f8;
      padding: 40px 20px;
      color: #333;
    }
    .container {
      max-width: 800px;
      margin: auto;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #4a148c;
    }
    form {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr auto;
      gap: 15px;
      margin-bottom: 30px;
    }
    input, select, button {
      padding: 10px 12px;
      font-size: 16px;
      border: 1.5px solid #ccc;
      border-radius: 8px;
    }
    input:focus, select:focus {
      border-color: #764ba2;
      outline: none;
    }
    button {
      background-color: #764ba2;
      color: white;
      font-weight: 600;
      border: none;
      cursor: pointer;
      transition: 0.3s;
    }
    button:hover {
      background-color: #5a3a8c;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      border-radius: 10px;
      overflow: hidden;
    }
    th, td {
      padding: 12px 16px;
      text-align: left;
    }
    th {
      background-color: #764ba2;
      color: white;
      font-weight: 600;
    }
    tr:nth-child(even) {
      background-color: #f9f9f9;
    }
    .actions a {
      margin-right: 10px;
      color: #764ba2;
      text-decoration: none;
      font-weight: 600;
    }
    .actions a:hover {
      text-decoration: underline;
    }
    .error {
      color: red;
      margin-bottom: 20px;
      text-align: center;
    }
    @media (max-width: 768px) {
      form {
        grid-template-columns: 1fr;
      }
      .actions a {
        display: inline-block;
        margin-bottom: 5px;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Budget Tracker</h2>

  <?php if (isset($error)): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <?php if ($user_role === 'client'): ?>
    <form method="POST">
      <input type="hidden" name="id" value="<?= $edit_mode ? $edit_row['id'] : '' ?>" />
      <input name="category" placeholder="Category" required value="<?= $edit_mode ? htmlspecialchars($edit_row['category']) : '' ?>" />
      <input name="amount" type="number" step="0.01" placeholder="Amount" required value="<?= $edit_mode ? htmlspecialchars($edit_row['amount']) : '' ?>" />
      <input name="date" type="date" required value="<?= $edit_mode ? htmlspecialchars($edit_row['date']) : '' ?>" />
      <?php if ($edit_mode): ?>
        <button name="update">Update</button>
        <a href="budget.php" style="align-self:center; color:#764ba2; font-weight:600; text-decoration:none;">Cancel</a>
      <?php else: ?>
        <button name="save">Add</button>
      <?php endif; ?>
    </form>
  <?php else: ?>
    <p style="text-align:center; font-style:italic; margin-bottom: 20px;">You can only view the budget. Editing is restricted to couples.</p>
  <?php endif; ?>

  <table>
    <tr>
      <th>Category</th>
      <th>Amount</th>
      <th>Date</th>
      <?php if ($user_role === 'client'): ?>
        <th>Actions</th>
      <?php endif; ?>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($row['category']) ?></td>
      <td>$<?= number_format($row['amount'], 2) ?></td>
      <td><?= htmlspecialchars($row['date']) ?></td>
      <?php if ($user_role === 'client'): ?>
        <td class="actions">
          <a href="budget.php?edit=<?= $row['id'] ?>">Edit</a>
          <a href="budget.php?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this entry?');">Delete</a>
        </td>
      <?php endif; ?>
    </tr>
    <?php endwhile; ?>
  </table>
</div>

</body>
</html>
