<?php
session_start();
$conn = new mysqli("localhost", "root", "", "Event-management");

// ADD
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $conn->query("INSERT INTO guests (user_id, name, contact) VALUES (1, '$name', '$contact')");
}

// DELETE
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM guests WHERE id = $id");
}

// FETCH
$result = $conn->query("SELECT * FROM guests WHERE user_id = 1");
?>

<h2>Guest List</h2>
<form method="POST">
    Name: <input name="name"> 
    Contact: <input name="contact">
    <button name="add">Add</button>
</form>

<table border="1">
<tr><th>Name</th><th>Contact</th><th>Status</th><th>Action</th></tr>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= $row['name'] ?></td>
    <td><?= $row['contact'] ?></td>
    <td><?= $row['rsvp_status'] ?></td>
    <td><a href="?delete=<?= $row['id'] ?>">Delete</a></td>
</tr>
<?php endwhile; ?>
</table>
