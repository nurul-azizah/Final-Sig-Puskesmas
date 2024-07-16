<?php
$servername = "localhost";
$username = "root";
$password = ""; // Assuming no password for root user on XAMPP
$dbname = "final_sig";

// Create connection
$konek = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($konek->connect_error) {
    die("Connection failed: " . $konek->connect_error);
}
?>
