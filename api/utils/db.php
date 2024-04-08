<?php
	$server= "localhost";
	$username ="root";
	$password="";
	$dbname ="u937955131_westoredb";

	global $conn;
	$conn = new mysqli($server, $username, $password, $dbname);

  	mysqli_set_charset($conn,"utf8");

	if ($conn->connect_error) {
		die("connection failed" . $conn->connect_error );
	}
?>