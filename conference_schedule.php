<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Conference Schedule</title>
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
            echo "<table border='1'>";
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
            echo "<p>No sessions scheduled for $seshdate.</p>";
        }
    }
    ?>

    <button onclick="window.location.href='conference.php'">Home</button>
</body>
</html>
