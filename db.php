<?php
// db.php - ONLY for database connection (no HTML, no echo, no redirect)

$server = "localhost";
$userdb = "root";
$password = "";
$database = "Note";
    
$conn = mysqli_connect($server, $userdb, $password, $database);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

?>
