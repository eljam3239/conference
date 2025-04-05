<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Sub-Committee Members</title>
</head>
<body>
    <h2>Select a Sub-Committee</h2>
    <form method="post">
        <label for="subcommittee">Choose:</label>
        <select name="subcommittee_id" id="subcommittee" required>
            <option value="">-- Select --</option>
            <?php
            $stmt = $pdo->query("SELECT DISTINCT name FROM SubCommittee ORDER BY name");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['name']}'>{$row['name']}</option>";
            }
            ?>
        </select>
        <input type="submit" value="Show Members">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['subcommittee_id'])) {
        $subcommittee_name = $_POST['subcommittee_id'];

        // Adjusted query to retrieve members based on subcommittee name
        $query = "SELECT m.firstname, m.lastname 
                  FROM Member m
                  JOIN subcommittee sc ON m.id = sc.memberID
                  WHERE sc.name = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$subcommittee_name]);

        $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($members) > 0) {
            echo "<h3>Members of '$subcommittee_name':</h3>";
            echo "<table border='1'>";
            echo "<tr><th>First Name</th><th>Last Name</th></tr>";
            foreach ($members as $member) {
                echo "<tr><td>{$member['firstname']}</td><td>{$member['lastname']}</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No members found for this sub-committee.</p>";
        }
    }
    ?>
    <h2>Note: subcommittees only have 1 member in my initial schema submission.</h2>
    <button onclick="window.location.href='conference.php'">Home</button>
</body>
</html>
