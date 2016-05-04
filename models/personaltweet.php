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
	
	$type = $_GET['type'];
	$name = $_GET['username'];
	$session_user = $_SESSION['user_session'];

	$emparray = array();

	switch ($type) {
    case 0:
        $sql0 ="SELECT T.id as id, U.name as name, T.username as username, T.tweet as tweet, T.modified as modified FROM twitterlist T, users U where T.username='" . $name . "' AND U.username=T.username order by T.modified DESC";

		$result0 = mysqli_query($conn, $sql0);
		if (mysqli_num_rows($result0) > 0) {
		    while($row = mysqli_fetch_assoc($result0)) {
		    	$emparray[] = $row;
		    }
		}
        break;
    case 1:
        $sql1 =" SELECT T.id as id, U.name as name, T.username as username, T.tweet as tweet, T.modified as modified FROM twitterlist T, users U where T.id IN (SELECT max(id) from twitterlist where username IN (SELECT followname from followerlist where username='" . $name . "') GROUP BY username) AND U.username=T.username";

		$result1 = mysqli_query($conn, $sql1);
		if (mysqli_num_rows($result1) > 0) {
		    while($row = mysqli_fetch_assoc($result1)) {
		    	$emparray[] = $row;
		    }
		}
        break;
    case 2:
        $sql2 =" SELECT T.id as id, U.name as name, T.username as username, T.tweet as tweet, T.modified as modified FROM twitterlist T, users U where T.id IN (SELECT max(id) from twitterlist where username IN (SELECT username from followerlist where followname='" . $name . "') GROUP BY username) AND U.username=T.username";

		$result2 = mysqli_query($conn, $sql2);
		if (mysqli_num_rows($result2) > 0) {
		    while($row = mysqli_fetch_assoc($result2)) {
		    	$emparray[] = $row;
		    }
		}
        break;
	}


	echo json_encode($emparray);	
	
	mysqli_close($conn);
?>