<?php
// ---- DATABASE CONNECTION ----
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "reliance_travels";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// ---- FILTER LOGIC ----
$region  = $_POST["region"]  ?? "All";
$season  = $_POST["season"]  ?? "All";
$days    = $_POST["days"]    ?? "All";

$sql = "SELECT * FROM cities WHERE 1=1";

if ($region !== "All") {
    $sql .= " AND region='$region'";
}
if ($season !== "All") {
    $sql .= " AND season='$season'";
}
if ($days !== "All") {
    $sql .= " AND days='$days'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Explore Sri Lanka</title>
    <link rel="stylesheet" href="./css/cities.css">

<style>
/* ✅ Modern Filter UI */
.filter-form {
    text-align: center;
    margin-bottom: 20px;
}

.filters {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
    margin-top: 10px;
}

.filter-box-ui {
    display: flex;
    flex-direction: column;
    background: #fff;
    padding: 10px 15px;
    border: 2px solid #ff58b0;
    border-radius: 12px;
    box-shadow: 0px 2px 5px rgba(0,0,0,0.1);
}

.filter-box-ui label {
    font-weight: bold;
    color: #ff1b85;
    margin-bottom: 5px;
    font-size: 14px;
}

.filter-select {
    padding: 10px;
    border: 2px solid #ff8cc9;
    border-radius: 8px;
    background: #ffe8f5;
    font-size: 14px;
    outline: none;
    cursor: pointer;
}

.filter-select:hover {
    border-color: #ff3195;
    background: #ffd4ee;
}

.apply-btn {
    background: #ff1b85;
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 10px;
    cursor: pointer;
    font-size: 15px;
    margin-top: 18px;
    transition: .3s;
}

.apply-btn:hover {
    background: #e20070;
    transform: scale(1.05);
}

/* ✅ Table Design */
.table-container {
    width: 90%;
    margin: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 25px;
}

th {
    background: #ff1b85;
    color: white;
    padding: 12px;
}

td {
    padding: 10px;
    text-align: center;
    background: #ffe6f4;
}

.view-btn {
    background: #ff1b85;
    padding: 8px 12px;
    color: white;
    border-radius: 6px;
    text-decoration: none;
}

.view-btn:hover {
    background: #e20070;
}
</style>

</head>

<body>

    <div class="navbar">
        <span class="logo">Travelscapes</span>
    </div>

    <div class="content-container">

        <h1 style="text-align:center; color:#ff1b85; margin-top:20px;">
            Explore Sri Lanka
        </h1>

        <!-- ✅ Filter Form -->
        <form method="post" class="filter-form">
            <div class="filters">

                <!-- Region -->
                <div class="filter-box-ui">
                    <label>Region</label>
                    <select name="region" class="filter-select">
                        <option value="All">All Regions</option>
                        <option value="North">North</option>
                        <option value="South">South</option>
                        <option value="East">East</option>
                        <option value="West">West</option>
                        <option value="Central">Central</option>
                        <option value="North-West">North-West</option>
                        <option value="North-Central">North-Central</option>
                        <option value="Uva">Uva</option>
                        <option value="Sabaragamuwa">Sabaragamuwa</option>
                    </select>
                </div>

                <!-- Season -->
                <div class="filter-box-ui">
                    <label>Season</label>
                    <select name="season" class="filter-select">
                        <option value="All">All Seasons</option>
                        <option value="Winter">Winter</option>
                        <option value="Summer">Summer</option>
                        <option value="Monsoon">Monsoon</option>
                        <option value="Spring">Spring</option>
                        <option value="Autumn">Autumn</option>
                    </select>
                </div>

                <!-- Days -->
                <div class="filter-box-ui">
                    <label>Days</label>
                    <select name="days" class="filter-select">
                        <option value="All">All Days</option>
                        <option value="1">1 Day</option>
                        <option value="3">3 Days</option>
                        <option value="5">5 Days</option>
                        <option value="7">7 Days</option>
                    </select>
                </div>

                <button type="submit" class="apply-btn">Apply</button>

            </div>
        </form>

        <h2 style="text-align:center; margin-top:20px;">Available Packages</h2>

        <!-- ✅ Table Results -->
        <div class="table-container">
            <table border="1">
                <tr>
                    <th>City ID</th>
                    <th>City</th>
                    <th>Region</th>
                    <th>Season</th>
                    <th>Days</th>
                    <th>Cost</th>
                    <th>Action</th>
                </tr>

                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row["cityid"] ?></td>
                        <td><?= $row["city"] ?></td>
                        <td><?= $row["region"] ?></td>
                        <td><?= $row["season"] ?></td>
                        <td><?= $row["days"] ?></td>
                        <td>Rs <?= number_format($row["cost"]) ?></td>
                        <td><a class="view-btn" href="viewjourney.php?city_id=<?= $row["cityid"] ?>">View Details</a></td>
                    </tr>
                <?php } ?>

            </table>
        </div>

    </div>

    <footer>
        <p style="text-align:center; margin-top:30px; color:#888;">© 2025 Travelscapes. All Rights Reserved.</p>
    </footer>

</body>
</html>

<?php $conn->close(); ?>
