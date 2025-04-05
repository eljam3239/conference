<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Conference Intake Summary</title>
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
    echo "<h3>Total Sponsorship Intake: $" . number_format($totalSponsorship, 2) . "</h3>";
    echo "<h3>Total Registration Intake: $" . number_format($totalRegistration, 2) . "</h3>";
    echo "<h2>Grand Total: $" . number_format($totalSponsorship + $totalRegistration, 2) . "</h2>";
    ?>

    <br><button onclick="window.location.href='conference.php'">Home</button>
</body>
</html>
