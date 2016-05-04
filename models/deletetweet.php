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

	$id = $_GET['id'];
	//echo $id;

	$sql = "DELETE from twitterlist WHERE id='" .$id. "' ";
		
	if($conn->query($sql))
  	{
		echo "yes";
  	}
  	else 
  		echo "no";

	mysqli_close($conn);
?>