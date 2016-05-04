<?php
session_start();
require '../database/db_connection.php';

	$name = $_POST["name"];
	$username = $_POST["username"];
	$email = $_POST["email"];
	$password = $_POST["password"];
	$privatetweet = 0;
	if (!empty($_POST["checkbox"])) {
		$privatetweet = $_POST["checkbox"];
	}

	$sql = "INSERT INTO users (`name`, `username`, `password`, `email`, `privatetweet`) VALUES('" .$name. "','" .$username. "','" .$password. "','" .$email. "',".$privatetweet.")";

	if ($conn->query($sql) === TRUE) {
	    //echo "New record created successfully";
	    $newURL = "../view/regconfirmation.php?username=".$username;
		header('Location: '.$newURL);
	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}
//}

?>