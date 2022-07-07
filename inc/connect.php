<?php
$servername = "localhost";
$username = "root";
$password = "abc123";
$dbname = "student_b031910365";

/*
$servername = "localhost";
$username = "b031910365";
$password = "6868";
$dbname = "student_b031910365";
*/

//Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

 // Check connection 
if ($conn->connect_error) { 
    die("Connection failed: " . $conn->connect_error);
} 

//echo "Connected successfully<br>"; 
?>
