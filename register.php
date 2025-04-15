<?php
ob_start();
session_start();

$host = 'localhost';
$dbname = 'wpl';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 900)) {
    session_unset();
    session_destroy();
    header("Location: login.php?message=Session expired. Please login again.");
    exit();
}
$_SESSION['last_activity'] = time();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = trim($_POST["fname"] ?? '');
    $lname = trim($_POST["lname"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $dob = trim($_POST["dob"] ?? '');
    $phone = trim($_POST["phone"] ?? '');
    $password = trim($_POST["password"] ?? '');
    $confirmPassword = trim($_POST["confirmPassword"] ?? '');
    $option = trim($_POST["option"] ?? '');
    $termsAccepted = isset($_POST["terms"]);

    if (empty($fname) || empty($lname) || empty($email) || empty($dob) || empty($password) || empty($confirmPassword)) {
        die("Please fill in all required fields.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    if ($password !== $confirmPassword) {
        die("Passwords do not match.");
    }

    if (!$termsAccepted) {
        die("You must accept the terms and conditions.");
    }

    $checkEmailSql = "SELECT COUNT(*) FROM users WHERE email = :email";
    $checkStmt = $pdo->prepare($checkEmailSql);
    $checkStmt->bindParam(':email', $email);
    $checkStmt->execute();
    $emailExists = $checkStmt->fetchColumn();

    if ($emailExists > 0) {
        die("Error: This email is already registered.");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (first_name, last_name, email, dob, phone, password, option_selected)
            VALUES (:fname, :lname, :email, :dob, :phone, :password, :option)";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':fname', $fname);
    $stmt->bindParam(':lname', $lname);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':dob', $dob);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':option', $option);

    if ($stmt->execute()) {
        $_SESSION["user"] = $fname; // Or $_SESSION["user"] = $fname . " " . $lname;
        $_SESSION["email"] = $email;
        setcookie("remember_email", $email, time() + (86400 * 30), "/");

        echo "Registration successful! Redirecting to dashboard...";
        header("refresh:3;url=dashboard.php");
        exit();
    } else {
        echo "Error: Could not register.";
    }
}

ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayPal - Registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: rgb(244, 244, 244);
            color: #333;
        }

        header {
            background-color: #0070ba;
            padding: 10px 15px;
            color: white;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo {
            border-radius: 10px;
            width: 120px;
        }

        .menu {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }

        .menu li {
            margin: 0 20px;
        }

        .menuItem {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .menuItem:hover {
            color: rgb(206, 205, 199);
        }

        .hamburger {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
        }

        main {
            margin-top: 80px;
            padding: 20px;
            max-width: 1200px;
            margin: 20px auto;
        }

        .registration-container {
            position: relative;
            top: 100px;
            width: 100%;
            max-width: 500px;
            margin: 30px auto;
            padding: 30px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .registration-container h2 {
            text-align: center;
            color: #0070ba;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #555;
        }

        input[type="text"],
        input[type="date"],
        input[type="tel"],
        input[type="password"],
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #0070ba;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #005691;
        }

        .terms-and-conditions {
            margin-top: 15px;
            text-align: center;
        }

        .terms-and-conditions label {
            color: #555;
        }

        .terms-and-conditions a {
            color: #0070ba;
            text-decoration: none;
        }

        .terms-and-conditions input[type="checkbox"] {
            margin-right: 5px;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar">
            <img class="logo" src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal Logo">
            <ul class="menu">
                <li><a href="#" class="menuItem">Home</a></li>
                <li><a href="#" class="menuItem">Login</a></li>
            </ul>
        </nav>
    </header>

    <div class="registration-container">
        <h2>Create Your PayPal Account</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="fname">First Name *</label>
                <input type="text" id="fname" name="fname" required>
            </div>

            <div class="form-group">
                <label for="lname">Last Name *</label>
                <input type="text" id="lname" name="lname" required>
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="text" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="dob">Date of Birth *</label>
                <input type="date" id="dob" name="dob" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="tel" id="phone" name="phone">
            </div>

            <div class="form-group">
                <label for="password">Password *</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="confirmPassword">Confirm Password *</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
            </div>

            <div class="form-group">
                <label for="option">Select an Option</label>
                <select id="option" name="option">
                    <option value="">--Please choose--</option>
                    <option value="personal">Personal</option>
                    <option value="business">Business</option>
                </select>
            </div>

            <div class="terms-and-conditions">
                <input type="checkbox" id="terms" name="terms">
                <label for="terms">I accept the <a href="#">terms and conditions</a></label>
            </div>

            <div class="form-group">
                <input type="submit" value="Register">
            </div>
        </form>
    </div>
</body>
</html>