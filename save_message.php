<?php
// ✅ DB Connection
$conn = new mysqli("localhost", "root", "", "reliance_travels");

if ($conn->connect_error) {
    die("DB Error");
}

// ✅ Capture form data safely
$name    = $_POST["name"] ?? "";
$email   = $_POST["email"] ?? "";
$phone   = $_POST["phone"] ?? "";
$message = $_POST["message"] ?? "";

// ✅ Save into DB
$stmt = $conn->prepare("INSERT INTO messages (name, email, phone, message) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $phone, $message);
$stmt->execute();
$stmt->close();

// ✅ Auto redirect + styled pink popup
echo "
<!DOCTYPE html>
<html>
<head>
<title>Message Sent</title>
<style>
body {
    margin: 0;
    height: 100vh;
    font-family: 'Poppins', sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    background: radial-gradient(circle, #ffb3d9, #ff1b85, #d6006c);
    overflow: hidden;
}

/* ✅ Glass effect box */
.box {
    background: rgba(255, 255, 255, 0.12);
    border-radius: 20px;
    padding: 40px 55px;
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    box-shadow: 0 0 25px rgba(255, 27, 133, 0.6),
                0 0 60px rgba(255, 27, 133, 0.4);
    text-align: center;
    color: white;
    animation: fadeIn 0.7s ease;
}

/* ✅ Animation */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px) scale(0.9); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}

/* ✅ Check Icon */
.check {
    font-size: 75px;
    margin-bottom: 10px;
    animation: pop 0.6s ease-out;
}

@keyframes pop {
    0% { transform: scale(0.2); opacity: 0; }
    70% { transform: scale(1.2); opacity: 1; }
    100% { transform: scale(1); }
}

p {
    font-size: 22px;
    margin: 10px 0;
}

/* ✅ Small text */
.small {
    font-size: 14px;
    opacity: 0.8;
}
</style>

<!-- ✅ Auto redirect to home -->
<meta http-equiv='refresh' content='1.8; URL=home.php' />

</head>

<body>

    <div class='box'>
        <div class='check'>✅</div>
        <p><b>Message Sent Successfully</b></p>
        <p class='small'>Redirecting...</p>
    </div>

</body>
</html>
";
?>
