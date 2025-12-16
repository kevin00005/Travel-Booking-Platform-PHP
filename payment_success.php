<?php
if (!isset($_GET["booking_id"])) {
    exit("Invalid request");
}

$booking_id = intval($_GET["booking_id"]);

// ✅ Update DB status
$conn = new mysqli("localhost", "root", "", "reliance_travels");
$conn->query("UPDATE bookings SET status='PAID' WHERE booking_id=$booking_id");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Payment Successful</title>
    <style>
        body { font-family: Arial; text-align:center; background:#eaffea; padding-top:60px; }
        .msg { background:white; width:50%; margin:auto; padding:40px; border-radius:15px;
               box-shadow:0 3px 10px rgba(0,0,0,0.2); }
        a { display:block; margin-top:15px; text-decoration:none; font-size:18px; }
        .home { color:green; }
        .admin { color:#ff1b85; }
    </style>
</head>
<body>

<div class="msg">
    <h1>✅ Payment Successful!</h1>
    <p>Your booking ID: <b><?php echo $booking_id; ?></b></p>

    <a href="home.php" class="home">🏠 Go to Home</a>
    <a href="admin/admindashboard.php" class="admin">🔐 Go to Admin Dashboard</a>
</div>

</body>
</html>
