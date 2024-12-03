<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fertigation_system";  // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Maximum data per page and current page
$records_per_page = 1000;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// Fetch the selected date from user input
$selected_date = isset($_GET['date']) ? $_GET['date'] : '';

// Get the current timestamp and calculate two minutes ago
$two_minutes_ago = date('Y-m-d H:i:s', strtotime('-2 minutes'));

// Modify SQL query based on selected date
if (!empty($selected_date)) {
    $sql = "SELECT * FROM sensor_data WHERE DATE(timestamp) = '$selected_date' AND timestamp >= '$two_minutes_ago' ORDER BY timestamp DESC LIMIT $records_per_page OFFSET $offset";
} else {
    $sql = "SELECT * FROM sensor_data WHERE timestamp >= '$two_minutes_ago' ORDER BY timestamp DESC LIMIT $records_per_page OFFSET $offset";
}

$result = $conn->query($sql);

// Fetch total records for pagination
$total_sql = "SELECT COUNT(*) AS total FROM sensor_data WHERE timestamp >= '$two_minutes_ago'";
$total_result = $conn->query($total_sql);
$total_rows = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $records_per_page);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sensor Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212; /* Dark background */
            color: #E0E0E0; /* Light text */
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: #1E1E1E; /* Darker container background */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
        }

        h2 {
            text-align: center;
            color: #E0E0E0; /* Light text for headers */
            font-size: 1.8em;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #444; /* Dark border */
            text-align: center;
            font-size: 0.9em;
        }

        th {
            background-color: #333; /* Darker header background */
            color: #E0E0E0; /* Light text */
        }

        .pagination {
            text-align: center;
            margin: 20px 0;
        }

        .pagination a {
            margin: 0 5px;
            padding: 8px 16px;
            text-decoration: none;
            background-color: #007bff; /* Button color */
            color: #fff;
            border-radius: 4px;
            font-size: 0.9em;
        }

        .pagination a:hover {
            background-color: #0056b3; /* Darker on hover */
        }

        .download-btn {
            text-align: right;
            margin-top: 20px;
        }

        .download-btn a {
            padding: 10px 20px;
            background-color: #28a745; /* Green button */
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            font-size: 0.9em;
        }

        .download-btn a:hover {
            background-color: #218838; /* Darker green on hover */
        }

        .date-filter {
            text-align: center;
            margin: 20px 0;
        }

        .date-filter input[type="date"] {
            padding: 10px;
            font-size: 1em;
            background-color: #444; /* Darker input background */
            color: #E0E0E0; /* Light text */
            border: 1px solid #555; /* Dark border */
            border-radius: 4px;
        }

        .date-filter button {
            padding: 10px 20px;
            background-color: #007bff; /* Button color */
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9em;
        }

        .date-filter button:hover {
            background-color: #0056b3; /* Darker on hover */
        }

        /* Back button style */
        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            font-size: 1em;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        // Auto-refresh the page every 60 seconds
        setTimeout(function(){
            window.location.reload();
        }, 60000);
    </script>
</head>
<body>
    <!-- Back Button -->
    <button class="back-button" onclick="window.history.back();">Back</button>

    <div class="container">
        <h2>Recorded Sensor Data</h2>

        <!-- Date Filter Form -->
        <div class="date-filter">
            <form method="GET" action="">
                <label for="date" style="color: #E0E0E0;">Select Date:</label>
                <input type="date" id="date" name="date" value="<?php echo $selected_date; ?>">
                <button type="submit">Filter</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Humidity (%)</th>
                    <th>Temperature (°C)</th>
                    <th>TDS (ppm)</th>
                    <th>Pump 2 State</th> <!-- New column for pump 2 state -->
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $id = 1 + $offset;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $id++ . "</td>";
                        echo "<td>" . htmlspecialchars($row["humidity"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["temperature"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["tds"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["pump2_state"]) . "</td>";  // Display pump 2 state
                        echo "<td>" . htmlspecialchars($row["timestamp"]) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No data available</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?php echo $i; ?>&date=<?php echo $selected_date; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
        </div>

    </div>
</body>
</html>

<?php $conn->close(); ?>

