<?php

$host = 'localhost';
$dbname = 'conferencedb'; 
$user = 'root';         
         
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, '');
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
