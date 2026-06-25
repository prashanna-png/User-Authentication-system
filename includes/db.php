<?php
$servername = 'localhost';
$username = 'root';
$password = 'prashan@2005';
$database = 'userauthentication';

$conn = mysqli_connect($servername,$username,$password,$database);

if(!$conn){
  die("Connection failed: " . mysqli_connect_error());
}
echo("successfully connected");
?>