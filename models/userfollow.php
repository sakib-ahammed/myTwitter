<?php
session_start();

if(!isset($_SESSION['user_session']))
{
	$newURL = "../index.php";
 	header('Location: '.$newURL);
}

require '../database/db_connection.php';
?>

<?php

	$username = $_SESSION['user_session'];
	$followname = $_GET["followname"];

	$sql = "INSERT INTO followerlist (username, followname) VALUES ('".$username."', '".$followname."')";
  	if($conn->query($sql))
  	{
		echo "hello";
  	}

	mysqli_close($conn);
?>