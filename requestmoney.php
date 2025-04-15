<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wpl";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$current_phone = $_SESSION['login'];

// Get current user ID
$stmt = $conn->prepare("SELECT id FROM users WHERE phone = ?");
$stmt->bind_param("s", $current_phone);
$stmt->execute();
$userResult = $stmt->get_result();
if ($userResult->num_rows === 0) {
    die("User not found.");
}
$userData = $userResult->fetch_assoc();
$user_id = $userData['id'];
$stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $receiver_phone = trim($_POST['receiver_phone']);
    $amount = trim($_POST['amount']);

    // Simple validation
    if (empty($receiver_phone) || empty($amount)) {
        $error = "Please fill in all fields.";
    } elseif (!is_numeric($amount) || $amount <= 0) {
        $error = "Enter a valid amount.";
    } elseif ($receiver_phone === $current_phone) {
        $error = "You cannot request money from yourself.";
    } else {
        // Check if receiver exists
        $checkStmt = $conn->prepare("SELECT id FROM users WHERE phone = ?");
        $checkStmt->bind_param("s", $receiver_phone);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows === 0) {
            // Show alert and redirect if receiver doesn't exist
            echo "<script>
                alert('Recipient not found. Please enter a valid phone number.');
                window.location.href = 'dashboard.php';
            </script>";
            exit();
        } else {
            // Insert request
            $stmt = $conn->prepare("INSERT INTO transactions (user_id, receiver_phone, amount, transaction_type) VALUES (?, ?, ?, 'request')");
            $stmt->bind_param("isd", $user_id, $receiver_phone, $amount);
            if ($stmt->execute()) {
                $success = "Request sent successfully!";
                header("refresh:2; url=dashboard.php");
                exit();
            } else {
                $error = "Error: " . $stmt->error;
            }
            $stmt->close();
        }
        $checkStmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Request Money</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card mx-auto shadow" style="max-width: 500px;">
        <div class="card-body">
            <h3 class="mb-4 text-center">Request Money</h3>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php elseif (!empty($success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label for="receiver_phone" class="form-label">Receiver Phone Number</label>
                    <input type="text" class="form-control" name="receiver_phone" required>
                </div>
                <div class="mb-3">
                    <label for="amount" class="form-label">Amount (₹)</label>
                    <input type="number" class="form-control" name="amount" step="0.01" min="0.01" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Send Request</button>
                <a href="transactions.php" class="btn btn-secondary w-100 mt-2">Transaction Log</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
