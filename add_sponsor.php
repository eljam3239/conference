<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Add New Sponsor Company</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            margin: 20px 0;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            max-width: 500px;
        }
        input, select {
            margin: 5px 0 15px 0;
            padding: 8px;
            width: 100%;
            box-sizing: border-box;
        }
        input[type="submit"], button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover, button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Add New Sponsor Company</h2>

    <form method="post">
        Company Name: <input type="text" name="name" required><br>
        Tier: 
        <select name="tier" required>
            <option value="">-- Select Tier --</option>
            <option value="Platinum">Platinum</option>
            <option value="Gold">Gold</option>
            <option value="Silver">Silver</option>
            <option value="Bronze">Bronze</option>
        </select><br>
        Number of Emails Sent: <input type="number" name="numemailssent" min="0" required><br>
        <input type="submit" value="Add Sponsor Company">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $tier = $_POST['tier'];
        $numemailssent = $_POST['numemailssent'];

        try {
            $stmt = $pdo->prepare("INSERT INTO company (name, tier, numemailssent) VALUES (?, ?, ?)");
            $stmt->execute([$name, $tier, $numemailssent]);
            echo "<p>Sponsor company added successfully!</p>";
        } catch (PDOException $e) {
            echo "<p>Error adding sponsor company: " . $e->getMessage() . "</p>";
        }
    }
    ?>

    <br><button onclick="window.location.href='conference.php'">Home</button>
</body>
</html>