<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Sponsorship Levels</title>
</head>
<body>
    <h2>List of Sponsor Companies and Their Levels</h2>

    <?php
    $query = "SELECT name, tier FROM company ORDER BY tier, name";
    $stmt = $pdo->query($query);
    $companies = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($companies) > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Company Name</th><th>Sponsorship Tier</th></tr>";
        foreach ($companies as $company) {
            echo "<tr>
                    <td>{$company['name']}</td>
                    <td>{$company['tier']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No sponsoring companies found.</p>";
    }
    ?>

    <button onclick="window.location.href='conference.php'">Home</button>
</body>
</html>
