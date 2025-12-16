<?php
session_start();

if (!isset($_SESSION['AdminLoginId'])) {
    header("location: adminlogin.php");
    exit;
}

if (!isset($_GET["booking_id"])) {
    exit("Missing booking_id");
}

$booking_id = intval($_GET["booking_id"]);

$conn = new mysqli("localhost", "root", "", "reliance_travels");

$conn->query("DELETE FROM bookings WHERE booking_id = $booking_id");

header("location: adminpayments.php");
exit;
?>
