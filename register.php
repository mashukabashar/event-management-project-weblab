<?php
$conn = new mysqli("localhost", "root", "", "Event-management");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $conn->query("INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')");
    echo "Registered successfully!";
}
?>
<form method="POST">
    Name: <input name="name"><br>
    Email: <input name="email"><br>
    Password: <input type="password" name="password"><br>
    Role: 
    <select name="role">
        <option value="couple">Couple</option>
        <option value="vendor">Vendor</option>
        <option value="admin">Admin</option>
    </select><br>
    <button type="submit">Register</button>
</form>
