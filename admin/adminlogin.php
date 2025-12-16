<?php
session_start();

$serverName = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "reliance_travels";

$conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

$error = ""; // Initialize error variable

// ✅ --- ALL LOGIN LOGIC MOVED HERE ---
// This block now runs *before* any HTML is sent
if (isset($_POST['Signin'])) {
    $name = mysqli_real_escape_string($conn, $_POST['AdminName']);
    $pwd  = mysqli_real_escape_string($conn, $_POST['AdminPassword']);

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM admin_login WHERE Admin_Name = ? AND Admin_Password = ?");
    $stmt->bind_param("ss", $name, $pwd);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        // ✅ SUCCESS: Set session and redirect
        $_SESSION['AdminLoginId'] = $name;
        header("location: admindashboard.php");
        exit; // Always exit after a header redirect
    } else {
        // ✅ FAILED: Set the error message variable
        $error = "Incorrect username or password!";
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Reliance Travels</title>

    <!-- ✅ External CSS -->
    <link rel="stylesheet" type="text/css" href="../css/adminlogin.css">

    <!-- ✅ Bootstrap Icons -->
    <link rel="stylesheet" 
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

    <!-- ✅ Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" 
          rel="stylesheet">
</head>

<body>

    <div class="login-container">
        <a href="../home.php" class="back-btn">
            <i class="bi bi-arrow-left"></i> Back to Home
        </a>

        <div class="login-card">
            <h2>Admin Login</h2>

            <!-- 
              ✅ This block now works perfectly!
              It checks the $error variable set at the top.
            -->
            <?php if ($error): ?>
                <p class="error-msg"><?php echo $error; ?></p>
            <?php endif; ?>

            <form method="POST">
                <div class="input-box">
                    <i class="bi bi-person-circle"></i>
                    <input type="text" name="AdminName" placeholder="Admin Username" required>
                </div>

                <div class="input-box">
                    <i class="bi bi-shield-lock"></i>
                    <input type="password" name="AdminPassword" placeholder="Password" required>
                </div>

                <button type="submit" name="Signin"><span>Sign In</span></button>

                <div class="extra-links">
                    <a href="#">Forgot Password?</a>
                </div>
            </form>
        </div>
    </div>

<?php
// ✅ The JavaScript block that was here has been removed, 
// as it's no longer needed for error handling.
?>
</body>
</html>