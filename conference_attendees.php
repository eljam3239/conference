<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Conference Attendees</title>
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
        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 600px;
            margin: 10px 0 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
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
        .no-attendees {
            color: #666;
            font-style: italic;
            margin: 10px 0 20px 0;
        }
    </style>
</head>
<body>
    <h2>Conference Attendees</h2>

    <?php
    // STUDENTS
    $stmt = $pdo->query("SELECT firtname, lastname FROM student ORDER BY lastname, firtname");
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h3>Student Attendees</h3>";
    if (count($students) > 0) {
        echo "<table>";
        echo "<tr><th>First Name</th><th>Last Name</th></tr>";
        foreach ($students as $s) {
            echo "<tr><td>{$s['firtname']}</td><td>{$s['lastname']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='no-attendees'>No student attendees found.</p>";
    }

    // PROFESSIONALS
    $stmt = $pdo->query("SELECT firtname, lastname FROM professional ORDER BY lastname, firtname");
    $pros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h3>Professional Attendees</h3>";
    if (count($pros) > 0) {
        echo "<table>";
        echo "<tr><th>First Name</th><th>Last Name</th></tr>";
        foreach ($pros as $p) {
            echo "<tr><td>{$p['firtname']}</td><td>{$p['lastname']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='no-attendees'>No professional attendees found.</p>";
    }

    // SPONSOR ATTENDEES
    $stmt = $pdo->query("SELECT firtname, lastname FROM sponsorattendee ORDER BY lastname, firtname");
    $sponsors = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h3>Sponsor Attendees</h3>";
    if (count($sponsors) > 0) {
        echo "<table>";
        echo "<tr><th>First Name</th><th>Last Name</th></tr>";
        foreach ($sponsors as $sa) {
            echo "<tr><td>{$sa['firtname']}</td><td>{$sa['lastname']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='no-attendees'>No sponsor attendees found.</p>";
    }
    ?>

    <button onclick="window.location.href='conference.php'">Home</button>
</body>
</html>