<?php
$sname= "localhost";
$unmae= "schooluser";
$password= "Jaideepsingh13";
$db_name ="database1";
$conn = mysqli_connect($sname, $unmae, $password, $db_name);
if (!$conn) {
echo "Connection failed!";
}