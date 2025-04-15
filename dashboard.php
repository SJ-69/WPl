<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
$phone = $_SESSION['login'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

    <!-- Bootstrap 5 & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .navbar-custom {
            background-color: #003087;
        }

        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: white;
        }

        .navbar-custom .nav-link:hover {
            color: #d1e7ff;
        }

        .hero {
            background: linear-gradient(90deg, #0070BA 0%, #1546A0 100%);
            color: white;
            padding: 60px 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 3rem;
        }

        .card i {
            font-size: 2rem;
            color: #003087;
        }

        .quick-actions {
            padding: 40px 0;
        }

        footer {
            background-color: #003087;
            color: white;
            text-align: center;
            padding: 20px 0;
            margin-top: 40px;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand">Welcome, <?php echo htmlspecialchars($phone); ?></a>
            <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="transactions.php">Transactions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sendmoney.php">Send Money</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="requestmoney.php">Request Money</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Welcome to Your PayPal Dashboard</h1>
            <p class="lead">Manage your money, send and receive payments with ease.</p>
        </div>
    </section>

    <!-- Quick Actions -->
    <section class="quick-actions">
        <div class="container">
            <div class="row text-center g-4">
                <div class="col-md-3">
                    <div class="card shadow-sm p-3">
                        <i class="bi bi-cash-stack mb-2"></i>
                        <h5>Send Money</h5>
                        <p>Transfer funds securely.</p>
                        <a href="sendmoney.php" class="btn btn-primary btn-sm">Send</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm p-3">
                        <i class="bi bi-currency-exchange mb-2"></i>
                        <h5>Request Money</h5>
                        <p>Ask contacts for payments.</p>
                        <a href="requestmoney.php" class="btn btn-primary btn-sm">Request</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm p-3">
                        <i class="bi bi-clock-history mb-2"></i>
                        <h5>Transaction History</h5>
                        <p>Review all transactions.</p>
                        <a href="transactions.php" class="btn btn-primary btn-sm">View</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm p-3">
                        <i class="bi bi-box-arrow-right mb-2"></i>
                        <h5>Logout</h5>
                        <p>End your session safely.</p>
                        <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p class="mb-0">© <?php echo date("Y"); ?> PayPal Clone. All rights reserved.</p>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
