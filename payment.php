<?php
// ------------------------------
// ✅ PayHere Sandbox Constants
// ------------------------------
$merchant_id     = "1232814";  // ✅ Your Sandbox Merchant ID
$merchant_secret = "MzA4NTEzNzk0OTc2MzU1MTUwMzEyMTQzODY4NTQxMjk0Mjg4NDA5"; // ✅ Sandbox Merchant Secret

// ------------------------------
// ✅ Validate booking_id
// ------------------------------
if (!isset($_GET["booking_id"])) {
    exit("❌ Missing booking_id");
}

$booking_id = intval($_GET["booking_id"]);

// ------------------------------
// ✅ DB Connect
// ------------------------------
$conn = new mysqli("localhost", "root", "", "reliance_travels");
if ($conn->connect_error) {
    exit("DB Error");
}

// ------------------------------
// ✅ Load Booking Details
// ------------------------------
$stmt = $conn->prepare("
    SELECT b.*, c.city 
    FROM bookings b
    JOIN cities c ON b.cityid = c.cityid
    WHERE b.booking_id = ?
    LIMIT 1
");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$booking = $stmt->get_result()->fetch_assoc();

if (!$booking) {
    exit("❌ Booking not found!");
}

$city           = $booking["city"];
$user_name      = $booking["user_name"];
$contact        = $booking["contact"];
$travel_date    = $booking["travel_date"];
$tourists       = $booking["tourists"];
$amount         = number_format($booking["total_cost"], 2, '.', ''); // correct format

// ------------------------------
// ✅ Payment Parameters
// ------------------------------
$order_id      = "ORDER_" . $booking_id;
$currency      = "LKR";

$return_url    = "http://localhost/reliance/payment_success.php?booking_id=$booking_id";
$cancel_url    = "http://localhost/reliance/payment_cancel.php?booking_id=$booking_id";
$notify_url    = "http://localhost/reliance/payment_notify.php";

// ------------------------------
// ✅ Generate Hash Signature
// ------------------------------
$hash = strtoupper(
    md5(
        $merchant_id .
        $order_id .
        $amount .
        $currency .
        strtoupper(md5($merchant_secret))
    )
);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Processing Payment...</title>
</head>

<body>
    <h2>Connecting to PayHere...</h2>
    <p>Please wait. Do not refresh.</p>

    <!-- ✅ Auto-submit PayHere Form -->
    <form id="payForm" method="post" action="https://sandbox.payhere.lk/pay/checkout">

        <!-- Required Fields -->
        <input type="hidden" name="merchant_id" value="<?php echo $merchant_id; ?>">
        <input type="hidden" name="return_url" value="<?php echo $return_url; ?>">
        <input type="hidden" name="cancel_url" value="<?php echo $cancel_url; ?>">
        <input type="hidden" name="notify_url" value="<?php echo $notify_url; ?>">

        <!-- Order Details -->
        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
        <input type="hidden" name="items" value="<?php echo $city; ?> Tour Package">
        <input type="hidden" name="currency" value="LKR">
        <input type="hidden" name="amount" value="<?php echo $amount; ?>">

        <!-- Buyer Details -->
        <input type="hidden" name="first_name" value="<?php echo $user_name; ?>">
        <input type="hidden" name="last_name" value="Customer">
        <input type="hidden" name="email" value="demo@demo.com">
        <input type="hidden" name="phone" value="<?php echo $contact; ?>">
        <input type="hidden" name="address" value="Sri Lanka">
        <input type="hidden" name="city" value="Colombo">
        <input type="hidden" name="country" value="Sri Lanka">

        <!-- Signature -->
        <input type="hidden" name="hash" value="<?php echo $hash; ?>">

    </form>

    <script>
        document.getElementById("payForm").submit();
    </script>
</body>
</html>
