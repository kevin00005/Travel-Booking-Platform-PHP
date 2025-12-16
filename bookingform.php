<?php
// ---- DB CONNECT ----
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "reliance_travels";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    exit("Database connection failed.");
}

// ---- CLEAN INPUT ----
function safe_int($v) {
    return (isset($v) && ctype_digit((string)$v)) ? (int)$v : null;
}

$cityId  = safe_int($_GET['city_id'] ?? null);
$hotelId = safe_int($_GET['hotel_id'] ?? null);

if (!$cityId || !$hotelId) {
    exit("Invalid access. Use: bookingform.php?city_id=1&hotel_id=2");
}

// ---- LOAD CITY ----
$stmt = $conn->prepare("SELECT * FROM cities WHERE cityid = ?");
$stmt->bind_param("i", $cityId);
$stmt->execute();
$city = $stmt->get_result()->fetch_assoc();
if (!$city) exit("City not found.");

// ---- LOAD HOTEL ----
$stmt = $conn->prepare("SELECT * FROM hotels WHERE hotelid = ?");
$stmt->bind_param("i", $hotelId);
$stmt->execute();
$hotel = $stmt->get_result()->fetch_assoc();
if (!$hotel) exit("Hotel not found.");


// ---- PRICE CALC ----
$cityCost  = (float)$city['cost'];
$hotelCost = (float)$hotel['cost'];
$days      = (int)$city['days'];

$basePerPerson = $cityCost + ($hotelCost * $days);

// ---- HANDLE FORM SUBMIT ----
$errorMsg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Collect user inputs
    $fullName   = trim($_POST["fullname"] ?? "");
    $email      = trim($_POST["email"] ?? "");
    $contact    = trim($_POST["contact"] ?? "");
    $travelDate = trim($_POST["travel_date"] ?? "");
    $tourists   = (int)($_POST["tourists"] ?? 1);

    if ($fullName === "" || $email === "" || $contact === "" || $travelDate === "" || $tourists < 1) {
        $errorMsg = "All fields are required!";
    } else {

        $totalCost = $basePerPerson * $tourists;

        // ✅ INSERT BOOKING INTO TABLE FIRST
        $stmt = $conn->prepare("
            INSERT INTO bookings (cityid, user_name, tourists, travel_date, contact, total_cost, booked_at)
            VALUES (?, ?, ?, ?, ?, ?, NOW())
        ");

        $stmt->bind_param(
            "isissd",
            $cityId,
            $fullName,
            $tourists,
            $travelDate,
            $contact,
            $totalCost
        );

        if ($stmt->execute()) {
            // ✅ Get auto booking_id
            $bookingId = $stmt->insert_id;

            // ✅ Redirect to PayHere through payment.php
            header("Location: payment.php?booking_id=$bookingId");
            exit;

        } else {
            $errorMsg = "Failed to save booking.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Book Your Trip – <?php echo $city['city']; ?></title>
    <meta charset="utf-8">

<style>
body { font-family: Arial; background:#ffe6f4; margin:0; padding:20px; }
.container { width:85%; margin:auto; padding:20px; background:#fff; border-radius:15px; }
h1 { color:#ff1b85; }
.card { padding:20px; background:#fafafa; border-radius:14px; box-shadow:0 3px 10px rgba(0,0,0,0.1); margin-bottom:20px; }
label { font-weight:bold; display:block; margin-top:10px; }
input { width:100%; padding:10px; border:1px solid #ddd; border-radius:8px; }
.btn { margin-top:15px; display:block; padding:12px; text-align:center; color:white; background:#ff1b85; border-radius:10px; text-decoration:none; font-weight:bold; }
.btn:hover { background:#d9006c; }

.price-box { font-size:20px; font-weight:bold; margin-top:10px; }
.msg { padding:10px; border-radius:10px; }
.err { background:#ffe5e5; color:#a00; }
</style>

</head>

<body>

<div class="container">

    <h1>Booking – <?php echo $city["city"]; ?></h1>

    <?php if ($errorMsg): ?>
        <div class="msg err"><?php echo $errorMsg; ?></div>
    <?php endif; ?>

    <div class="card">
        <h2>Your Selected Hotel</h2>
        <p><strong><?php echo $hotel["hotel"]; ?></strong></p>
        <p>Cost per night: Rs <?php echo number_format($hotelCost); ?></p>
        <p>Tour duration: <?php echo $days; ?> days</p>
        <p><strong>Per Person Cost:</strong> Rs <?php echo number_format($basePerPerson); ?></strong></p>
    </div>

    <div class="card">
        <h2>Your Details</h2>

        <form method="POST">

            <label>Full Name</label>
            <input type="text" name="fullname" required>

            <label>Email Address</label>
            <input type="email" name="email" required>

            <label>Contact Number</label>
            <input type="text" name="contact" required>

            <label>Travel Date</label>
            <input type="date" name="travel_date" required>

            <label>No. of Tourists</label>
            <input type="number" id="tourists" name="tourists" min="1" value="1" required>

            <p class="price-box">Total Cost: Rs <span id="totalShow"><?php echo number_format($basePerPerson); ?></span></p>

            <button class="btn">Proceed to Pay</button>
        </form>
    </div>

</div>

<script>
let base = <?php echo $basePerPerson; ?>;
let touristsInput = document.getElementById("tourists");
let totalShow = document.getElementById("totalShow");

touristsInput.addEventListener("input", () => {
    let t = parseInt(touristsInput.value) || 1;
    totalShow.textContent = (base * t).toLocaleString();
});
</script>

</body>
</html>
