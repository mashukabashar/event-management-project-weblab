<?php
$conn = new mysqli("localhost", "root", "", "Event-management");

// Add
if (isset($_POST['save'])) {
    $cat = $_POST['category'];
    $amt = $_POST['amount'];
    $date = $_POST['date'];
    $conn->query("INSERT INTO budget (user_id, category, amount, date) VALUES (1, '$cat', '$amt', '$date')");
}

// Fetch
$result = $conn->query("SELECT * FROM budget WHERE user_id = 1");
?>

<h2>Budget Tracker</h2>
<form method="POST">
    Category: <input name="category"> 
    Amount: <input name="amount" type="number" step="0.01">
    Date: <input name="date" type="date">
    <button name="save">Add</button>
</form>

<table border="1">
<tr><th>Category</th><th>Amount</th><th>Date</th></tr>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= $row['category'] ?></td>
    <td><?= $row['amount'] ?></td>
    <td><?= $row['date'] ?></td>
</tr>
<?php endwhile; ?>
</table>
