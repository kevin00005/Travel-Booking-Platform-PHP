<?php
// ✅ Database Connection for Dynamic Places Section
$conn = new mysqli("localhost", "root", "", "reliance_travels");

if ($conn->connect_error) {
    die("DB Connection Failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM cities";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reliance Travels</title>

    <!-- Icons & Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- ✅ Main CSS -->
    <link rel="stylesheet" href="./css/style.css">

    <!-- ✅ Leaflet FREE MAP CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <style>
        /* ✅ Map Glass Box Container */
        .map-section {
            width: 95%;
            max-width: 1400px;
            margin: auto;
            margin-top: 60px;
            margin-bottom: 60px;
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .map-glass {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 3rem;
            box-shadow: 0 8px 32px rgba(255, 27, 133, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .map-glass:hover {
            box-shadow: 0 12px 40px rgba(255, 27, 133, 0.3);
            transform: translateY(-5px);
        }

        #travelMap {
            width: 100%;
            height: 480px;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            border: 2px solid rgba(255, 255, 255, 0.5);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        #travelMap:hover {
            box-shadow: 0 12px 32px rgba(0,0,0,0.2);
        }

        /* ✅ Pink Marker Style */
        .pink-marker {
            background: linear-gradient(135deg, #ff1b85 0%, #d9006c 100%);
            border-radius: 50%;
            width: 24px;
            height: 24px;
            border: 4px solid white;
            box-shadow: 0 4px 20px rgba(255, 27, 133, 0.6);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 4px 20px rgba(255, 27, 133, 0.6);
            }
            50% {
                transform: scale(1.1);
                box-shadow: 0 6px 30px rgba(255, 27, 133, 0.8);
            }
        }

        /* ✅ City Buttons */
        .map-buttons {
            margin-bottom: 2rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .map-buttons button {
            padding: 1.2rem 2.5rem;
            border: none;
            background: linear-gradient(135deg, #ff1b85 0%, #d9006c 100%);
            color: white;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            font-size: 1.4rem;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(255, 27, 133, 0.3);
            position: relative;
            overflow: hidden;
        }

        .map-buttons button::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .map-buttons button:hover::before {
            width: 300px;
            height: 300px;
        }

        .map-buttons button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 27, 133, 0.4);
        }

        .map-buttons button:active {
            transform: translateY(-1px);
        }

        /* Enhanced hero content */
        .home .content.glass-box {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            animation: fadeInUp 1s ease-out;
        }

        /* Smooth scroll behavior */
        html {
            scroll-behavior: smooth;
        }

        /* Loading animation for images */
        .products .box-container .box .image img {
            transition: opacity 0.3s ease;
        }

        /* Enhanced review section if exists */
        .review .box-container .box {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</head>

<body>

<!-- ✅ HEADER -->
<header>
    <input type="checkbox" id="toggler">
    <label for="toggler" class="fas fa-bars"></label>

    <a href="#home" class="logo"><span>Reliance</span> Travels</a>

    <nav class="navbar">
        <a href="#home">Home</a>
        <a href="#about">About</a>
        <a href="#products">Places</a>
        <a href="#review">Review</a>
        <a href="#map">Map</a>
        <a href="./Login/login.php">Login/Signup</a>
        <a href="./admin/adminlogin.php">Admin</a>
    </nav>

    <div class="icons">
        <a href="#" class="fas fa-heart" title="Favorites"></a>
        <a href="#" class="fas fa-shopping-cart" title="Cart"></a>
        <a href="./Login/login.php" class="fas fa-user" title="Account"></a>
    </div>
</header>

<!-- ✅ HERO SECTION WITH GLASS GLOW -->
<section class="home" id="home"
style="
background: linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.6)), url('./images/home-bg.jpg') center/cover no-repeat fixed;
padding-top: 140px;
">

    <div class="content glass-box"
    style="width: 60%; max-width: 700px; margin-left: 5%; padding: 5rem 4rem; border-radius: 30px;">
        
        <span>
            Discover Sri Lanka
        </span>

        <p>
            Where every place is a story and every journey becomes a cherished memory. Explore breathtaking landscapes, rich culture, and unforgettable adventures.
        </p>

        <a href="#products" class="btn">
            <i class="fas fa-plane"></i> Travel Now
        </a>

    </div>
</section>

<!-- ✅ ABOUT SECTION -->
<section class="about" id="about">
    <h1 class="heading"> <span> about </span> us </h1>

    <div class="row glass-box" style="padding: 3rem; border-radius:24px; max-width: 1200px; margin: 0 auto;">
        <div class="video-container">
            <video src="./images/about-vid.mp4" loop autoplay muted playsinline></video>
            <h3>Best Places</h3>
        </div>

        <div class="content">
            <h3>why choose us?</h3>
            <p>
                Explore Sri Lanka like never before — beaches, wildlife, culture, adventure, and breathtaking scenery.
                We provide top-tier packages at the best prices with personalized service and unforgettable experiences.
            </p>
            <a href="#review" class="btn">
                <i class="fas fa-arrow-right"></i> Learn More
            </a>
        </div>
    </div>
</section>

<!-- ✅ ICONS SECTION -->
<section class="icons-container">

    <div class="icons glass-box">
        <img src="./images/icon-1.png">
        <div class="info"><h3>free booking</h3><span>on all packages</span></div>
    </div>

    <div class="icons glass-box">
        <img src="./images/icon-2.png">
        <div class="info"><h3>10 days returns</h3><span>moneyback guarantee</span></div>
    </div>

    <div class="icons glass-box">
        <img src="./images/icon-3.png">
        <div class="info"><h3>offer & gifts</h3><span>seasonal discounts</span></div>
    </div>

    <div class="icons glass-box">
        <img src="./images/icon-4.png">
        <div class="info"><h3>secure payments</h3><span>protected & safe</span></div>
    </div>

</section>

<!-- ✅ DYNAMIC PLACES SECTION -->
<section class="products" id="products">

    <h1 class="heading"> Popular <span>Places</span> </h1>

    <div class="box-container">

        <?php while ($row = $result->fetch_assoc()): ?>
        <div class="box glass-box">
            <div class="image">
                <img src="Places/<?php echo strtolower(str_replace(' ', '_', $row['city'])); ?>.jpg">
                <div class="icons">
                    <a href="#" class="fas fa-heart"></a>
                    <a href="viewjourney.php?city_id=<?= $row['cityid']; ?>" class="cart-btn">Visit Us</a>
                    <a href="viewjourney.php?city_id=<?= $row['cityid']; ?>" class="fas fa-share"></a>
                </div>
            </div>
            <div class="content">
                <h3><?= $row['city']; ?></h3>
                <div class="price">Rs <?= $row['cost']; ?></div>
            </div>
        </div>
        <?php endwhile; ?>

    </div>
</section>

<!-- ✅ ✅ MAP SECTION BEFORE CONTACT ✅ ✅ -->
<section id="map" class="map-section">
    <h1 class="heading"> Explore <span>Sri Lanka</span> </h1>

    <div class="map-glass">

        <!-- City Buttons -->
        <div class="map-buttons">
            <button onclick="jumpTo('kandy')">Kandy</button>
            <button onclick="jumpTo('ella')">Ella</button>
            <button onclick="jumpTo('jaffna')">Jaffna</button>
            <button onclick="jumpTo('sigiriya')">Sigiriya</button>
        </div>

        <!-- The Actual Map -->
        <div id="travelMap"></div>

    </div>
</section>

<!-- ✅ Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    // ✅ Initialize Map
    var map = L.map('travelMap').setView([7.9, 80.7], 7);

    // ✅ Add Free OpenStreetMap Layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19
    }).addTo(map);

    // ✅ City Coordinates
    const locations = {
        kandy:    { lat: 7.2906, lon: 80.6337, img:"./Places/kandy.jpg" },
        ella:     { lat: 6.8667, lon: 81.0460, img:"./Places/ella.jpg" },
        jaffna:   { lat: 9.6615, lon: 80.0255, img:"./Places/jaffna.jpg" },
        sigiriya: { lat: 7.9570, lon: 80.7603, img:"./Places/sigiriya.jpg" }
    };

    // ✅ Draw Markers
    for (const city in locations) {
        let c = locations[city];

        let icon = L.divIcon({ className: 'pink-marker' });

        L.marker([c.lat, c.lon], { icon }).addTo(map)
        .bindPopup(`<b>${city.toUpperCase()}</b><br><img src="${c.img}" width="120" style="border-radius:8px;">`);
    }

    // ✅ Travel Route Line
    let route = [
        [7.2906, 80.6337],  // Kandy
        [6.8667, 81.0460],  // Ella
        [7.9570, 80.7603],  // Sigiriya
        [9.6615, 80.0255]   // Jaffna
    ];

    L.polyline(route, { color: "#ff1b85", weight: 4 }).addTo(map);

    // ✅ Jump to city function
    function jumpTo(city) {
        let c = locations[city];
        map.flyTo([c.lat, c.lon], 12, { duration: 1.5 });
    }
</script>

<!-- ✅ CONTACT SECTION -->
<section class="contact" id="contact">

    <h1 class="heading"> <span> contact </span> us </h1>

    <div class="row" style="max-width: 1200px; margin: 0 auto;">

        <form action="save_message.php" method="POST">
            <h3 style="font-size: 2.4rem; font-weight: 700; margin-bottom: 2rem; background: linear-gradient(135deg, #ff1b85 0%, #d9006c 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Get in Touch</h3>
            <input type="text" name="name" placeholder="Your Name" class="box" required>
            <input type="email" name="email" placeholder="Your Email" class="box" required>
            <input type="number" name="phone" placeholder="Your Phone" class="box" required>
            <textarea name="message" class="box" placeholder="Your Message" rows="6" required></textarea>
            <input type="submit" value="Send Message" class="btn">
        </form>

        <div class="image">
            <img src="./images/contact-img.svg" alt="Contact Us" style="border-radius: 20px;">
        </div>

    </div>
</section>

<!-- ✅ FOOTER -->
<section class="footer glass-box">

    <div class="box-container">

        <div class="box">
            <h3>quick links</h3>
            <a href="#home">Home</a>
            <a href="#about">About </a>
            <a href="#products">Places</a>
            <a href="#review">Review</a>
            <a href="#contact">Contact Us</a>
        </div>

        <div class="box">
            <h3>extra links</h3>
            <a href="#">My account</a>
            <a href="#">Bookings</a>
            <a href="#">Favorites</a>
        </div>

        <div class="box">
            <h3>Popular Locations</h3>
            <a href="#">Kandy</a>
            <a href="#">Galle</a>
            <a href="#">Ella</a>
            <a href="#">Colombo</a>
        </div>

        <div class="box">
            <h3>contact info</h3>
            <a href="#">email</a>
            <img src="./images/payment.png">
        </div>
    </div>

    <div class="credit">&copy;2025 Reliance Travels</div>

</section>

<!-- ✅ Modern JavaScript Enhancements -->
<script src="./js/script.js"></script>

</body>
</html>
