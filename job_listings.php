<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Job Listings</title>
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
            max-width: 600px;
        }
        label {
            display: inline-block;
            width: 120px;
            margin-right: 10px;
        }
        select {
            padding: 8px;
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        table {
            border-collapse: collapse;
            width: 100%;
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
        .no-jobs {
            color: #666;
            font-style: italic;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <h2>View Job Postings</h2>

    <form method="post">
        <label for="company">Select Company:</label>
        <select name="company" id="company" required>
            <option value="all">-- Show All Jobs --</option>
            <?php
            $stmt = $pdo->query("SELECT DISTINCT companyname FROM jobads ORDER BY companyname");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $name = htmlspecialchars($row['companyname']);
                echo "<option value=\"$name\">$name</option>";
            }
            ?>
        </select>
        <input type="submit" value="View Jobs">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['company'])) {
        $selectedCompany = $_POST['company'];

        if ($selectedCompany === "all") {
            $query = "SELECT title, payrate, province, city, companyname FROM jobads ORDER BY companyname, title";
            $stmt = $pdo->query($query);
        } else {
            $query = "SELECT title, payrate, province, city, companyname FROM jobads WHERE companyname = ? ORDER BY title";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$selectedCompany]);
        }

        $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($jobs) > 0) {
            $heading = $selectedCompany === "all" ? "All Job Listings" : "Jobs at " . htmlspecialchars($selectedCompany);
            echo "<h3>$heading</h3>";
            echo "<table>";
            echo "<tr><th>Title</th><th>Pay Rate</th><th>Province</th><th>City</th><th>Company</th></tr>";
            foreach ($jobs as $job) {
                echo "<tr>
                        <td>{$job['title']}</td>
                        <td>\${$job['payrate']}</td>
                        <td>{$job['province']}</td>
                        <td>{$job['city']}</td>
                        <td>{$job['companyname']}</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='no-jobs'>No jobs found for the selected option.</p>";
        }
    }
    ?>

    <button onclick="window.location.href='conference.php'">Home</button>
</body>
</html>