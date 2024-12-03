<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fertigation_system";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Log incoming requests for debugging
error_log(print_r($_GET, true));

// Get parameters from URL
$humidity = isset($_GET['humidity']) ? $_GET['humidity'] : null;
$temperature = isset($_GET['temperature']) ? $_GET['temperature'] : null;
$tds = isset($_GET['tds']) ? $_GET['tds'] : null;
$pump2_state = isset($_GET['pump2_state']) ? $_GET['pump2_state'] : null;

// Validate input data
if ($humidity === null || $temperature === null || $tds === null || $pump2_state === null) {
    echo "Invalid input data!";
    exit;
}

// Prepare and bind SQL statement
$stmt = $conn->prepare("INSERT INTO sensor_data (humidity, temperature, tds, pump2_state) VALUES (?, ?, ?, ?)");
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

// Bind the parameters to the SQL query
$stmt->bind_param("ssss", $humidity, $temperature, $tds, $pump2_state); // Adjust binding

// Execute the statement
if ($stmt->execute()) {
    echo "Data inserted successfully!";
} else {
    echo "Error inserting data: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();
