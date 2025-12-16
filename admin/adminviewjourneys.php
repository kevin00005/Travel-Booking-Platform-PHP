<?php
// ✅ DB CONNECT
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reliance_travels";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("DB Error"); }

// ✅ Filter selections
$selectedRegions = $_POST["region"] ?? [];
$selectedSeasons = $_POST["season"] ?? [];
$selectedDays    = $_POST["days"] ?? [];

// ✅ Build Query
$sql = "SELECT * FROM cities WHERE 1";

if (!empty($selectedRegions) && !in_array("All", $selectedRegions)) {
    $sql .= " AND region IN ('" . implode("','", $selectedRegions) . "')";
}

if (!empty($selectedSeasons) && !in_array("All", $selectedSeasons)) {
    $sql .= " AND season IN ('" . implode("','", $selectedSeasons) . "')";
}

if (!empty($selectedDays) && !in_array("All", $selectedDays)) {
    $sql .= " AND days IN ('" . implode("','", $selectedDays) . "')";
}

$result = $conn->query($sql);
$data = [];
while ($row = $result->fetch_assoc()) { $data[] = $row; }

// ✅ DELETE
if (isset($_GET["delete"])) {
    $id = $_GET["delete"];
    $stmt = $conn->prepare("DELETE FROM cities WHERE cityid=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo "<script>alert('Journey Deleted'); window.location='adminviewjourneys.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin: View Journeys</title>
<link rel="stylesheet" href="./css/admindashboard.css">
<link rel="stylesheet" href="./css/adminviewjourneys.css">
<style>
/* ✅ PAGE WRAPPER */
.page-wrapper{
    padding:30px;
}

/* ✅ FILTER BOX */
.filter-box{
    display:flex;
    gap:20px;
    margin-bottom:20px;
}

.custom-dropdown{
    background:white;
    padding:10px 15px;
    border-radius:10px;
    border:1px solid #ddd;
    box-shadow:0 3px 10px rgba(0,0,0,0.1);
    cursor:pointer;
    position:relative;
}

.custom-dropdown span{
    font-weight:600;
    color:#ff1b85;
}

.custom-dropdown-content{
    display:none;
    position:absolute;
    background:white;
    padding:15px;
    top:45px;
    left:0;
    width:180px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,0.15);
    z-index:10;
}

.custom-dropdown-content label{
    display:block;
    margin-bottom:7px;
    font-size:14px;
}

/* ✅ TABLE */
table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
    background:white;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

table th{
    background:#ff1b85;
    color:white;
    padding:12px;
    font-size:15px;
}

table td{
    padding:12px;
    border-bottom:1px solid #eee;
}

tr:hover{
    background:#fff4fa;
}

/* ✅ BUTTONS */
.back{
    color:#ff1b85;
    font-weight:600;
    text-decoration:none;
}

.delete-button{
    padding:8px 15px;
    background:#ff1b85;
    color:white;
    border-radius:8px;
    text-decoration:none;
    font-size:14px;
}

.delete-button:hover{
    background:#d9006c;
}

.insert-button{
    background:#28a745;
    padding:12px 20px;
    color:white;
    font-weight:bold;
    border-radius:10px;
    text-decoration:none;
}

.insert-button:hover{
    background:#1f7f36;
}
</style>

<script>
function toggleDropdown(name){
    let box=document.getElementById(name+"Dropdown");
    box.style.display = box.style.display==="block" ? "none":"block";
}
</script>
</head>

<body>
<div class="page-wrapper">

<a class="back" href="admindashboard.php">← Back to Dashboard</a>

<h1 style="color:#ff1b85;">City Journeys (Sri Lanka)</h1>

<form method="post">

<h3>Filters</h3>

<div class="filter-box">

    <!-- ✅ Region -->
    <div class="custom-dropdown">
        <span onclick="toggleDropdown('region')">Region</span>
        <div id="regionDropdown" class="custom-dropdown-content">
            <?php
            $regions = ["All","North","South","East","West","Central","North-West","North-Central","Uva","Sabaragamuwa"];
            foreach ($regions as $r){
                echo "<label><input type='checkbox' name='region[]' value='$r' ".(in_array($r,$selectedRegions)?"checked":"")."> $r</label>";
            }
            ?>
        </div>
    </div>

    <!-- ✅ Season -->
    <div class="custom-dropdown">
        <span onclick="toggleDropdown('season')">Season</span>
        <div id="seasonDropdown" class="custom-dropdown-content">
            <?php
            $seasons = ["All","Winter","Summer","Monsoon","Spring","Autumn"];
            foreach ($seasons as $s){
                echo "<label><input type='checkbox' name='season[]' value='$s' ".(in_array($s,$selectedSeasons)?"checked":"")."> $s</label>";
            }
            ?>
        </div>
    </div>

    <!-- ✅ Days -->
    <div class="custom-dropdown">
        <span onclick="toggleDropdown('days')">Days</span>
        <div id="daysDropdown" class="custom-dropdown-content">
            <?php
            $daysOptions = ["All","1","2","3","4","5","7"];
            foreach ($daysOptions as $d){
                echo "<label><input type='checkbox' name='days[]' value='$d' ".(in_array($d,$selectedDays)?"checked":"")."> $d</label>";
            }
            ?>
        </div>
    </div>

</div>

<input type="submit" value="Filter" class="insert-button">
</form>

<h3 style="margin-top:30px;color:#ff1b85;">Available Sri Lankan Journeys</h3>

<table>
<tr>
    <th>ID</th>
    <th>City</th>
    <th>Region</th>
    <th>Season</th>
    <th>Days</th>
    <th>Cost (LKR)</th>
    <th>Action</th>
</tr>

<?php foreach($data as $row): ?>
<tr>
    <td><?= $row["cityid"] ?></td>
    <td><?= $row["city"] ?></td>
    <td><?= $row["region"] ?></td>
    <td><?= $row["season"] ?></td>
    <td><?= $row["days"] ?></td>
    <td><?= number_format($row["cost"]) ?></td>
    <td><a class="delete-button" href="?delete=<?= $row["cityid"] ?>">Delete</a></td>
</tr>
<?php endforeach; ?>
</table>

<br><br>
<a class="insert-button" href="addjourneyform.php">+ Add Sri Lanka Journey</a>

</div>
</body>
</html>
