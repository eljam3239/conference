<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Students in Hotel Rooms</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        h2 {
            color: #333;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        h3 {
            color: #444;
            margin-top: 25px;
        }
        form {
            margin: 20px 0;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 5px;
            max-width: 500px;
        }
        label {
            display: inline-block;
            width: 100px;
            margin-right: 10px;
        }
        select {
            padding: 8px;
            width: 150px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-right: 10px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 800px;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
        }
        button:hover {
            background-color: #45a049;
        }
        .no-students {
            color: #666;
            font-style: italic;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <h2>Select a Hotel Room</h2>
    <form method="post">
        <label for="hotelroom">Choose Room:</label>
        <select name="roomnum" id="hotelroom" required>
            <option value="">-- Select Room --</option>
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
            echo "<h3>Students in Room $roomnum:</h3>";
            echo "<table>";
            echo "<tr><th>First Name</th><th>Last Name</th><th>Email</th></tr>";
            foreach ($students as $student) {
                echo "<tr>
                        <td>{$student['firtname']}</td>
                        <td>{$student['lastname']}</td>
                        <td>{$student['email']}</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='no-students'>No students assigned to Room $roomnum</p>";
        }
    }
    ?>
    
    <button onclick="window.location.href='conference.php'">Home</button>
</body>
</html>