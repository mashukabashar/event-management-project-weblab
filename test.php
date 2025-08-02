<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db.php';

$sql = "SELECT * FROM vendor_table";
$result = $conn->query($sql);

if ($result === false) {
    die("SQL error: " . $conn->error);
}

if ($result->num_rows > 0) {
    echo "<h2>Simple Vendors List</h2>";
    echo "<table border='1' cellpadding='8' cellspacing='0'>";
    echo "<tr><th>ID</th><th>Company Name</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Company Name']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No records found.";
}
?>
