<?php
session_start();
require '../database/db_connection.php';

$username = $_GET["uname"];

$sql = "SELECT username FROM users WHERE username='" . $username . "'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
	echo "yes";
}
else {
	echo "no";
}
?>