<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reliance_travels";

// DB Connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Read inputs
    $city   = $_POST["city"];
    $region = $_POST["region"];
    $season = $_POST["season"];
    $days   = intval($_POST["days"]);
    $cost   = floatval($_POST["cost"]);

    // Insert SQL
    $sql = "INSERT INTO cities (city, region, season, days, cost) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssii", $city, $region, $season, $days, $cost);

        if ($stmt->execute()) {
            // Redirect to journeys page
            header("Location: adminviewjourneys.php?added=1");
            exit();
        } else {
            echo "Insert Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Statement Error: " . $conn->error;
    }
} else {
    echo "Invalid access.";
}

$conn->close();
?>
