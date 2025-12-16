<?php
// ---- DB CONNECTION ----
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reliance_travels";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// ---- GET CITY ID ----
if (!isset($_GET['city_id'])) {
    die("City not found!");
}

$cityId = intval($_GET['city_id']);

// ---- FETCH CITY DETAILS ----
$sql = "SELECT * FROM cities WHERE cityid = $cityId LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Invalid city selected!");
}

$city = $result->fetch_assoc();

// ---- START: UPDATED IMAGE LOGIC ----
        
// 1. Get the city name, make it lowercase, and trim whitespace
$cityNameClean = strtolower(trim($city["city"]));

// 2. Remove all special characters (like ', !, &, etc.) except letters/numbers and spaces
$cityNameClean = preg_replace('/[^a-z0-9\s]/', '', $cityNameClean);

// 3. Replace all sequences of spaces with a single underscore
$cityNameClean = preg_replace('/\s+/', '_', $cityNameClean);

// 4. Build the final file name
$imageName = $cityNameClean . ".jpg";

// 5. Build the paths
$imagePath = "./Places/" . $imageName; // Relative path for HTML src
$absolutePath = __DIR__ . "/Places/" . $imageName; // Absolute path for PHP file_exists()

// 6. Fallback if image is missing
if (!file_exists($absolutePath)) {
    $imagePath = "./Places/default.jpg"; // Your fallback image
}
// ---- END: UPDATED IMAGE LOGIC ----


$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $city["city"]; ?> - Package Details</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: #ffe6f4;
    margin: 0;
    padding: 0;
}

.navbar {
    background: #ff1b85;
    padding: 15px;
    color: white;
    font-size: 22px;
    font-weight: bold;
}

.container {
    width: 85%;
    margin: auto;
    margin-top: 25px;
    background: #fff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0px 3px 10px rgba(0,0,0,0.1);
}

.city-image {
    width: 100%;
    height: 350px;
    border-radius: 12px;
    object-fit: cover;
}

.details-box {
    margin-top: 20px;
    line-height: 1.8;
    font-size: 18px;
}

.details-box strong {
    color: #ff1b85;
}

.book-btn {
    display: inline-block;
    padding: 12px 20px;
    background: #ff1b85;
    color: white;
    text-decoration: none;
    border-radius: 10px;
    margin-top: 20px;
    font-size: 18px;
    transition: .3s;
}

.book-btn:hover {
    background: #e20070;
    transform: scale(1.05);
}

.back-btn {
    color: #ff1b85;
    text-decoration: none;
}
</style>

</head>

<body>

    <div class="navbar">
        Travelscapes – Sri Lanka
    </div>

    <div class="container">

        <a class="back-btn" href="cities.php">← Back to Packages</a>

        <h1><?php echo $city["city"]; ?></h1>

        <img src="<?php echo $imagePath; ?>" alt="<?php echo $city["city"]; ?>" class="city-image">

        <div class="details-box">
            <p><strong>Region:</strong> <?php echo $city["region"]; ?></p>
            <p><strong>Best Season:</strong> <?php echo $city["season"]; ?></p>
            <p><strong>Recommended Days:</strong> <?php echo $city["days"]; ?> days</p>
            <p><strong>Package Cost:</strong> Rs. <?php echo number_format($city["cost"]); ?></p>
        </div>

        <a href="view_hotels.php?city_id=<?php echo $cityId; ?>" class="book-btn">
            View Available Hotels
        </a>

    </div>

</body>

</html>