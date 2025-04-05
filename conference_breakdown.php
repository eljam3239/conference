<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Conference Intake Summary</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        h2, h3 {
            color: #333;
        }
        h2 {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
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
        .total {
            font-weight: bold;
            color: #2c3e50;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <h2>Conference Financial Intake Summary</h2>

    <?php
    // Sponsorship calculation
    $tierAmounts = [
        'Platinum' => 10000,
        'Gold' => 5000,
        'Silver' => 3000,
        'Bronze' => 1000
    ];

    $stmt = $pdo->query("SELECT tier FROM company");
    $totalSponsorship = 0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $tier = $row['tier'];
        if (isset($tierAmounts[$tier])) {
            $totalSponsorship += $tierAmounts[$tier];
        }
    }

    // Registration calculation
    $registrationTables = ['student', 'professional', 'sponsorattendee'];
    $totalRegistration = 0;

    foreach ($registrationTables as $table) {
        $stmt = $pdo->query("SELECT SUM(rate) AS total FROM $table");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row && $row['total']) {
            $totalRegistration += $row['total'];
        }
    }

    // Display results
    echo "<div class='total'>Total Sponsorship Intake: $" . number_format($totalSponsorship, 2) . "</div>";
    echo "<div class='total'>Total Registration Intake: $" . number_format($totalRegistration, 2) . "</div>";
    echo "<div class='total' style='font-size: 1.3em; margin-top: 25px;'>Grand Total: $" . number_format($totalSponsorship + $totalRegistration, 2) . "</div>";
    ?>

    <br><button onclick="window.location.href='conference.php'">Home</button>
</body>
</html>