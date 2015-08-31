<?php
$mysql_hostname = "localhost";
$mysql_user = "root";
$mysql_password = "";
$mysql_database = "support";

$db = mysqli_connect($mysql_hostname, $mysql_user, $mysql_password,$mysql_database);// or die ("Opps some thing went wrong");
if (mysqli_connect_errno())
  {
  die ("Failed to connect to MySQL: " . mysqli_connect_error());
  }
?>