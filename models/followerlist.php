<?php
session_start();

if(!isset($_SESSION['user_session']))
{
	$newURL = "../index.php";
 	header('Location: '.$newURL);
}

require '../database/db_connection.php';

	
	$name = $_GET["username"];

	$sql = 'SELECT username from followerlist  where  followname = "' .$name. '" ';

	$result = mysqli_query($conn, $sql);
	    
	$emparray = array();
	if (mysqli_num_rows($result) > 0) {
	    while($row = mysqli_fetch_assoc($result)) {
	    	$emparray[] = $row;
	    }
	}

	echo json_encode($emparray);
	
	mysqli_close($conn);

?>