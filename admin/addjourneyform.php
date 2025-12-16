<!DOCTYPE html>
<html>
<head>
    <title>Add Sri Lanka Journey</title>
    <link rel="stylesheet" href="./css/addjourney.css">
</head>

<body>

<a href="admindashboard.php" class="back">Back to Dashboard</a>
<h2>Add Sri Lanka Journey</h2>

<form action="addjourney.php" method="POST">

    <label>City Name:</label>
    <input type="text" name="city" placeholder="Ex: Kandy, Galle, Ella" required>

    <label>Region:</label>
    <select name="region" required>
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

    <label>Season:</label>
    <select name="season" required>
        <option value="All">All Season</option>
        <option value="Winter">Winter</option>
        <option value="Summer">Summer</option>
        <option value="Monsoon">Monsoon</option>
        <option value="Spring">Spring</option>
        <option value="Autumn">Autumn</option>
    </select>

    <label>Days:</label>
    <select name="days" required>
        <option value="1">1 Day</option>
        <option value="2">2 Days</option>
        <option value="3">3 Days</option>
        <option value="4">4 Days</option>
        <option value="5">5 Days</option>
        <option value="7">7 Days</option>
    </select>

    <label>Cost (LKR):</label>
    <input type="number" name="cost" placeholder="Ex: 25000" required>

    <button type="submit">Add Journey</button>

</form>

</body>
</html>
