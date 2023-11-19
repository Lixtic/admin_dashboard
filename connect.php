<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "yeafahcare";
// Create connection
$conn = mysqli_connect('localhost','root','','yeafahcare');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
else
{
/*echo "Connected";*/
}
?>