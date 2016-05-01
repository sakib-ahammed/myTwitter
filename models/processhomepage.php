<?php
session_start();

if(!isset($_SESSION['user_session']))
{
	$newURL = "../index.php";
 	header('Location: '.$newURL);
}

require '../database/db_connection.php';

	$username = $_SESSION['user_session'];

		$sql = "SELECT * from twitterlist WHERE username='" .$username. "'  OR username IN( SELECT followname from followerlist WHERE username='" .$username. "' ) ORDER BY modified DESC";
		
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