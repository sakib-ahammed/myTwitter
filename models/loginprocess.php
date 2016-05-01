<?php
session_start();
require '../database/db_connection.php';

$username = $_GET["uname"];
$password = $_GET["pass"];

$sql = "SELECT id, username, password FROM users WHERE username='" . $username . "' AND password='" . $password ."' ";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
	echo "yes";
	$_SESSION['user_session'] = $username;
}
else {
	echo "no";
}
?>