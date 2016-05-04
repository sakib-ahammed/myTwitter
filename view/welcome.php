
<?php
session_start();

if(!isset($_SESSION['user_session']))
{
	$newURL = "../index.php";
 	header('Location: '.$newURL);
}

require '../database/db_connection.php';

?>


<!DOCTYPE html>
<title>HTML Tutorial</title>
<body>
<p>U r successfully Logged In</p>
<form name="loginform" action="../models/logout.php" method="post">
	<input type="submit" value="logout" name="btn-logout" id="btn-logout">
</form>
<?php
//insertIntoUsers($conn);

$session_username = $_SESSION['user_session'];
$flag = 1;

$sql = "SELECT T.id as id, U.name as name, T.username as username, T.tweet as tweet, T.modified as modified FROM twitterlist T, users U where U.username=T.username order by T.modified DESC";
//$sql = " SELECT U.name as name, T.username as username, T.tweet as tweet, T.modified as modified from (SELECT username, tweet, modified FROM twitterlist order by modified DESC) as T, users as U where U.username=T.username";
$result = mysqli_query($conn, $sql);
?>

<table>
 
<?php
$count = 0;
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {

    if($row["username"] == $session_username AND $flag){
    	$newest_tweet = $row["tweet"];
    	$newest_tweet_time = $row["modified"];
    	$flag = 0;
    }
    else{
?>
 <tr>
    <td>
    <p id="aaahref"> hello </p>
     <a id="ahref" href="tweet.php?name=<?php   echo  $row["username"]; ?>" style="text-decoration:none;" ><?php   echo $row["name"]." @".$row["username"]; ?> </a>
      <?php   echo "<pre>" .$row["tweet"]."</pre>" ; ?>
     <?php   echo $row["modified"]; ?>
     <?php if($row["username"] == $session_username) {?> <input type="submit" name="submit" value="Delete"><?php }?>
     </td>
 </tr>
<?php
		}
    }
} 
mysqli_close($conn);
?>
</table>

<?php echo $newest_tweet; ?>
<script type="text/javascript">
	document.getElementById("ahref").innerHTML = "Changed";
	console.log("Changed");
</script>
</body>
</html>