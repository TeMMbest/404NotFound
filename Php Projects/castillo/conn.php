<?php
$servername = "localhost";
$username = "root";
$pass = "";
$conn = new mysqli($servername, $username, $pass,);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

