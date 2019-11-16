<?php 
$servername = "localhost";
$username =  "root";
$password = "";
$DBname = "stavet";
// create connection
$conn = mysqli_connect($servername, $username, $password, $DBname);
//check connection
if (!$conn) {
	die("connection failed: " . mysqli_connect_error());
}

 ?>