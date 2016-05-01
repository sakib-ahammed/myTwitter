
<?php
session_start();

if(isset($_SESSION['user_session']))
{
    $newURL = "view/";
    header('Location: '.$newURL);
}
require 'database/db_connection.php';
require_once 'view/header.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>myTwitter: Login</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/methods.js"></script>
</head>
<body>

<script type="text/javascript">
function checkLogIn() {
	document.getElementById("errorunametext").innerHTML = "";
	document.getElementById("errorpasstext").innerHTML = "";
	var controller = 0;
	var jscheck = 1;
	var username = document.forms["loginform"]["username"].value;
	var password = document.forms["loginform"]["password"].value;
	var regexpuname = /^[A-Za-z0-9-_]{4,20}$/;
    var u = regexpuname.test(username);
	var regexppass = /^[A-Za-z0-9]{4,8}$/;
    var p = regexppass.test(password);
    var xhttp;   
    if (username == "" || username == null) {
		jscheck = 0;
        document.getElementById("errorunametext").innerHTML = "Please enter user ID";
    }
	else if(!u) {
		document.getElementById("errorunametext").innerHTML = "Please enter user ID by (letter,digit,underscore)";
	}
	if(password == "" || password == null) {
		jscheck = 0;
		document.getElementById("errorpasstext").innerHTML = "Please enter password";
	}
	else if(!p) {
		jscheck = 0;
		document.getElementById("errorpasstext").innerHTML = "Please enter password by (letter, digit)";
	}
	if(jscheck == 0) {
		return false;
	}
    var aaa;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (xhttp.readyState == 4 && xhttp.status == 200) {
        //console.log(xhttp.responseText);
        aaa = xhttp.responseText;
        if (xhttp.responseText=="yes") {
      	    controller = 1;
        }
        else if(xhttp.responseText == "no") {
        	document.getElementById("errorpasstext").innerHTML = "your password or user id is incorrect";
        	controller = 0;
        }
      }
    }
    xhttp.open("GET", "models/loginprocess.php?uname="+username+"&&pass="+password, false);
    xhttp.send();
    
    if (controller == 0) {
    	return false;
    }
    else if (controller == 1) {
    	return true;
    }
}


</script>

<!-- <p id="errorunametext" style="color:red"></p>
<p id="errorpasstext" style="color:red"></p>
<form name="loginform" action="view/home.php" method="post" onsubmit="return checkLogIn()">
	username: <input type="text" name="username"><br>
	password: <input type="password" name="password"><br>
	<input type="submit" value="login" name="btn-login" id="btn-login">
</form>
<form name="registration" action="view/registration.php" method="post">
    <input type="submit" value="registration" name="registration" id="registration">
</form> -->

<div class="container">
  <div class="row">
    <div class="col-md-8">
  
  <div class="wrapper">
    <form class="form-signin" name="loginform" action="view/home.php" method="post" onsubmit="return checkLogIn()">       
      <h2 class="form-signin-heading">Log in</h2>

      <p id="errorunametext" style="color:red"></p>
    <p id="errorpasstext" style="color:red"></p>

      User ID: <input type="text" class="form-control" name="username" placeholder="username" required="" autofocus="" /> <br>
      Password: <input type="password" class="form-control" name="password" placeholder="Password" required=""/>  <br>    
      <!-- <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>  -->
      <input class="btn btn-lg btn-primary " type="submit" value="login" name="btn-login" id="btn-login">  
    </form>
  </div>

    </div>
<div class="wrapper">
    <div class="col-md-4">
    <div class="pull-right">
    <form class="form-signin" action="view/registration.php">       
      <h4 class="form-signin-heading">User registration(Free)</h4>    
      <button class="btn btn-lg btn-primary btn-block" type="submit">User registration</button> 
    </form>
</div>
    </div>
        </div>




    </div>
</div>

    <style type="text/css">
  @import "bourbon";



.wrapper {  
    margin-top: 80px;
  margin-bottom: 80px;
}

.form-signin {
  max-width: 500px;
  padding: 15px 35px 45px;
  margin: 0 auto;
  background-color: #fff;
  border: 1px solid rgba(0,0,0,0.1);  

  .form-signin-heading,
    .checkbox {
      margin-bottom: 30px;
    }

    .checkbox {
      font-weight: normal;
    }

    .form-control {
      position: relative;
      font-size: 16px;
      height: auto;
      padding: 10px;
        @include box-sizing(border-box);

        &:focus {
          z-index: 2;
        }
    }

    input[type="text"] {
      margin-bottom: -1px;
      border-bottom-left-radius: 0;
      border-bottom-right-radius: 0;
    }

    input[type="password"] {
      margin-bottom: 20px;
      border-top-left-radius: 0;
      border-top-right-radius: 0;
    }
}

  </style>
</body>
</html>