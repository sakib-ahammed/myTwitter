<?php
session_start();

if(!isset($_SESSION['user_session']))
{
	$newURL = "../index.php";
 	header('Location: '.$newURL);
}

require '../database/db_connection.php';


	$name = $_SESSION['user_session'];
	$text = trim($_POST['tweet']);
	$tweetnow = nl2br($text);
	$tweetnow =	mysqli_real_escape_string($conn, $tweetnow);
	if($tweetnow){
	  	$sql = "INSERT INTO twitterlist (username, tweet) VALUES ('".$name."', '".$tweetnow."')";
	  	if($conn->query($sql))
	  	{
	  		$newURL = "../view/usertweet.php?type=0&&username=".$name;
			header('Location: '.$newURL);
			//echo "hello";
	  	}
	  	else{
	  		$newURL = "../view/home.php";
			header('Location: '.$newURL);
	  }
	  }
	  else{
	  		$newURL = "../view/home.php";
			header('Location: '.$newURL);
	  }

	mysqli_close($conn);

?>