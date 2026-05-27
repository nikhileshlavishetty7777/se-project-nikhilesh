<?php
$host = 'localhost';
$user = 'root';
$password = 'Nikhilesh0710'; // or your actual password
$database = 'new-food-order';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>