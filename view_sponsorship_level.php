<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Sponsorship Levels</title>
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
        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 600px;
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
        .no-companies {
            color: #666;
            font-style: italic;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <h2>List of Sponsor Companies and Their Levels</h2>

    <?php
    $query = "SELECT name, tier FROM company ORDER BY 
              CASE tier
                WHEN 'Platinum' THEN 1
                WHEN 'Gold' THEN 2
                WHEN 'Silver' THEN 3
                WHEN 'Bronze' THEN 4
                ELSE 5
              END, name";
    $stmt = $pdo->query($query);
    $companies = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($companies) > 0) {
        echo "<table>";
        echo "<tr><th>Company Name</th><th>Sponsorship Tier</th></tr>";
        foreach ($companies as $company) {
            echo "<tr>
                    <td>{$company['name']}</td>
                    <td>{$company['tier']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='no-companies'>No sponsoring companies found.</p>";
    }
    ?>

    <button onclick="window.location.href='conference.php'">Home</button>
</body>
</html>