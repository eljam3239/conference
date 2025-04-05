<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Students in Hotel Rooms</title>
</head>
<body>
    <h2>Select a Hotel Room</h2>
    <form method="post">
        <label for="hotelroom">Choose:</label>
        <select name="roomnum" id="hotelroom" required>
            <option value="">-- Select --</option>
            <?php
            $stmt = $pdo->query("SELECT DISTINCT roomnum FROM hotelroom ORDER BY roomnum");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['roomnum']}'>{$row['roomnum']}</option>";
            }
            ?>
        </select>
        <input type="submit" value="Show Students">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['roomnum'])) {
        $roomnum = $_POST['roomnum'];

        
        $query = "SELECT firtname, lastname, email 
                  FROM student
                  WHERE hotelroomnumber = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$roomnum]);

        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($students) > 0) {
            echo "<h3>Students in room '$roomnum':</h3>";
            echo "<table border='1'>";
            echo "<tr><th>First Name</th><th>Last Name</th><th>Email</th></tr>";
            foreach ($students as $student) {
                echo "<tr><td>{$student['firtname']}</td><td>{$student['lastname']}</td><td>{$student['email']}</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No students in room $roomnum</p>";
        }
    }
    ?>
    
    <button onclick="window.location.href='conference.php'">Home</button>
</body>
</html>
