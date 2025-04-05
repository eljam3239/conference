<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Conference Attendee</title>
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
            margin-top: 20px;
        }
        form {
            margin: 15px 0;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 5px;
            max-width: 500px;
        }
        label {
            display: inline-block;
            width: 200px;
            margin: 8px 0;
        }
        input[type="text"],
        input[type="number"],
        input[type="email"],
        select {
            padding: 8px;
            width: 250px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        input[type="radio"] {
            margin-right: 10px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
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
        .error { 
            color: #d9534f;
            padding: 10px;
            background: #f2dede;
            border-radius: 4px;
            margin: 10px 0;
        }
        .success { 
            color: #3c763d;
            padding: 10px;
            background: #dff0d8;
            border-radius: 4px;
            margin: 10px 0;
        }
        .radio-group {
            margin: 15px 0;
        }
    </style>
    <script>
    function showForm(type) {
        document.getElementById("studentForm").style.display = (type === "student") ? "block" : "none";
        document.getElementById("professionalForm").style.display = (type === "professional") ? "block" : "none";
        document.getElementById("sponsorForm").style.display = (type === "sponsor") ? "block" : "none";
    }
    </script>
</head>
<body>
    <h2>Add a New Conference Attendee</h2>

    <div class="radio-group">
        <label>Select attendee type:</label><br>
        <input type="radio" name="type" value="student" onclick="showForm('student')"> Student<br>
        <input type="radio" name="type" value="professional" onclick="showForm('professional')"> Professional<br>
        <input type="radio" name="type" value="sponsor" onclick="showForm('sponsor')"> Sponsor<br>
    </div>

    <!-- STUDENT FORM -->
    <div id="studentForm" style="display:none;">
        <h3>Student Information</h3>
        <form method="post">
            <input type="hidden" name="attendee_type" value="student">
            <label for="student_id">ID:</label>
            <input type="number" name="id" id="student_id" min="1" required><br>
            
            <label for="student_fname">First Name:</label>
            <input type="text" name="firtname" id="student_fname" required><br>
            
            <label for="student_lname">Last Name:</label>
            <input type="text" name="lastname" id="student_lname" required><br>
            
            <label for="student_email">Email:</label>
            <input type="email" name="email" id="student_email" required><br>
            
            <label for="student_rate">Registration Rate:</label>
            <input type="number" name="rate" id="student_rate" step="0.01" required><br>
            
            <label for="student_room">Hotel Room:</label>
            <select name="hotelroomnumber" id="student_room" required>
                <option value="">-- Select Room --</option>
                <?php
                $stmt = $pdo->query("SELECT roomnum FROM hotelroom ORDER BY roomnum");
                while ($room = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='{$room['roomnum']}'>{$room['roomnum']}</option>";
                }
                ?>
            </select><br><br>
            
            <input type="submit" value="Add Student">
        </form>
    </div>

    <!-- PROFESSIONAL FORM -->
    <div id="professionalForm" style="display:none;">
        <h3>Professional Information</h3>
        <form method="post">
            <input type="hidden" name="attendee_type" value="professional">
            <label for="prof_id">ID:</label>
            <input type="number" name="id" id="prof_id" min="1" required><br>
            
            <label for="prof_fname">First Name:</label>
            <input type="text" name="firtname" id="prof_fname" required><br>
            
            <label for="prof_lname">Last Name:</label>
            <input type="text" name="lastname" id="prof_lname" required><br>
            
            <label for="prof_email">Email:</label>
            <input type="email" name="email" id="prof_email" required><br>
            
            <label for="prof_rate">Registration Rate:</label>
            <input type="number" name="rate" id="prof_rate" step="0.01" required><br><br>
            
            <input type="submit" value="Add Professional">
        </form>
    </div>

    <!-- SPONSOR FORM -->
    <div id="sponsorForm" style="display:none;">
        <h3>Sponsor Attendee Information</h3>
        <form method="post">
            <input type="hidden" name="attendee_type" value="sponsor">
            <label for="sponsor_id">ID:</label>
            <input type="number" name="id" id="sponsor_id" min="1" required><br>
            
            <label for="sponsor_fname">First Name:</label>
            <input type="text" name="firtname" id="sponsor_fname" required><br>
            
            <label for="sponsor_lname">Last Name:</label>
            <input type="text" name="lastname" id="sponsor_lname" required><br>
            
            <label for="sponsor_email">Email:</label>
            <input type="email" name="email" id="sponsor_email" required><br>
            
            <label for="sponsor_rate">Registration Rate:</label>
            <input type="number" name="rate" id="sponsor_rate" step="0.01" required><br>
            
            <label for="sponsor_company">Company Name:</label>
            <input type="text" name="companyname" id="sponsor_company" required><br><br>
            
            <input type="submit" value="Add Sponsor Attendee">
        </form>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['attendee_type'])) {
        $type = $_POST['attendee_type'];
        $id = $_POST['id'];
        $firtname = $_POST['firtname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $rate = $_POST['rate'];

        try {
            // Check if ID exists in any relevant table
            $stmt = $pdo->prepare("
                SELECT 'student' AS table_name FROM student WHERE id = ?
                UNION ALL
                SELECT 'professional' FROM professional WHERE id = ?
                UNION ALL
                SELECT 'sponsorattendee' FROM sponsorattendee WHERE id = ?
                UNION ALL
                SELECT 'member' FROM member WHERE id = ?
                UNION ALL
                SELECT 'speaker' FROM speaker WHERE id = ?
                LIMIT 1
            ");
            $stmt->execute([$id, $id, $id, $id, $id]);
            $existing = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existing) {
                echo "<p class='error'>Error: ID $id already exists in the {$existing['table_name']} table.</p>";
            } else {
                // Proceed with insertion if ID doesn't exist
                if ($type === 'student') {
                    $hotelroomnumber = $_POST['hotelroomnumber'];
                    $stmt = $pdo->prepare("INSERT INTO student (id, firtname, lastname, email, rate, hotelroomnumber) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$id, $firtname, $lastname, $email, $rate, $hotelroomnumber]);
                    echo "<p class='success'>Student attendee added successfully! ID: $id</p>";
                } elseif ($type === 'professional') {
                    $stmt = $pdo->prepare("INSERT INTO professional (id, firtname, lastname, email, rate) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$id, $firtname, $lastname, $email, $rate]);
                    echo "<p class='success'>Professional attendee added successfully! ID: $id</p>";
                } elseif ($type === 'sponsor') {
                    $companyname = $_POST['companyname'];
                    $stmt = $pdo->prepare("INSERT INTO sponsorattendee (id, firtname, lastname, email, rate, companyname) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$id, $firtname, $lastname, $email, $rate, $companyname]);
                    echo "<p class='success'>Sponsor attendee added successfully! ID: $id</p>";
                }
            }
        } catch (PDOException $e) {
            echo "<p class='error'>Error adding attendee: " . $e->getMessage() . "</p>";
        }
    }
    ?>

    <br><button onclick="window.location.href='conference.php'">Home</button>
</body>
</html>