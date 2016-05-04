<?php
 session_start();
 unset($_SESSION['user_session']);
 
 if(session_destroy())
 {
	 $newURL = "../index.php";
 	 header('Location: '.$newURL);
 }
?>