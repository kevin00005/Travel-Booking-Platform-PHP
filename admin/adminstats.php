<?php
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "reliance_travels");

/* ---------------------------
   1. Monthly Bookings Count
--------------------------- */

$bookingsQuery = "
SELECT 
    MONTH(booked_at) AS month,
    COUNT(*) AS count
FROM bookings
GROUP BY MONTH(booked_at)
ORDER BY MONTH(booked_at)
";

$bookingsResult = $conn->query($bookingsQuery);
$bookings = [];

while ($row = $bookingsResult->fetch_assoc()) {
    $bookings[] = $row;
}

/* ---------------------------
   2. Monthly Revenue (PAID only)
--------------------------- */

$revenueQuery = "
SELECT 
    MONTH(booked_at) AS month,
    SUM(total_cost) AS revenue
FROM bookings
WHERE status='PAID'
GROUP BY MONTH(booked_at)
ORDER BY MONTH(booked_at)
";

$revenueResult = $conn->query($revenueQuery);
$revenue = [];

while ($row = $revenueResult->fetch_assoc()) {
    $revenue[] = $row;
}

/* ---------------------------
   3. Booking Status Breakdown
--------------------------- */

$statusQuery = "
SELECT status, COUNT(*) as total 
FROM bookings 
GROUP BY status
";

$statusResult = $conn->query($statusQuery);
$status = [];

while ($row = $statusResult->fetch_assoc()) {
    $status[$row["status"]] = $row["total"];
}

/* ---------------------------
   ✅ Final JSON Output
--------------------------- */
echo json_encode([
    "bookings" => $bookings,
    "revenue"  => $revenue,
    "status"   => $status
]);

?>
