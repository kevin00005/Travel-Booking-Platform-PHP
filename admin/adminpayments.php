<?php
session_start();

// ✅ Protect page — only admin can access
if (!isset($_SESSION['AdminLoginId'])) {
    header("location: adminlogin.php");
    exit;
}

// ✅ DB CONNECT
$conn = new mysqli("localhost", "root", "", "reliance_travels");

// ✅ Fetch all bookings + city name + hotel name
$sql = "
    SELECT b.*, c.city, h.hotel
    FROM bookings b
    LEFT JOIN cities c ON b.cityid = c.cityid
    LEFT JOIN hotels h ON b.hotelid = h.hotelid
    ORDER BY b.booking_id DESC
";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin – Payments</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f4f9;
    margin: 0;
}
.navbar {
    background: #ff1b85;
    padding: 15px;
    color: white;
    font-size: 22px;
}
.container {
    width: 90%;
    margin: auto;
    margin-top: 30px;
}
h1 {
    color: #ff1b85;
}
.table-box {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}
table th, table td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
}
table th {
    background: #ffe0f1;
    color: #333;
}

.status-paid {
    background: #d4ffe0;
    color: #097a2e;
    padding: 6px 10px;
    border-radius: 8px;
    font-weight: bold;
}
.status-pending {
    background: #fff7d1;
    color: #a38100;
    padding: 6px 10px;
    border-radius: 8px;
    font-weight: bold;
}
.status-failed {
    background: #ffd6d6;
    color: #a30000;
    padding: 6px 10px;
    border-radius: 8px;
    font-weight: bold;
}

.delete-btn {
    background: #ff4b4b;
    color: white;
    padding: 7px 12px;
    border-radius: 6px;
    text-decoration: none;
}
.delete-btn:hover {
    background: #d00000;
}
.back {
    color: #ff1b85;
    text-decoration: none;
    font-weight: bold;
    margin-bottom: 20px;
    display: inline-block;
}
</style>

</head>
<body>

<div class="navbar">
    Admin Dashboard – Payments
</div>

<div class="container">

<a class="back" href="admindashboard.php">← Back to Dashboard</a>

<h1>Payment Records</h1>

<div class="table-box">

<table>
    <tr>
        <th>Booking ID</th>
        <th>City</th>
        <th>Hotel</th>
        <th>Customer</th>
        <th>Contact</th>
        <th>Travel Date</th>
        <th>Tourists</th>
        <th>Total Cost</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

<?php while ($row = $result->fetch_assoc()): ?>

    <tr>
        <td><?= $row['booking_id'] ?></td>
        <td><?= $row['city'] ?></td>
        <td><?= $row['hotel'] ?></td>
        <td><?= $row['user_name'] ?></td>
        <td><?= $row['contact'] ?></td>
        <td><?= $row['travel_date'] ?></td>
        <td><?= $row['tourists'] ?></td>
        <td>Rs <?= number_format($row['total_cost']) ?></td>

        <td>
            <?php 
                if ($row['status'] == 'PAID') {
                    echo "<span class='status-paid'>PAID</span>";
                } elseif ($row['status'] == 'FAILED') {
                    echo "<span class='status-failed'>FAILED</span>";
                } else {
                    echo "<span class='status-pending'>PENDING</span>";
                }
            ?>
        </td>

        <td>
            <a 
                class="delete-btn" 
                href="delete_payment.php?booking_id=<?= $row['booking_id'] ?>"
                onclick="return confirm('Delete this payment?');"
            >
                Delete
            </a>
        </td>

    </tr>

<?php endwhile; ?>

</table>

</div>
</div>

</body>
</html>
