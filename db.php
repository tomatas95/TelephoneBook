<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "phonebook";
$port = 8111;

$conn = mysqli_connect($servername, $username, $password,$database,$port);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$conn->select_db($database);

return $conn;