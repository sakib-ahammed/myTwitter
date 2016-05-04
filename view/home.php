<?php
session_start();
if(!isset($_SESSION['user_session']))
{
	$newURL = "../index.php";
 	header('Location: '.$newURL);
}
require '../database/db_connection.php';
require_once 'header.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>myTwitter: Home</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/methods.js"></script>
</head>
<body>
<<<<<<< HEAD
<script type="text/javascript">
	function checkChar(){
		$("#error_tweet_length").attr("style", "float:right;");
		var str = document.getElementById("tweet_field").value;
		document.getElementById("error_tweet_length").innerHTML = (140 - str.length)+" to mores........";
		if(str.length>140)
		{
			str = str.trim();
			document.getElementById("error_tweet_length").innerHTML = "Please writte within 140 characters.";
			$("#error_tweet_length").attr("style", "color:red; float:right;");
		}
			
	}


	function checkLength(){
		var str = document.forms["tweet_form"]["tweet_field"].value;
		//console.log(str);

		if(str.trim().length > 140)
			return false;
		else
			return true;
	}

</script>


<br>

<div class="container" id="homepage">
<form role = "form" action="../models/posttweet.php" name="tweet_form" onsubmit="return checkLength()" method="post">
=======
<br>


<div class="container" id="homepage">
<form role = "form" action="../models/posttweet.php" method="post">
>>>>>>> bf2fd72058cb94713eeb047052f17f13d6b9531d

<div class="form-horizontal">
	
	<div class="row">
<<<<<<< HEAD
        <div class="col-md-8">
            
            <p id="doing">What are you doing?</p>
             <span id="error_tweet_length" > </span>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-8">
            <textarea class="form-control" id="tweet_field" name="tweet" rows="2" onkeyup="checkChar()" placeholder="What's your mind?" required ></textarea>
=======
        <div class="col-md-6">
            <p id="doing">What are you doing?</p>
        </div>
    </div>



    <div class="form-group">
        <div class="col-md-8">
            <textarea class="form-control" name="tweet" rows="2" placeholder="What's your mind?" required ></textarea>
>>>>>>> bf2fd72058cb94713eeb047052f17f13d6b9531d
        </div>
    </div>


    <div class="form-group">
	    <div class="col-md-8">
	            <div class="col-md-10">
<<<<<<< HEAD
	            	<li class="list-group-item" >
=======
	            	<li class="list-group-item">
>>>>>>> bf2fd72058cb94713eeb047052f17f13d6b9531d
		            	<span id="newesttweet">login user latest tweet</span><br>
		            	<span id="newesttweettime">login user latest tweet time</span>
		            </li>
	            </div>
	        
	    		<span>
	        	<button class="btn btn-default btn-lg" style="float: right;" type="submit" value="tweet" name="btn-tweet" id="btn-tweet">tweet</button>
	        	</span>

	    </div>
    </div>
</div>

</form>
</div>

<!-- tweet data view -->


<div class="container">
<<<<<<< HEAD
  	<div class="row" id="displaylist" style="display: none;">
=======
  	<div class="row">
>>>>>>> bf2fd72058cb94713eeb047052f17f13d6b9531d
	  	<div class="col-md-8">
			<ul class="list-group">
			  	
			<!-- list view start  -->
			 
			  	<?php for($i = 0; $i < 10; $i++) { ?>
			  		<li class="list-group-item" id="display<?php echo $i; ?>">
	      				<h4>
	      				<a href="" id="username<?php echo $i; ?>"></a>
	      				
	      				<span class="btn pull-right" >
		      				<button class="btn btn-default btn-sm" type="submit" value="" name="btn-delete" id="delete<?php echo $i; ?>" onclick="pressDelete(this.value)"><span class="glyphicon glyphicon-trash"></span>
		      				</button>
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
					Number of Contribution
					<span id="contributionnumber" style="float: right;">0</span>
				</div>
			</a>

			</ul>
		</div>

		<!-- user activity division end -->

	</div>   

</div>

<!-- twitter data end -->



<p style="display: none;" id="user_name"><?php echo $_SESSION['user_session']; ?></p>


<script type="text/javascript">
	var user = document.getElementById("user_name").innerHTML;
	var tweetdata;
	var currentPage = 0;

	function processData(){

		displayTweet();
<<<<<<< HEAD
		$("#displaylist").attr("style", "");
=======
>>>>>>> bf2fd72058cb94713eeb047052f17f13d6b9531d
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
				document.getElementById("tweet"+i).innerHTML = tweetdata[j].tweet;
				document.getElementById("time"+i).innerHTML = tweetdata[j].modified;
				
				$("#username"+i).attr("href", "usertweet.php?type=0&&username="+tweetdata[j].username);
				$("#delete"+i).attr("value", tweetdata[j].id);
				
				if(user == tweetdata[j].username)
					$("#delete"+i).attr("style", "");
				else
					$("#delete"+i).attr("style", "display: none;");
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
		  }
		}
		xhttp.open("GET", "../models/useractivity.php?username="+user, true);
		xhttp.send();
	}

	function getData() {
		xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
		  if (xhttp.readyState == 4 && xhttp.status == 200) {
		    tweetdata = xhttp.responseText;
		    tweetdata = JSON.parse(tweetdata);
		    newestTweetpreocess();
		    processData();
		    userActivity();
		  }
		}
		xhttp.open("GET", "../models/processhomepage.php", false);
		xhttp.send();
	}

	window.onload = getData();
	setInterval(function(){ getData(); }, 30000);


	function pressDelete(val){
		var retVal = confirm("Sure you want to delete this tweet? There is NO undo!");
		if( retVal == true ){
		  	//tweetdata.splice(0, 1);
			tweetdata = tweetdata.filter(function(i) {
				return i.id != val
			});
			//console.log(tweetdata);
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

	function newestTweetpreocess(){
		for(var i=0; i<tweetdata.length; i++){
			if(user == tweetdata[i].username){
				document.getElementById("newesttweet").innerHTML = tweetdata[i].tweet;
				document.getElementById("newesttweettime").innerHTML = tweetdata[i].modified;
				tweetdata.splice(i, 1);
				return 0;
			}
		}
		document.getElementById("newesttweet").innerHTML = "";
		document.getElementById("newesttweettime").innerHTML = "";
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

	$(".btn").mouseup(function(){
    	$(this).blur();
	})

</script>

</body>
</html>