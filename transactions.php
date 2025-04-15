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
$stmt1 = $conn->prepare("SELECT id FROM users WHERE phone = ?");
$stmt1->bind_param("s", $current_phone);
$stmt1->execute();
$userResult = $stmt1->get_result();
$userData = $userResult->fetch_assoc();
$current_user_id = $userData['id'];
$stmt1->close(); // ✅ This is only for fetching user ID

// Get all transactions where the user is either sender or receiver
$query = "
    SELECT 
        t.transaction_id,
        t.user_id,
        u1.phone AS sender_phone,
        t.receiver_phone,
        t.amount,
        t.transaction_type,
        t.transaction_date
    FROM transactions t
    JOIN users u1 ON t.user_id = u1.id
    WHERE t.user_id = ? OR t.receiver_phone = ?
    ORDER BY t.transaction_date DESC
";

$stmt2 = $conn->prepare($query);
$stmt2->bind_param("is", $current_user_id, $current_phone);
$stmt2->execute();
$result = $stmt2->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transaction History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="text-center mb-4">Transaction History</h2>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Type</th>
            <th>Amount</th>
            <th>From</th>
            <th>To</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $count = 1;
        while ($row = $result->fetch_assoc()) {
            $type = $row['transaction_type'];
            $amount = number_format($row['amount'], 2);
            $from = $row['sender_phone'];
            $to = $row['receiver_phone'];
            $date = $row['transaction_date'];

            if ($type === 'send') {
                $displayType = ($row['user_id'] == $current_user_id) ? "Sent" : "Received";
            } elseif ($type === 'request') {
                $displayType = "Requested";
            } else {
                $displayType = ucfirst($type);
            }

            echo "<tr>
                    <td>{$count}</td>
                    <td>{$displayType}</td>
                    <td>₹ {$amount}</td>
                    <td>{$from}</td>
                    <td>{$to}</td>
                    <td>{$date}</td>
                  </tr>";
            $count++;
        }
        ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
$stmt2->close(); // ✅ Only close this once
$conn->close();
?>
