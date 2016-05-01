<?php
session_start();

if(!isset($_SESSION['user_session']))
{
	$newURL = "../index.php";
 	header('Location: '.$newURL);
}

require '../database/db_connection.php';

	$username = $_SESSION['user_session'];
      
      // query for search

    $sql = 'SELECT username, name from users';
      
    $sql2 = 'SELECT followname from followerlist  where  username = "' .$username. '" ';
    
    $result = mysqli_query($conn, $sql);
	    
	$emparray = array();
	if (mysqli_num_rows($result) > 0) {
	    while($row = mysqli_fetch_assoc($result)) {
	    	$emparray[] = $row;
	    }
	}
	

	if(sizeof($emparray) > 0){
		$result2 = mysqli_query($conn, $sql2);
		$emparray2 = array();
		if (mysqli_num_rows($result2) > 0) {
		    while($row = mysqli_fetch_assoc($result2)) {
		    	$emparray2[] = $row;
		    }
		}
		$emparray[] = $emparray2;
		echo json_encode($emparray);
	}
	else echo "sorry";
		
 
    mysqli_close($conn);
?>