<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Conference Attendee</title>
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

    <form>
        <label>Select attendee type:</label><br>
        <input type="radio" name="type" value="student" onclick="showForm('student')"> Student<br>
        <input type="radio" name="type" value="professional" onclick="showForm('professional')"> Professional<br>
        <input type="radio" name="type" value="sponsor" onclick="showForm('sponsor')"> Sponsor<br>
    </form>

    <!-- STUDENT FORM -->
    <div id="studentForm" style="display:none;">
        <h3>Student Information</h3>
        <form method="post">
            <input type="hidden" name="attendee_type" value="student">
            First Name: <input type="text" name="firtname" required><br>
            Last Name: <input type="text" name="lastname" required><br>
            Email: <input type="email" name="email" required><br>
            Registration Rate: <input type="number" name="rate" step="0.01" required><br>
            Hotel Room:
            <select name="hotelroomnumber" required>
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
            First Name: <input type="text" name="firtname" required><br>
            Last Name: <input type="text" name="lastname" required><br>
            Email: <input type="email" name="email" required><br>
            Registration Rate: <input type="number" name="rate" step="0.01" required><br><br>
            <input type="submit" value="Add Professional">
        </form>
    </div>

    <!-- SPONSOR FORM -->
    <div id="sponsorForm" style="display:none;">
        <h3>Sponsor Attendee Information</h3>
        <form method="post">
            <input type="hidden" name="attendee_type" value="sponsor">
            First Name: <input type="text" name="firtname" required><br>
            Last Name: <input type="text" name="lastname" required><br>
            Email: <input type="email" name="email" required><br>
            Registration Rate: <input type="number" name="rate" step="0.01" required><br>
            Company Name: <input type="text" name="companyname" required><br><br>
            <input type="submit" value="Add Sponsor Attendee">
        </form>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['attendee_type'])) {
        $type = $_POST['attendee_type'];
        $firtname = $_POST['firtname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $rate = $_POST['rate'];

        if ($type === 'student') {
            $hotelroomnumber = $_POST['hotelroomnumber'];
            $stmt = $pdo->prepare("INSERT INTO student (firtname, lastname, email, rate, hotelroomnumber) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$firtname, $lastname, $email, $rate, $hotelroomnumber]);
            echo "<p>Student attendee added successfully!</p>";
        } elseif ($type === 'professional') {
            $stmt = $pdo->prepare("INSERT INTO professional (firtname, lastname, email, rate) VALUES (?, ?, ?, ?)");
            $stmt->execute([$firtname, $lastname, $email, $rate]);
            echo "<p>Professional attendee added successfully!</p>";
        } elseif ($type === 'sponsor') {
            $companyname = $_POST['companyname'];
            $stmt = $pdo->prepare("INSERT INTO sponsorattendee (firtname, lastname, email, rate, companyname) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$firtname, $lastname, $email, $rate, $companyname]);
            echo "<p>Sponsor attendee added successfully!</p>";
        }
    }
    ?>

    <br><button onclick="window.location.href='conference.php'">Home</button>
</body>
</html>
