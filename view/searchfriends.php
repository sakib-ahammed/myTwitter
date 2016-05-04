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
	<title>myTwitter: Search Friends</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/methods.js"></script>
</head>

<body>

	<br>
  	<div class="container" style="" id="searchoption">
		<br><br><br><br><br><br><br><br><br>
		<div class="row">
		  <div class="col-md-8 col-md-offset-2 centered">
		    <div class="input-group">
		      
		      <input type="text" class="form-control" placeholder="Find your friends...." id="searchvalue">
		      <span class="input-group-btn">
		       <button class="btn btn-secondary" type="submit" id="search" onclick="buttonSearch(this.id)">search</button>
		      </span>

		    </div>
		 </div>
		</div>

	    <div class="col-md-8 col-md-offset-2">
	      <p>Search by username or name</p>
	    </div>

	    <br><br>
	    <div class="col-md-8 col-md-offset-2">
	      <h4 id="errorresultshow" style="color: red;"></h4>
	    </div>

	</div>



	<div class="container" id="searchfriend" style="display: none;">
		<br>
		<div class="row">
		  <div class="col-md-8 col-md-offset-2">
		    <div class="input-group">
		      <input type="text" class="form-control" placeholder="Find your friends...." id="searchfriendvalue">
		      <span class="input-group-btn">
		       <button class="btn btn-secondary" type="button" id="searchfriend" onclick="buttonSearch(this.id)">search</button>
		      </span>
		    </div>
		 </div>
		</div>

		<div class="col-md-8 col-md-offset-2">
	      <p>Search by username or name</p>
	    </div>
	    <br><br>
	    <div class="col-md-8 col-md-offset-2">
	      <h4 id="errorresultshow1" style="color: red;"></h4>
	    </div>

	    <!-- result display here in view list -->
	    <div class="row">
		 <div class="col-md-8 col-md-offset-2" id="displaylist" style="display: none;">
	    	<ul class="list-group">
			  	
			  	<?php for($i = 0; $i < 10; $i++) { ?>
			  		<li class="list-group-item" id="display<?php echo $i; ?>">
	      				<h4>
	      				<a href="" id="username<?php echo $i; ?>"> </a>
	      				<span id="name<?php echo $i; ?>"></span>
	   
	      				<span class="btn pull-right" id="followspan">
	      				<button class="btn btn-default btn-sm" type="submit" value="" name="btn-follow" id="follow<?php echo $i; ?>" onclick="pressFollow(this.value)">Follow</button>
	      				</span>
	      				</h4>
				  		
				  		<p id="tweet<?php echo $i; ?>"></p>
				  		<p id="time<?php echo $i; ?>"></p>
			  		</li>
				<?php } ?>
			</ul>

				<button class="btn btn-default" type="submit" value="next" name="btn-next" id="btn-next" style="float: right;" onclick="buttonNext()"> Next</button>
	        	<button class="btn btn-default" type="submit" value="back" name="btn-back" id="btn-back" style="float: right;" onclick="buttonBack()"> Back</button>
	    </div>
	    </div>
	    <!-- display end  -->

	</div>

<script type="text/javascript">
	var searchData;
	var userFollowerData;
	var searchStr;
	var currentPage = 0;

	$("#btn-back").attr("style", "display:none;");
	$("#btn-next").attr("style", "display:none;");

	function buttonSearch(id) {
		document.getElementById("errorresultshow").innerHTML = "";
		document.getElementById("errorresultshow1").innerHTML = "";
		if (id == "search") {
			searchStr = document.getElementById("searchvalue").value;
			searchStr = searchStr.trim();
			if(searchStr.length < 1) {
				document.getElementById("errorresultshow").innerHTML = "Please search by username or name.";
				return 0;
			}
			$("#searchoption").attr("style", "display:none;");
			$("#searchfriend").attr("style", "");
			document.getElementById("searchfriendvalue").value = searchStr;
		}
		else{
			searchStr = document.getElementById("searchfriendvalue").value;
			searchStr = searchStr.trim();
			if(searchStr.length < 1) {
				document.getElementById("errorresultshow1").innerHTML = "Please search by username or name.";
				$("#displaylist").attr("style", "display:none;");
				return 0;
			}
		}

		xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
		  if (xhttp.readyState == 4 && xhttp.status == 200) {
		    searchData = xhttp.responseText;
		    //console.log(searchData);
		    if(searchData == "sorry"){
		    	document.getElementById("errorresultshow1").innerHTML = "The target user is not found.";
		    	$("#displaylist").attr("style", "display:none;");
		    }
		    else{
		    	searchData = JSON.parse(searchData);
		    	processSearchData();
		    }
		  }
		}
		xhttp.open("GET", "../models/search.php?str="+searchStr, true);
		xhttp.send();
	}

	function processSearchData() {
		userFollowerData = searchData[searchData.length-1];
		
		displayData();
		$("#displaylist").attr("style", "");
		if(currentPage == 0)
			$("#btn-back").attr("style", "display:none;");
		else
			$("#btn-back").attr("style", "float:right;");

		if(currentPage == Math.floor((searchData.length-1)/10))
			$("#btn-next").attr("style", "display:none;");
		else
			$("#btn-next").attr("style", "float:right;");

		var start = currentPage*10;
		var end = start+10;
		var i=0;
		for(var j=start; j<end; j++){

			if(j < searchData.length-1)
			{
				document.getElementById("username"+i).innerHTML = searchData[j].username;
				document.getElementById("name"+i).innerHTML = "@"+searchData[j].name;
				document.getElementById("tweet"+i).innerHTML = searchData[j].tweet;
				document.getElementById("time"+i).innerHTML = searchData[j].time;
				
				$("#username"+i).attr("href", "usertweet.php?type=0&&username="+searchData[j].username);
				$("#follow"+i).attr("value", searchData[j].username);
				
				 if(isFollower(searchData[j].username))
				 	$("#follow"+i).attr("style", "display:none;");
			}
			else{
				$("#display"+i).attr("style", "display:none;");
			}
			
			i++;
		}

	}

	function isFollower(fname){
		for(var i=0; i<userFollowerData.length; i++) {
			if(userFollowerData[i].followname == fname)
				return true;
		}
		return false;
	}

	function pressFollow(followerName){
		
	    var retVal = confirm("Want to follow this user?");
		if( retVal == true ){
			
			//console.log(followerName);
			var followObj = {};
			followObj.followname = followerName;
			userFollowerData.push(followObj);
			processSearchData();

			xhttp = new XMLHttpRequest();
		    xhttp.onreadystatechange = function() {
		      if (xhttp.readyState == 4 && xhttp.status == 200) {
		        //console.log(xhttp.responseText);
		      }
		    }

		     xhttp.open("GET", "../models/userfollow.php?followname="+followerName, true);
		     xhttp.send();
		    return true;
		}
		else{
		  return false;
		}


	}


	function buttonBack(){
		currentPage--;
		processSearchData();
	}

	function buttonNext(){
		currentPage++;
		processSearchData();
	}

	function displayData(){
		for(var i=0; i<10; i++){
			$("#display"+i).attr("style", "");
			$("#follow"+i).attr("style", "");
		}
	}

	$(".btn").mouseup(function(){
    	$(this).blur();
	})

</script>

</body>
</html>