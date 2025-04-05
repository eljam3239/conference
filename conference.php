<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Conference Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            line-height: 1.6;
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }
        .banner {
            text-align: center;
            margin: 20px 0;
        }
        .banner img {
            max-width: 100%;
            height: auto;
        }
        .menu-list {
            list-style-type: none;
            padding: 0;
            margin: 30px 0;
        }
        .menu-list li {
            margin: 10px 0;
        }
        .menu-list a {
            display: block;
            padding: 10px 15px;
            background-color: #f5f5f5;
            color: #333;
            text-decoration: none;
            border-left: 4px solid #4CAF50;
            transition: all 0.3s ease;
        }
        .menu-list a:hover {
            background-color: #e9e9e9;
            border-left-color: #45a049;
            padding-left: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            color: #777;
            font-size: 0.9em;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Welcome to the Conference Organizer Infodesk</h1>
    
    <div class="banner">
        <img src="cat.jpg" alt="Conference Banner">
    </div>
    
    <ul class="menu-list">
        <li><a href="subcommittee_members.php">View Sub-Committee Members</a></li>
        <li><a href="students_in_rooms.php">View Students in Rooms</a></li>
        <li><a href="conference_schedule.php">View Conference Schedule</a></li>
        <li><a href="view_sponsorship_level.php">View Sponsorship Levels</a></li>
        <li><a href="job_listings.php">View Job Listings</a></li>
        <li><a href="conference_attendees.php">View Conference Attendees</a></li>
        <li><a href="new_attendee.php">Add New Attendee</a></li>
        <li><a href="conference_breakdown.php">View Conference Breakdown</a></li>
        <li><a href="add_sponsor.php">Add New Sponsor</a></li>
        <li><a href="delete_sponsor.php">Delete Sponsor</a></li>
        <li><a href="change_sesh_datetime.php">Change Session Date/Time</a></li>
    </ul>
    
    <div class="footer">
        Eli James
    </div>
</body>
</html>