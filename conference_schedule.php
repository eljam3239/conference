<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Conference Schedule</title>
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
            max-width: 600px;
        }
        label {
            display: inline-block;
            width: 120px;
            margin-right: 10px;
        }
        select {
            padding: 8px;
            width: 200px;
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
        .no-sessions {
            color: #666;
            font-style: italic;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <h2>Select a Date</h2>
    <form method="post">
        <label for="seshdate">Choose a Date:</label>
        <select name="seshdate" id="seshdate" required>
            <option value="">-- Select Date --</option>
            <?php
            $stmt = $pdo->query("SELECT DISTINCT seshdate FROM sesh ORDER BY seshdate");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['seshdate']}'>{$row['seshdate']}</option>";
            }
            ?>
        </select>
        <input type="submit" value="Show Schedule">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['seshdate'])) {
        $seshdate = $_POST['seshdate'];

        $query = "SELECT s.starttime, s.endtime, s.location, sp.firtname, sp.lastname
                  FROM sesh s
                  LEFT JOIN speaker sp ON s.speakerID = sp.id
                  WHERE s.seshdate = ?
                  ORDER BY s.starttime";

        $stmt = $pdo->prepare($query);
        $stmt->execute([$seshdate]);

        $sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($sessions) > 0) {
            echo "<h3>Schedule for $seshdate:</h3>";
            echo "<table>";
            echo "<tr><th>Start Time</th><th>End Time</th><th>Location</th><th>Speaker</th></tr>";
            foreach ($sessions as $session) {
                $speakerName = $session['firtname'] && $session['lastname']
                    ? "{$session['firtname']} {$session['lastname']}"
                    : "TBA";
                echo "<tr>
                        <td>{$session['starttime']}</td>
                        <td>{$session['endtime']}</td>
                        <td>{$session['location']}</td>
                        <td>$speakerName</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='no-sessions'>No sessions scheduled for $seshdate.</p>";
        }
    }
    ?>

    <button onclick="window.location.href='conference.php'">Home</button>
</body>
</html>