<?php
session_start();
if (!isset($_SESSION['AdminLoginId'])) {
    header("location: adminlogin.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>

    <!-- ✅ Correct CSS Path -->
    <link rel="stylesheet" type="text/css" href="../css/admindashboard.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- CHART.JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

<header class="header">
    <div class="logo"><h1>Admin Panel</h1></div>

    <nav class="navigation">
        <ul class="nav-menu">
            <li><a href="adminviewjourneys.php">View Journeys</a></li>
            <li><a href="adminpayments.php">Payments</a></li>
            <li><a href="adminviewusers.php">Users</a></li>
            <li><a href="adminusers.php">Admins</a></li>
            <li><a href="#">Settings</a></li>
        </ul>
    </nav>
</header>

<div class="container">

    <!-- ✅ LEFT SIDEBAR -->
    <div class="sidebar">

        <div class="logo">
            <img src="silhouette.png" alt="Admin"><br>
        </div>

        <h2 style="color: #555; font-size: 1.3rem; margin-top: 0.5rem;">Welcome, <?php echo $_SESSION['AdminLoginId']; ?></h2>

        <ul class="sidebar-menu">
            <li><a href="admindashboard.php"><i class="fa fa-home"></i> Dashboard</a></li>
            <li><a href="adminviewjourneys.php"><i class="fa fa-map"></i> Manage Journeys</a></li>
            <li><a href="adminpayments.php"><i class="fa fa-credit-card"></i> Payments</a></li>
            <li><a href="adminviewusers.php"><i class="fa fa-users"></i> Users</a></li>
            <li><a href="adminusers.php"><i class="fa fa-user-shield"></i> Admin Accounts</a></li>
            <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
        </ul>

        <div class="sidebar-footer">
            <p>Logged in as Admin</p>
            <a href="adminlogout.php"><i class="fa fa-sign-out"></i> Logout</a>
        </div>

    </div>

    <!-- ✅ MAIN CONTENT -->
    <div class="content">

        <div class="dashboard-overview">
            <h2>Dashboard Overview</h2>
            <p>Welcome to your admin dashboard. Manage journeys, bookings, payments, and users.</p>
        </div>

        <!-- ✅ QUICK ACTION CARDS -->
        <div class="dashboard-cards">

            <a href="adminviewjourneys.php" class="dash-card">
                <i class="fa fa-map fa-2x"></i>
                <h3>Journeys</h3>
                <p>View & Manage Packages</p>
            </a>

            <a href="adminpayments.php" class="dash-card">
                <i class="fa fa-credit-card fa-2x"></i>
                <h3>Payments</h3>
                <p>View All Payments</p>
            </a>

            <a href="adminviewusers.php" class="dash-card">
                <i class="fa fa-users fa-2x"></i>
                <h3>Users</h3>
                <p>Registered Customers</p>
            </a>

            <a href="adminusers.php" class="dash-card">
                <i class="fa fa-user-shield fa-2x"></i>
                <h3>Admins</h3>
                <p>Admin Accounts</p>
            </a>

        </div>

        <!-- ✅ CHARTS SECTION -->
        <div class="dashboard-charts">

            <div class="chart-card">
                <h3>📅 Monthly Bookings</h3>
                <canvas id="bookingsChart"></canvas>
            </div>

            <div class="chart-card">
                <h3>💰 Monthly Revenue (LKR)</h3>
                <canvas id="revenueChart"></canvas>
            </div>

            <div class="chart-card">
                <h3>📊 Payment Status Breakdown</h3>
                <canvas id="statusChart"></canvas>
            </div>

        </div>

    </div>
</div>

<footer class="footer">
    <p>&copy; 2025 Admin Panel – Reliance Travels</p>
</footer>


<!-- ✅ CHART LOADER SCRIPT -->
<script>
fetch("adminstats.php")
    .then(res => res.json())
    .then(data => {

        const monthNames = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];

        /* ---- Bookings ---- */
        const bookingLabels = data.bookings.map(a => monthNames[a.month-1]);
        const bookingData = data.bookings.map(a => a.count);

        new Chart(document.getElementById("bookingsChart"), {
            type: "line",
            data: {
                labels: bookingLabels,
                datasets: [{
                    data: bookingData,
                    label: "Bookings",
                    borderColor: "#ff1b85",
                    backgroundColor: "rgba(255,27,133,0.2)",
                    borderWidth: 3,
                    tension: 0.4
                }]
            },
            options: { animation: { duration: 1200 } }
        });

        /* ---- Revenue ---- */
        const revenueLabels = data.revenue.map(a => monthNames[a.month-1]);
        const revenueData = data.revenue.map(a => a.revenue);

        new Chart(document.getElementById("revenueChart"), {
            type: "bar",
            data: {
                labels: revenueLabels,
                datasets: [{
                    data: revenueData,
                    backgroundColor: "#36a2eb"
                }]
            },
            options: { animation: { duration: 1500 } }
        });

        /* ---- Payment Status ---- */
        const paid = data.status.PAID ?? 0;
        const pending = data.status.PENDING ?? 0;
        const failed = data.status.FAILED ?? 0;

        new Chart(document.getElementById("statusChart"), {
            type: "doughnut",
            data: {
                labels: ["Paid", "Pending", "Failed"],
                datasets: [{
                    data: [paid, pending, failed],
                    backgroundColor: ["#28a745", "#ffc107", "#dc3545"]
                }]
            },
            options: { animation: { duration: 1800 } }
        });

    });
</script>

</body>
</html>
