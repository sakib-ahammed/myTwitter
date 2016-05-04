<?php
session_start();

if(!isset($_SESSION['user_session']))
{
	$newURL = "../index.php";
 	header('Location: '.$newURL);
}

require '../database/db_connection.php';
require_once 'header.php';
$username = $_GET["username"];
$type = $_GET["type"];

?>

<!DOCTYPE html>
<html>
<head>
	<title>myTwitter</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/methods.js"></script>
</head>
<body>
<br>


<!-- tweet data view -->


<div class="container">

	<div class="row">
	  	<div class="col-md-8">
	  		
	  		<h4>
	  		<a href="home.php" id="displayUsername"></a>
	  		<i><span id="follower_following"></span></i>	  		
	  		</h4>

	  	</div>
	</div>

  	<div class="row" id="displaylist" style="display: none;">
	  	<div class="col-md-8" >
			<ul class="list-group">
			  	
			<!-- list view start  -->
			 
			  	<?php for($i = 0; $i < 10; $i++) { ?>
			  		<li class="list-group-item" id="display<?php echo $i; ?>">
	      				<h4>
	      				<a href="" id="username<?php echo $i; ?>"></a>
	      				<span id="name<?php echo $i; ?>"></span>
	      				
	      				<span class="btn pull-right" >
		      				<button class="btn btn-default btn-sm" type="submit" value="" name="btn-delete" id="delete<?php echo $i; ?>" onclick="pressDelete(this.value)"><span class="glyphicon glyphicon-trash"></span>
		      				</button>

		      				<button class="btn btn-default btn-sm" type="submit" value="" name="btn-follow" id="follow<?php echo $i; ?>" onclick="pressFollow(this.value)">Follow</button>

		      				<button class="btn btn-default btn-sm" type="submit" value="" name="btn-unfollow" id="unfollow<?php echo $i; ?>" onclick="pressUnfollow(this.value)" onmouseover="mouseActionInFollowingButton(this.id)"  onmouseout="normalFollowingButton(this.id)">Following</button>

	      				</span>
	      				</h4>
				  		
				  		<p id="tweet<?php echo $i; ?>"></p>
				  		<p id="time<?php echo $i; ?>"></p>
			  		</li>
				<?php } ?>
			</ul>

			<!-- list view end -->

			<!-- back next button  -->

				<button class="btn btn-default" type="submit" value="next" name="btn-next" id="btn-next" style="float: right;" onclick="buttonNext()"> Next</button>
	        	<button class="btn btn-default" type="submit" value="back" name="btn-back" id="btn-back" style="float: right;" onclick="buttonBack()"> Back</button>

	        <!-- back next end  -->
	        	
		</div>

		<!-- user activity division -->

		<div class="col-md-3">
			<ul class="list-group">
			  
			  <div class="text-center" >
				  <li class="list-group-item" >
				  	<h4 id="activityname"></h4>
				  </li>
			  </div>
			  <a href = "" id="following">
				<div class = "list-group-item">
					Following
					<span id="followingnumber" style="float: right;">0</span>
				</div>
			</a>

			<a href = "" id="follower">
				<div class = "list-group-item">
					Follower
					<span id="followernumber" style="float: right;">0</span>
				</div>
			</a>

			<a href = "" id="contribution">
				<div class = "list-group-item">
					Tweets
					<span id="contributionnumber" style="float: right;">0</span>
				</div>
			</a>

			</ul>
		</div>

		<!-- user activity division end -->

	</div>   

</div>

<!-- twitter data end -->


<p style="display: none;" id="type"><?php echo $type; ?></p>
<p style="display: none;" id="user_name"><?php echo $username; ?></p>
<p style="display: none;" id="user_session"><?php echo $_SESSION['user_session']; ?></p>


<script type="text/javascript">
	// document.getElementById("displayName").innerHTML = "Sakib Ahammed";
	// document.getElementById("displayUsername").innerHTML = "@sakib";
	// document.getElementById("follower_following").innerHTML = "is following 28 people";


	var type = document.getElementById("type").innerHTML;
	var user = document.getElementById("user_name").innerHTML;
	var sesssion_user = document.getElementById("user_session").innerHTML;
	var tweetdata;
	var currentPage = 0;
	var followingData;
	
	function processData(){

		displayTweet();
		$("#displaylist").attr("style", "");
		if(currentPage == 0)
			$("#btn-back").attr("style", "display:none;");
		else
			$("#btn-back").attr("style", "float:right;");

		if(currentPage == Math.floor(tweetdata.length/10))
			$("#btn-next").attr("style", "display:none;");
		else
			$("#btn-next").attr("style", "float:right;");

		var start = currentPage*10;
		var end = start+10;
		var i=0;
		for(var j=start; j<end; j++){

			if(j < tweetdata.length)
			{
				$("#display"+i).attr("style", "");

				document.getElementById("username"+i).innerHTML = tweetdata[j].username;
				document.getElementById("name"+i).innerHTML = "@"+tweetdata[j].name;
				document.getElementById("tweet"+i).innerHTML = tweetdata[j].tweet;
				document.getElementById("time"+i).innerHTML = tweetdata[j].modified;
				
				$("#username"+i).attr("href", "usertweet.php?type=0&&username="+tweetdata[j].username);
				$("#delete"+i).attr("value", tweetdata[j].id);
				$("#follow"+i).attr("value", tweetdata[j].username);
				$("#unfollow"+i).attr("value", tweetdata[j].username);
				
				if(sesssion_user == tweetdata[j].username)
					$("#delete"+i).attr("style", "");
				else
					$("#delete"+i).attr("style", "display: none;");

				if (tweetdata[j].username == sesssion_user || parseInt(type) == 0){
					$("#follow"+i).attr("style", "display: none;");
					$("#unfollow"+i).attr("style", "display: none;");
				}
				else if(isFollowing(tweetdata[j].username)){
					$("#follow"+i).attr("style", "display: none;");
					$("#unfollow"+i).attr("style", "color: white; background: #00aced;");		
				}
				else{
					$("#follow"+i).attr("style", "");
					$("#unfollow"+i).attr("style", "display: none;");
				}
			}
			else{
				$("#display"+i).attr("style", "display:none;");
			}
			
			i++;
		}
	}

	function userActivity() {
		$("#contribution").attr("href", "usertweet.php?type=0&&username="+user);
		$("#following").attr("href", "usertweet.php?type=1&&username="+user);
		$("#follower").attr("href", "usertweet.php?type=2&&username="+user);

		xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
		  if (xhttp.readyState == 4 && xhttp.status == 200) {
		    var str = xhttp.responseText;
		    str = str.trim();
		    result = str.split(" ");
		    document.getElementById("activityname").innerHTML = user;
		    document.getElementById("followingnumber").innerHTML = result[0];
			document.getElementById("followernumber").innerHTML = result[1];
			document.getElementById("contributionnumber").innerHTML = result[2];

			document.getElementById("displayUsername").innerHTML = "@"+user;
			$("#displayUsername").attr("href", "usertweet.php?type=0&&username="+user);
			
			if(type==1){
				$("#follower_following").attr("style", "");
				document.getElementById("follower_following").innerHTML = "is following "+ result[0] +" people";
			}
			else if(type==2){
				$("#follower_following").attr("style", "");
				document.getElementById("follower_following").innerHTML = "is followed by "+ result[1] +" people";
			}
			else{
				$("#follower_following").attr("style", "display:none;");
			}

		  }
		}
		xhttp.open("GET", "../models/useractivity.php?username="+user, false);
		xhttp.send();
	}

	function getData() {
		xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
		  if (xhttp.readyState == 4 && xhttp.status == 200) {
		    tweetdata = xhttp.responseText;
		    tweetdata = JSON.parse(tweetdata);
		    userActivity();
		    getFollowingData(); 
		    processData();
		   }
		}
		xhttp.open("GET", "../models/personaltweet.php?type="+(type)+"&&username="+user, true);
		xhttp.send();
	}

	window.onload = getData();
	setInterval(function(){ getData(); }, 30000);


	function pressDelete(val){
		var retVal = confirm("Sure you want to delete this tweet? There is NO undo!");
		if( retVal == true ){
			tweetdata = tweetdata.filter(function(i) {
				return i.id != val
			});
			processData();
			xhttp = new XMLHttpRequest();
		    xhttp.onreadystatechange = function() {
		      if (xhttp.readyState == 4 && xhttp.status == 200) {
		        //console.log(xhttp.responseText);
		      }
		    }

		    xhttp.open("GET", "../models/deletetweet.php?id="+(val), true);
		    xhttp.send();
		    return true;
		}
		else{
		  return false;
		}
	}

	function pressFollow(val){
		var retVal = confirm("Want to follow this user?");
		if( retVal == true ){
			
			var followObj = {};
			followObj.followname = val;
			followingData.push(followObj);

			processData();
			
			xhttp = new XMLHttpRequest();
		    xhttp.onreadystatechange = function() {
		      if (xhttp.readyState == 4 && xhttp.status == 200) {
		        //console.log(xhttp.responseText);
		      }
		    }

		    xhttp.open("GET", "../models/userfollow.php?followname="+val, true);
		    xhttp.send();
		    return true;
		}
		else{
		  return false;
		}
	}

	function pressUnfollow(val){
		var retVal = confirm("Cancle following this user?");
		if( retVal == true ){

			followingData = followingData.filter(function(i) {
				return i.followname != val
			});
			processData();

			xhttp = new XMLHttpRequest();
		    xhttp.onreadystatechange = function() {
		      if (xhttp.readyState == 4 && xhttp.status == 200) {
		       // console.log(xhttp.responseText);
		      }
		    }

		     xhttp.open("GET", "../models/userunfollow.php?followname="+val, true);
		     xhttp.send();
		     return true;
		}
		else{
		  return false;
		}
	}

	function buttonBack(){
		currentPage--;
		processData();
	}

	function buttonNext(){
		currentPage++;
		processData();
	}

	function displayTweet(){
		for(var i=0; i<10; i++)
			$("#display"+i).attr("style", "display:none;");
			//$("#delete"+i).attr("style", "display:none;");
	}

	function getFollowingData(){
		xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
		  if (xhttp.readyState == 4 && xhttp.status == 200) {
		    followingData = xhttp.responseText;
		    followingData = JSON.parse(followingData);
		   }
		}
		xhttp.open("GET", "../models/followinglist.php?username="+sesssion_user, false);
		xhttp.send();
		//console.log(sesssion_user);
	}

	function isFollowing(fname){
		for(var i=0; i<followingData.length; i++) {
			if(followingData[i].followname == fname)
				return true;
		}
		return false;
	}

	function mouseActionInFollowingButton(x){
		 document.getElementById(x).innerHTML = 'Unfollow';
		 //document.getElementById(x).style.background='#00aced';
		 document.getElementById(x).style.background='#8A0868';
		 document.getElementById(x).style.color = 'white';
		 document.getElementById(x).style.fontWeight = "800";
	}

	function normalFollowingButton(x){
		document.getElementById(x).innerHTML = 'Following';
		document.getElementById(x).style.background='#00aced';
		document.getElementById(x).style.color = 'white';
		document.getElementById(x).style.fontWeight = "";
	}

</script>

<script type="text/javascript">
// validation check
$(".btn").mouseup(function(){
    $(this).blur();
})
</script>

</body>
</html>