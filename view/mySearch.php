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
	<title>myTwitter: mySearch</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/methods.js"></script>
</head>

<body>

	<br>

	<div class="container" >
		<br>
		<div class="row">
		  <div class="col-md-8 col-md-offset-2">
		    <div class="input-group">
		      <input type="text" class="form-control" placeholder="Find your friends...." id="searchfriendvalue" onkeyup="customeSearch()"> <!-- onkeyup="customeSearch()" -->
		      <span class="input-group-btn">
		       <button class="btn btn-secondary" type="button" id="searchfriend" onclick="customeSearch()" >search</button>
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
		 <div class="col-md-8 col-md-offset-2">
	    	<ul class="list-group" id="displaylist">
			  	
			  <?php for($i = 0; $i < 10; $i++) { ?>
			  		<li class="list-group-item" id="display<?php echo $i; ?>">
	      				<h4>
	      				<a href="" id="username<?php echo $i; ?>"></a>
	      				<span id="name<?php echo $i; ?>"></span>
	      				
	      				<span class="btn pull-right" >

		      				<button class="btn btn-default btn-sm" type="submit" value="" name="btn-follow" id="follow<?php echo $i; ?>" onclick="pressFollow(this.value)">Follow</button>

		      				<button class="btn btn-default btn-sm" type="submit" value="" name="btn-unfollow" id="unfollow<?php echo $i; ?>" onclick="pressUnfollow(this.value)" onmouseover="mouseActionInFollowingButton(this.id)"  onmouseout="normalFollowingButton(this.id)">Following</button>

	      				</span>
	      				</h4>
			  		</li>
				<?php } ?>

			</ul> 

				<button class="btn btn-default" type="submit" value="next" name="btn-next" id="btn-next" style="float: right;" onclick="buttonNext()"> Next</button>
	        	<button class="btn btn-default" type="submit" value="back" name="btn-back" id="btn-back" style="float: right;" onclick="buttonBack()"> Back</button>
	    </div>
	    </div>
	    <!-- display end  -->

	</div>

<p style="display: none;" id="user_session"><?php echo $_SESSION['user_session']; ?></p>

<script type="text/javascript">

	var sesssion_user = document.getElementById("user_session").innerHTML;
	var userInformation, followingData;
	
	/////////////////////////////////////////
	//empty index by every letter & digit

	var Indexing ={};
	var letterDigit = "abcdefghijklmnopqrstuvwxyz0123456789 ";
	letterDigit = letterDigit.toLowerCase();
	for(var i=0; i<letterDigit.length; i++)
		Indexing[letterDigit[i]] = [];

	////////////////////////////////////////
	// getting information from database

	function getInformation(){
		var ss = document.getElementById("searchfriendvalue").value;
		ss = ss.trim();
		if(ss.length < 1){
			$("#displaylist").attr("style", "display:none;");
			$("#btn-back").attr("style", "display:none;");
			$("#btn-next").attr("style", "display:none;");
		}

		xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
		  if (xhttp.readyState == 4 && xhttp.status == 200) {
		    userInformation = xhttp.responseText;
		    userInformation = JSON.parse(userInformation);
		    
		    followingData = userInformation[userInformation.length-1];
		    userInformation.splice(userInformation.length-1, 1);
		    indexProcessing();
		   }
		}
		xhttp.open("GET", "../models/mysearchquery.php", false);
		xhttp.send();
	}

	window.onload = getInformation();
	setInterval(function(){ getInformation(); }, 30000);

	//////////////////////////////////////////////////////
	//Indexing processing from userinfo(username, name)

	function notDuplicate(data, id){
	   for(var i=0; i<data.length; i++)
	       if(data[i].username == id || data[i].name == id) 
	          return false;
	   return true;
	}

	function indexProcessing(){
		for(var i=0; i<userInformation.length; i++){
	   		var username = userInformation[i].username.toLowerCase();
	   		var name = userInformation[i].name.toLowerCase();
	   		for(var j=0; j<username.length; j++){
	   			if(notDuplicate(Indexing[username[j]], username))
	   			{	
	   				var obj = {};
	   				obj["username"] = username;
	   				obj["name"] = name;
	      			Indexing[username[j]].push(obj);
	   			}
	   		}
	   		for(var j=0; j<name.length; j++){
	   			if(notDuplicate(Indexing[name[j]], name))
	   			{
	   				var obj = {};
	   				obj["username"] = username;
	   				obj["name"] = name;
	      			Indexing[name[j]].push(obj);
	   			}
	   		}
		}	
	}
	//console.log(Indexing);

	/////////////////////////////////////////////////////////
	/// Search string process
	
	var resultInfo = [];
	var searchStr;
	function notDuplicateInfo(data, id){
	   for(var i=0; i<data.length; i++)
	       if(data[i].username == id.username) 
	          return false;
	   return true;
	}

	function customeSearch(){
		document.getElementById("errorresultshow1").innerHTML = "";
		searchStr = document.getElementById("searchfriendvalue").value;
		searchStr = searchStr.trim();
		if(searchStr.length < 1) {
			document.getElementById("errorresultshow1").innerHTML = "Please search by username or name.";
			$("#displaylist").attr("style", "display:none;");
			return 0;
		}
		else{
			$("#displaylist").attr("style", "");
			currentPage = 0;
		}

		for(var i=0; i<searchStr.length; i++){
			for(var j=0; j<Indexing[searchStr[i]].length; j++)
				if(notDuplicateInfo(resultInfo, Indexing[searchStr[i]][j]))
					resultInfo.push(Indexing[searchStr[i]][j]);
		}

		patternSearch();
		processData();
	}

	///////////////////////////////////////////////////////////////
	/// applaying KMP algorithm for pattern searching from resultInfo w.r.t searchStr

	var prefixes;
	function patternSearch(){
		prefixes = longestPrefix(searchStr);

		for(var i=0; i<resultInfo.length; i++){
			var value1 = 0;
			var value2 = 0;
			var ss = "";
			for(var j=0; j<searchStr.length; j++){
				ss += searchStr[j];
				var v1 = kmpMatching(resultInfo[i].username, ss);
				var v2 = kmpMatching(resultInfo[i].name, ss);
				value1 += v1;
				value2 += v2;
			}

			(v1>v2)? resultInfo[i]["value"] = value1 : resultInfo[i]["value"] = value2;
		}

		resultInfo.sort(sort_by('value', true, parseInt));
	}

	/////////////////////////////////////////////////////////////////////
	//applying KMP matching algorithm

	function longestPrefix(str) {
		var table = new Array(str.length);
		var maxPrefix = 0;
		table[0] = 0;

		for (var i = 1; i < str.length; i++) {
			while (maxPrefix > 0 && str.charAt(i) !== str.charAt(maxPrefix)) {
				maxPrefix = table[maxPrefix - 1];
			}
			if (str.charAt(maxPrefix) === str.charAt(i)) {
				maxPrefix++;
			}
			table[i] = maxPrefix;
		}
		return table;
	}


	function kmpMatching(str, pattern) {
  		
  		var matches = [];
  
		var j = 0;
		var i = 0;
		var value = 0;
		while (i < str.length) {
			if (str.charAt(i) === pattern.charAt(j)) {
				i++;
				j++;
				value++;
			}

	    	if (j === pattern.length) {
	      		matches.push(i-j);
	      		j = prefixes[j-1];
	      		value *= pattern.length;
	      	}
		    else if (str.charAt(i) !== pattern.charAt(j)) {
		        if (j !== 0) {
		            j = prefixes[j-1];
		        } else {
		            i++;
		        }
		    }
  		}

  		value *= matches.length;
  		var power = 20;
  		for(var i=0; i<matches.length; i++)
  			value += (power - matches[i])*pattern.length;

  		return value;
	}

	////////////////////////////////////////////////////////////////////////////
	// sorting after getting resultinfo

	var sort_by = function(field, reverse, primer){
		var key = primer ? 
		   function(x) {return primer(x[field])} : 
		   function(x) {return x[field]};

		reverse = !reverse ? 1 : -1;

		return function (a, b) {
		   return a = key(a), b = key(b), reverse * ((a > b) - (b > a));
		} 
	}

	/////////////////////////////////////////////////////////////////////////////// 
	///////////////////////  End of Searching calculation   ///////////////////////
	////////////////////////////////////////////////////////////////////////////////
	/// data process for showing

	var currentPage = 0;
	function processData(){
		displayTweet();
		if(currentPage == 0)
			$("#btn-back").attr("style", "display:none;");
		else
			$("#btn-back").attr("style", "float:right;");

		if(currentPage == Math.floor(resultInfo.length/10))
			$("#btn-next").attr("style", "display:none;");
		else
			$("#btn-next").attr("style", "float:right;");

		var start = currentPage*10;
		var end = start+10;
		var i=0;
		for(var j=start; j<end; j++){

			if(j < resultInfo.length && resultInfo[j].username != sesssion_user)
			{
				document.getElementById("username"+i).innerHTML = resultInfo[j].username;
				document.getElementById("name"+i).innerHTML = "@"+resultInfo[j].name;

				
				$("#username"+i).attr("href", "usertweet.php?type=0&&username="+resultInfo[j].username);
				$("#follow"+i).attr("value", resultInfo[j].username);
				$("#unfollow"+i).attr("value", resultInfo[j].username);
				

				if (resultInfo[j].username == sesssion_user){
					$("#follow"+i).attr("style", "display: none;");
					$("#unfollow"+i).attr("style", "display: none;");
				}
				else if(isFollowing(resultInfo[j].username)){
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
			$("#display"+i).attr("style", "");
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



	$(".btn").mouseup(function(){
	    $(this).blur();
	})
</script>

</body>
</html>