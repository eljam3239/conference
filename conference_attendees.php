<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Conference Attendees</title>
</head>
<body>
    <h2>Conference Attendees</h2>

    <?php
    // STUDENTS
    $stmt = $pdo->query("SELECT firtname, lastname FROM student ORDER BY lastname, firtname");
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h3>Student Attendees</h3>";
    if (count($students) > 0) {
        echo "<table border='1'>";
        echo "<tr><th>First Name</th><th>Last Name</th></tr>";
        foreach ($students as $s) {
            echo "<tr><td>{$s['firtname']}</td><td>{$s['lastname']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No student attendees found.</p>";
    }

    // PROFESSIONALS
    $stmt = $pdo->query("SELECT firtname, lastname FROM professional ORDER BY lastname, firtname");
    $pros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h3>Professional Attendees</h3>";
    if (count($pros) > 0) {
        echo "<table border='1'>";
        echo "<tr><th>First Name</th><th>Last Name</th></tr>";
        foreach ($pros as $p) {
            echo "<tr><td>{$p['firtname']}</td><td>{$p['lastname']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No professional attendees found.</p>";
    }

    // SPONSOR ATTENDEES
    $stmt = $pdo->query("SELECT firtname, lastname FROM sponsorattendee ORDER BY lastname, firtname");
    $sponsors = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h3>Sponsor Attendees</h3>";
    if (count($sponsors) > 0) {
        echo "<table border='1'>";
        echo "<tr><th>First Name</th><th>Last Name</th></tr>";
        foreach ($sponsors as $sa) {
            echo "<tr><td>{$sa['firtname']}</td><td>{$sa['lastname']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No sponsor attendees found.</p>";
    }
    ?>

    <button onclick="window.location.href='conference.php'">Home</button>
</body>
</html>
