<?php
session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AUTOMATIC MAMAN PLANT FERTILIZER MIXING AND MONITORING BY FADLAN AIMAN</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: url('gambar/background.jpg') no-repeat center center fixed;
            background-size: cover; /* Ensure the background covers the entire page */
            color: #ffffff; /* Default text color */
        }

        .navbar {
            margin-bottom: 0;
            background-color: rgba(52, 58, 64, 0.8); /* Semi-transparent navbar */
        }

        .navbar-brand, .navbar-nav .nav-link {
            color: #ffffff;
        }

        .navbar-nav .nav-link:hover {
            color: #f8f9fa;
        }

        .hero-section {
            min-height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #ffffff;
            position: relative;
            background-color: rgba(64, 64, 64, 0.5); /* Dark overlay for better text visibility */
        }

        .hero-section h1 {
            font-size: 48px;
            text-shadow: 2px 2px 4px rgba(64, 64, 64, 0.7);
        }

        .hero-section p {
            font-size: 18px;
            max-width: 600px;
            margin: 20px auto;
        }

        .footer {
            padding: 20px;
            text-align: center;
            background-color: rgba(52, 58, 64, 0.8); /* Semi-transparent footer */
            color: #ffffff;
        }

        .logout-button {
            width: 120px;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        .logout-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="#">MAMAN PLANT FERTILIZER MIXING AND MONITORING FERTIGATION SYSTEM</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="display_data.php">Display Data</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="hero-section">
        <div>
            <h1>Hello, Admin</h1>
            <p>Monitor TDS value,Temperature and Humidity in Maman Fertigation System in real-time.</p>
        </div>
    </div>

    <div class="container text-center my-4">
        <h2>Admin Controls</h2>
        <div class="btn-group my-4">
            <a href="display_data.php" class="btn btn-secondary mx-2">View Data</a>
            <a href="statistics.php" class="btn btn-secondary mx-2">Statistics</a>
        </div>
        <form method="post">
            <button type="submit" name="logout" class="logout-button">Logout</button>
        </form>
    </div>

    <div class="footer">
        &copy; 2024 Fadlan Aiman | Maman Plant Fertilizer Mixing and Monitoring Fertigation System
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
