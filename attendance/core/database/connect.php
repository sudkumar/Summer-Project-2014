<?php
	
$host="localhost"; // Host name
$username="root"; // Mysql username
$password="name"; // Mysql password
$db_name="attendance"; // Database name

$connection_error = "Sorry, we\'re expering connection problems."; 

// Connect to server and select databse.
mysql_connect($host, $username, $password)or die($connection_error);
mysql_select_db($db_name)or die($connection_error);

?>