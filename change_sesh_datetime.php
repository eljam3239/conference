<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Change Session Details</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { margin: 20px 0; padding: 20px; border: 1px solid #ddd; border-radius: 5px; max-width: 500px; }
        label { display: inline-block; width: 150px; margin-bottom: 10px; }
        input, select { padding: 8px; margin-bottom: 15px; width: 200px; }
        input[type="submit"], button { 
            background-color: #4CAF50; color: white; padding: 10px 15px; 
            border: none; border-radius: 4px; cursor: pointer; margin-right: 10px;
        }
        button { background-color:#45a049; }
        button:hover {
            background-color: #45a049;
        }
        .error { color: red; }
        .success { color: green; }
        .session-info { margin: 20px 0; padding: 15px; background-color: #f9f9f9; border-radius: 5px; }
    </style>
</head>
<body>
    <h2>Change Session Date/Time/Location</h2>
    
    <form method="get">
        <label for="speakerID">Select Speaker ID:</label>
        <select name="speakerID" id="speakerID" required>
            <option value="">-- Select Speaker --</option>
            <?php
            $stmt = $pdo->query("SELECT DISTINCT speakerID FROM sesh ORDER BY speakerID");
            while ($speaker = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$speaker['speakerID']}'>{$speaker['speakerID']}</option>";
            }
            ?>
        </select><br>
        <input type="submit" value="Find Session">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['speakerID'])) {
        $speakerID = $_GET['speakerID'];
        
        try {
            // Get current session details
            $stmt = $pdo->prepare("SELECT * FROM sesh WHERE speakerID = ?");
            $stmt->execute([$speakerID]);
            $session = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($session) {
                echo "<div class='session-info'>";
                echo "<h3>Current Session Details</h3>";
                echo "<p><strong>Speaker ID:</strong> {$session['speakerID']}</p>";
                echo "<p><strong>Date:</strong> {$session['seshdate']}</p>";
                echo "<p><strong>Location:</strong> {$session['location']}</p>";
                echo "<p><strong>Start Time:</strong> {$session['starttime']}</p>";
                echo "<p><strong>End Time:</strong> {$session['endtime']}</p>";
                echo "</div>";
                
                // Display update form
                echo "<form method='post'>";
                echo "<input type='hidden' name='speakerID' value='$speakerID'>";
                
                echo "<label for='seshdate'>New Date:</label>";
                echo "<input type='date' name='seshdate' id='seshdate' value='{$session['seshdate']}' required><br>";
                
                echo "<label for='location'>New Location:</label>";
                echo "<input type='text' name='location' id='location' value='{$session['location']}' required><br>";
                
                echo "<label for='starttime'>New Start Time:</label>";
                echo "<input type='time' name='starttime' id='starttime' value='{$session['starttime']}' step='1' required><br>";
                
                echo "<label for='endtime'>New End Time:</label>";
                echo "<input type='time' name='endtime' id='endtime' value='{$session['endtime']}' step='1' required><br>";
                
                echo "<input type='submit' name='update' value='Update Session'>";
                echo "</form>";
            } else {
                echo "<p class='error'>No session found for Speaker ID: $speakerID</p>";
            }
        } catch (PDOException $e) {
            echo "<p class='error'>Error retrieving session: " . $e->getMessage() . "</p>";
        }
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
        $speakerID = $_POST['speakerID'];
        $seshdate = $_POST['seshdate'];
        $location = $_POST['location'];
        $starttime = $_POST['starttime'];
        $endtime = $_POST['endtime'];
        
        // Validate time format (hh:mm:ss)
        if (!preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/', $starttime) || 
            !preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/', $endtime)) {
            echo "<p class='error'>Error: Time must be in hh:mm:ss format (e.g., 09:30:00)</p>";
        } 
        // Validate date format (yyyy-mm-dd)
        elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $seshdate)) {
            echo "<p class='error'>Error: Date must be in yyyy-mm-dd format</p>";
        } 
        // Validate end time is after start time
        elseif (strtotime($endtime) <= strtotime($starttime)) {
            echo "<p class='error'>Error: End time must be after start time</p>";
        } else {
            try {
                $stmt = $pdo->prepare("UPDATE sesh SET seshdate = ?, location = ?, starttime = ?, endtime = ? WHERE speakerID = ?");
                $stmt->execute([$seshdate, $location, $starttime, $endtime, $speakerID]);
                
                if ($stmt->rowCount() > 0) {
                    echo "<p class='success'>Session updated successfully!</p>";
                    echo "<p><strong>Updated Details:</strong></p>";
                    echo "<p>Date: $seshdate</p>";
                    echo "<p>Location: $location</p>";
                    echo "<p>Start Time: $starttime</p>";
                    echo "<p>End Time: $endtime</p>";
                } else {
                    echo "<p class='error'>No changes made or session not found.</p>";
                }
            } catch (PDOException $e) {
                echo "<p class='error'>Error updating session: " . $e->getMessage() . "</p>";
            }
        }
    }
    ?>
    
    <br><button onclick="window.location.href='conference.php'">Home</button>
</body>
</html>