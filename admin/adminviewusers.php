<?php
// ✅ DB Connection
$db = new PDO('mysql:host=localhost;dbname=reliance_travels', 'root', '');

$sql = 'SELECT * FROM login';
$stmt = $db->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll();

// Close DB
$db = null;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - View Users</title>

    <!-- ✅ FIXED CORRECT CSS PATH -->
    <link rel="stylesheet" href="../css/adminviewusers.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>

<a href="admindashboard.php" class="back-btn">
    <i class="fa fa-arrow-left"></i> Back to Dashboard
</a>

<h1>Registered Users</h1>

<div class="card">

    <!-- ✅ Search Bar -->
    <input type="text" id="searchInput" class="search" placeholder="Search users...">

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Email</th>
                <th>Username</th>
            </tr>
        </thead>

        <tbody id="userTable">
            <?php 
            $serialNumber = 1;
            foreach ($results as $row): ?>
                <tr>
                    <td><?= $serialNumber; ?></td>
                    <td><?= $row['usersEmail']; ?></td>
                    <td><?= $row['usersuid']; ?></td>
                </tr>
            <?php 
            $serialNumber++; 
            endforeach; ?>
        </tbody>
    </table>

</div>

<script>
// ✅ Live Search Filter
document.getElementById("searchInput").addEventListener("keyup", function () {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll("#userTable tr");

    rows.forEach(row => {
        let text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? "" : "none";
    });
});
</script>

</body>
</html>
