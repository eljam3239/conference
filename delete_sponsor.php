<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Sponsor Company</title>
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
        select, button {
            margin: 10px 0;
            padding: 8px;
        }
        button {
            background-color: #45a049;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }
        .success {
            background-color: #dff0d8;
            color: #3c763d;
        }
        .error {
            background-color: #f2dede;
            color: #a94442;
        }
    </style>
</head>
<body>
    <h2>Delete Sponsor Company</h2>

    <form method="post">
        Select Company to Delete:
        <select name="company_name" required>
            <option value="">-- Select Company --</option>
            <?php
            $stmt = $pdo->query("SELECT name FROM company ORDER BY name");
            while ($company = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$company['name']}'>{$company['name']}</option>";
            }
            ?>
        </select><br>
        <input type="submit" name="delete" value="Delete Company and Associated Attendees">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
        $company_name = $_POST['company_name'];
        
        try {
            $pdo->beginTransaction();
            
            // First delete associated attendees
            $stmt = $pdo->prepare("DELETE FROM sponsorattendee WHERE companyname = ?");
            $stmt->execute([$company_name]);
            $attendees_deleted = $stmt->rowCount();
            
            // Then delete the company
            $stmt = $pdo->prepare("DELETE FROM company WHERE name = ?");
            $stmt->execute([$company_name]);
            $company_deleted = $stmt->rowCount();
            
            $pdo->commit();
            
            if ($company_deleted > 0) {
                echo "<div class='message success'>";
                echo "Successfully deleted company '$company_name' and $attendees_deleted associated attendees.";
                echo "</div>";
            } else {
                echo "<div class='message error'>";
                echo "Company '$company_name' not found or could not be deleted.";
                echo "</div>";
            }
        } catch (PDOException $e) {
            $pdo->rollBack();
            echo "<div class='message error'>";
            echo "Error deleting company: " . $e->getMessage();
            echo "</div>";
        }
    }
    ?>

    <br><button onclick="window.location.href='conference.php'">Home</button>
</body>
</html>