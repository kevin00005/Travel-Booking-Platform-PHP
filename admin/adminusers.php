<?php
// ✅ DB CONNECTION
$servername = "localhost";
$username = "root";
$password = "";
$database = "reliance_travels";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ✅ Fetch admin login data
$sql = "SELECT srno, Admin_Name FROM admin_login";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Accounts</title>

    <!-- ✅ FIXED CORRECT CSS PATH -->
    <link rel="stylesheet" type="text/css" href="../css/adminusers.css">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>

<a href="admindashboard.php" class="back-btn">
    <i class="fa fa-arrow-left"></i> Back to Dashboard
</a>

<h1>Admin Accounts</h1>

<div class="card">

    <!-- ✅ TOTAL ADMINS -->
    <p class="count">Total Admins: <?= $result->num_rows; ?></p>

    <!-- ✅ Search Bar -->
    <input type="text" id="searchInput" class="search" placeholder="Search admin...">

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Admin Name</th>
            </tr>
        </thead>

        <tbody id="adminTable">
            <?php 
            $counter = 1;
            if ($result->num_rows > 0):
                while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $counter++; ?></td>
                    <td><?= $row['Admin_Name']; ?></td>
                </tr>
            <?php 
                endwhile;
            else: ?>
                <tr>
                    <td colspan="2">No admins found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>

<script>
// ✅ Live Search Filter (Admin Table)
document.getElementById("searchInput").addEventListener("keyup", function () {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll("#adminTable tr");

    rows.forEach(row => {
        let text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? "" : "none";
    });
});
</script>

</body>
</html>
