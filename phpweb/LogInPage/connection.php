<?php 

$servername = "localhost";
$username = "robi";
$password = "robi";
$database = "mox";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}