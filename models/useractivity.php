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
	$username = $_GET["username"];
    
    $sql = "SELECT count(username) as following from followerlist where username='" . $username . "' ";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
    		//echo "Following " . $row["following"]. "<br>";
    		$ff = $row["following"];
        } 
    }

    $sql = "SELECT count(followname) as follower from followerlist where followname='" . $username . "' ";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
    		//echo " Follower: " . $row["follower"] . "<br>";
    		$fr = $row["follower"];
        } 
    }

    $sql = "SELECT count(username) as tweet from twitterlist where username ='" . $username . "' ";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
    		//echo " Number of Contribution: " . $row["tweet"] . "<br>";
    		$tt = $row["tweet"];
        } 
    }

    echo $ff." ".$fr." ".$tt;

    mysqli_close($conn);

?>