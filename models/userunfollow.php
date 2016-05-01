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

	$sql = "DELETE from followerlist WHERE username='" .$username. "' AND followname='" .$followname. "' ";
	
  	if($conn->query($sql))
  	{
		echo "yes";
  	}
  	else 
  		echo "no";

	mysqli_close($conn);
?>