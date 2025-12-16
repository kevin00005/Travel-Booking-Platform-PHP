<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reliance_travels";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("DB error: " . $conn->connect_error);
}

if (!isset($_GET['city_id'])) {
    die("City not selected.");
}

$cityId = intval($_GET['city_id']);

// ✅ Get city name
$cityQuery = "SELECT city FROM cities WHERE cityid = $cityId";
$cityResult = $conn->query($cityQuery);
$cityRow = $cityResult->fetch_assoc();
$cityName = $cityRow['city'];

// ✅ Get hotels for this city
$hotelQuery = "SELECT * FROM hotels WHERE cityid = $cityId";
$hotelResult = $conn->query($hotelQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hotels in <?php echo ucfirst($cityName); ?> | Reliance Travels</title>

    <style>
        :root {
            --pink: #ff1b85;
            --pink-dark: #d9006c;
            --shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        body {
            background: linear-gradient(135deg, #ffe0f1 0%, #ffd3f1 100%);
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        h1 {
            text-align: center;
            margin-top: 40px;
            color: var(--pink);
            font-size: 2.4rem;
            font-weight: 700;
        }

        .hotel-list {
            width: 90%;
            margin: 30px auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
        }

        .hotel-card {
            background: rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            box-shadow: var(--shadow);
            width: 320px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.3);
            overflow: hidden;
        }

        .hotel-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(255, 27, 133, 0.3);
        }

        .hotel-img {
            width: 100%;
            height: 200px;
            border-radius: 15px;
            object-fit: cover;
            margin-bottom: 15px;
            opacity: 0;
            transform: scale(0.95);
            animation: fadeIn 0.8s ease forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        h3 {
            font-size: 1.4rem;
            margin: 8px 0;
            color: #333;
        }

        p {
            color: #444;
            font-size: 1rem;
            margin: 6px 0;
        }

        .hotel-btn {
            background: var(--pink);
            border: none;
            color: white;
            padding: 12px 22px;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .hotel-btn:hover {
            background: var(--pink-dark);
            transform: scale(1.05);
        }

        .hotel-btn a {
            text-decoration: none;
            color: white;
        }

        @media (max-width: 768px) {
            .hotel-card {
                width: 85%;
            }
        }
    </style>
</head>

<body>

<h1>Hotels in <?php echo ucfirst($cityName); ?></h1>

<div class="hotel-list">
<?php
if ($hotelResult->num_rows > 0) {
    while ($row = $hotelResult->fetch_assoc()) {

        // ✅ --- START: UPDATED IMAGE LOGIC ---
        
        // 1. Get the name, make it lowercase, and trim whitespace
        $hotelNameClean = strtolower(trim($row['hotel']));
        
        // 2. Remove all special characters (like ', !, &, etc.) except spaces and letters/numbers
        // This keeps 'a-z', '0-9', and spaces ' '
        $hotelNameClean = preg_replace('/[^a-z0-9\s]/', '', $hotelNameClean);
        
        // 3. Replace all sequences of spaces with a single underscore
        $hotelNameClean = preg_replace('/\s+/', '_', $hotelNameClean);

        // --- END: UPDATED IMAGE LOGIC ---


        // ✅ Build image path
        $imagePath = "Places/{$hotelNameClean}.jpg";
        $absolutePath = __DIR__ . "/Places/{$hotelNameClean}.jpg";

        // ✅ Check if file exists in the actual folder
        if (!file_exists($absolutePath)) {
            $imagePath = "Places/hotel_default.jpg"; // Fallback image
        }

        echo "<div class='hotel-card'>";
        echo "<img src='{$imagePath}' alt='{$row['hotel']}' class='hotel-img'>";
        echo "<h3>{$row['hotel']}</h3>";
        echo "<p><strong>Cost per day:</strong> Rs " . number_format($row['cost']) . "</p>";
        echo "<p><strong>Amenities:</strong> {$row['amenities']}</p>";
        echo "<button class='hotel-btn'>
                <a href='bookingform.php?city_id=$cityId&hotel_id={$row['hotelid']}'>
                    Select Hotel
                </a>
              </button>";
        echo "</div>";
    }
} else {
    echo "<p style='text-align:center;font-size:20px;'>No hotels available for this city.</p>";
}
?>
</div>

</body>
</html>