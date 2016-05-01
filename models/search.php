<?php
session_start();

if(!isset($_SESSION['user_session']))
{
	$newURL = "../index.php";
 	header('Location: '.$newURL);
}

require '../database/db_connection.php';


	$name = $_GET["str"];
	$username = $_SESSION['user_session'];
      
      // query for search

    $sql = 'SELECT U.id as id, U.username as username, U.name as name, T.tweet as tweet, T.modified as time from twitterlist T, (SELECT id, username, name, created from users where upper(username) like upper("%'.$name.'%") OR upper(name) like upper("%'.$name.'%") ) U where U.username=T.username AND U.username != "'.$username.'" AND T.id IN ( SELECT max(id) from twitterlist GROUP BY username) order by U.created DESC';
      
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