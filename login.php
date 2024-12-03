<?php
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate username and password (you may replace this with a database query)
    $valid_username = "user";
    $valid_password = "user123";

    // Retrieve username and password from form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if username and password match
    if ($username === $valid_username && $password === $valid_password) {
        // Admin credentials are valid, set session variables or redirect to admin dashboard
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin.php");
        exit();
    } else {
        // Invalid credentials, show error message
        echo "Invalid username or password. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #add8e6;
        }

        .container {
            text-align: center;
        }

        .login {
            width: 340px;
            height: 300px; /* Increased height */
            background: #2c2c2c;
            padding: 60px 47px 30px 47px; /* Adjusted padding to move content down */
            color: #fff;
            border-radius: 17px;
            font-size: 1.3em;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            display: inline-block;
        }

        .login input[type="text"],
        .login input[type="password"] {
            opacity: 1;
            display: block;
            border: none;
            outline: none;
            width: calc(100% - 36px);
            padding: 13px 18px;
            margin: 20px 0 0 0;
            font-size: 0.8em;
            border-radius: 100px;
            background: #40e0d0;
            color: #40e0d0f;
        }

        .login input:focus {
            animation: bounce 1s;
            -webkit-appearance: none;
        }

        .login input[type=submit] {
            border: 0;
            outline: 0;
            width: 100%;
            padding: 13px;
            margin: 40px 0 0 0;
            border-radius: 500px;
            font-weight: 600;
            animation: bounce2 1.6s;
            background: linear-gradient(135deg, #40e0d0, #00bfff 50%, #00ddeb);
            color: #fff;
        }

        .login input[type=submit]:hover {
            background: linear-gradient(144deg, #1e1e1e, 20%, #1e1e1e 50%, #1e1e1e);
            color: #fff;
            cursor: pointer;
            transition: all 0.4s ease;
        }

        .h1 {
            padding: 0;
            position: relative;
            top: -10px; /* Adjusted top position to move heading down */
            display: block;
            margin-bottom: 20px; /* Adjusted margin-bottom to add space below heading */
            font-size: 1.3em;
        }

        .ui {
            font-weight: bolder;
            background: -webkit-linear-gradient(#B563FF, #535EFC, #0EC8EE);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            border-bottom: 4px solid transparent;
            border-image: linear-gradient(0.25turn, #535EFC, #0EC8EE, #0EC8EE);
            border-image-slice: 1;
            display: inline;
        }

        @media only screen and (max-width: 600px) {
            .login {
                width: 70%;
                padding: 3em;
            }
        }

        @keyframes bounce {
            0% {
                transform: translateY(-250px);
                opacity: 0;
            }
        }

        @keyframes bounce1 {
            0% {
                opacity: 0;
            }

            40% {
                transform: translateY(-100px);
                opacity: 0;
            }
        }

        @keyframes bounce2 {
            0% {
                opacity: 0;
            }

            70% {
                transform: translateY(-20px);
                opacity: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login wrap">
            <div class="h1">Admin Login</div>
            <form action="login.php" method="post">
                <input placeholder="Username" id="username" name="username" type="text" required>
                <input placeholder="Password" id="password" name="password" type="password" required>
                <input value="Login" class="btn" type="submit">
            </form>
        </div>
    </div>
</body>
</html>
