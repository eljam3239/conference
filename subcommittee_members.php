<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Sub-Committee Members</title>
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
        form {
            margin: 20px 0;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 5px;
            max-width: 500px;
        }
        label {
            display: inline-block;
            width: 150px;
            margin-right: 10px;
        }
        select {
            padding: 8px;
            width: 250px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-right: 10px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
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
        .note {
            color: #666;
            font-style: italic;
            margin: 20px 0;
            padding: 10px;
            background-color: #f5f5f5;
            border-left: 4px solid #ccc;
        }
        .no-members {
            color: #666;
            font-style: italic;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <h2>Select a Sub-Committee</h2>
    <form method="post">
        <label for="subcommittee">Sub-Committee:</label>
        <select name="subcommittee_id" id="subcommittee" required>
            <option value="">-- Select Sub-Committee --</option>
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

        $query = "SELECT m.firstname, m.lastname 
                  FROM Member m
                  JOIN subcommittee sc ON m.id = sc.memberID
                  WHERE sc.name = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$subcommittee_name]);

        $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($members) > 0) {
            echo "<h3>Members of '{$subcommittee_name}':</h3>";
            echo "<table>";
            echo "<tr><th>First Name</th><th>Last Name</th></tr>";
            foreach ($members as $member) {
                echo "<tr>
                        <td>{$member['firstname']}</td>
                        <td>{$member['lastname']}</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='no-members'>No members found for this sub-committee.</p>";
        }
    }
    ?>
    
    <div class="note">
        Note: Subcommittees only have 1 member in the initial schema submission.
    </div>
    
    <button onclick="window.location.href='conference.php'">Home</button>
</body>
</html>