<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Job Listings</title>
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
            echo "<table border='1'>";
            echo "<tr><th>Title</th><th>Pay Rate</th><th>Province</th><th>City</th><th>Company</th></tr>";
            foreach ($jobs as $job) {
                echo "<tr>
                        <td>{$job['title']}</td>
                        <td>{$job['payrate']}</td>
                        <td>{$job['province']}</td>
                        <td>{$job['city']}</td>
                        <td>{$job['companyname']}</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No jobs found for the selected option.</p>";
        }
    }
    ?>

    <button onclick="window.location.href='conference.php'">Home</button>
</body>
</html>
