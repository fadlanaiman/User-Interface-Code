<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fertigation_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the latest 10 rows from "sensor_data" (adjust the LIMIT if needed)
$sql = "SELECT timestamp, tds, humidity, temperature FROM sensor_data ORDER BY timestamp DESC LIMIT 10";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Return data as JSON
echo json_encode($data);

// Close the connection
$conn->close();
?>
