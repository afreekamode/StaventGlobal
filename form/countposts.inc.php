<?php
$sql ="SELECT * FROM posts WHERE category = 'tech'";
$result=mysqli_query($conn, $sql);
$counttech=mysqli_num_rows($result);

$sql ="SELECT * FROM posts WHERE category = 'inovation'";
$result=mysqli_query($conn, $sql);
$countinovation=mysqli_num_rows($result);

$sql ="SELECT * FROM posts WHERE category = 'idea'";
$result=mysqli_query($conn, $sql);
$countidea=mysqli_num_rows($result);


$sql ="SELECT * FROM posts WHERE category = 'general'";
$result=mysqli_query($conn, $sql);
$countgeneral=mysqli_num_rows($result);

$sql ="SELECT * FROM posts WHERE category = 'entertainment'";
$result=mysqli_query($conn, $sql);
$countentertainment=mysqli_num_rows($result);

?>