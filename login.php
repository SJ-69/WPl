<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wpl";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phone = $_POST['first'];
    $password = $_POST['password']; // Get the plain password from the form

    // Use the 'users' table
    $sql = "SELECT * FROM users WHERE first_name = '$fname' AND last_name = '$lname' AND phone = '$phone'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $row['password'])) {
            $_SESSION['login'] = $phone;
            $_SESSION['fname'] = $row['first_name'];
            $_SESSION['lname'] = $row['last_name'];

            echo "Login successful! Redirecting...";
            header("refresh:2; url=dashboard.php");
            exit();
        } else {
            echo "<div class='alert alert-danger text-center'>Invalid credentials!</div>";
        }
    } else {
        echo "<div class='alert alert-danger text-center'>Invalid credentials!</div>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayPal Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #0079c1;
        }
        .login-container {
            max-width: 400px;
            margin: 5% auto;
            padding: 30px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }
        .paypal-logo {
            width: 160px;
            margin-bottom: 15px;
        }
        .form-control:focus {
            border-color: #0070BA;
            box-shadow: 0 0 0 0.2rem rgba(0, 112, 186, 0.25);
        }
        .btn-paypal {
            background-color: #003087;
            color: white;
        }
        .btn-paypal:hover {
            background-color: #001f5a;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="login-container text-center">
        <img src="https://upload.wikimedia.org/wikipedia/commons/a/a4/Paypal_2014_logo.png" alt="PayPal" class="paypal-logo">
        <h3 class="mb-4">Login to PayPal</h3>

        <form action="login.php" method="POST">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" required>
                <label for="fname">First Name</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" required>
                <label for="lname">Last Name</label>
            </div>

            <div class="form-floating mb-3">
                <input type="tel" class="form-control" id="first" name="first" placeholder="Phone Number" required>
                <label for="first">Phone Number</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>

            <button type="submit" class="btn btn-paypal w-100 mb-3">Login</button>
        </form>

        <p>Not registered? <a href="register.php" class="fw-bold text-decoration-none text-primary">Create an account</a></p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>