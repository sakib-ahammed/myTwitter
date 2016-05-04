<?php
session_start();

if(isset($_SESSION['user_session']))
{
    $newURL = "../view/";
    header('Location: '.$newURL);
}
require '../database/db_connection.php';
require_once 'header.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>myTwitter: Registration Confirmation</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

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


</head>
<body>

	<br>
<div class="wrapper">
    <form class="form-signin" action="../">       
      <div class="panel">
	    <h2 class="test-center"> Joined in Twitter.</h2> <br>
	   <h4 ><i><b style="color: blue;" ><?php  echo $_GET["username"];  ?></b></i> has joined in Twitter.</h4> <br>
	    <p class="test-center"> Please click on the log in button, log into twitter and tweet.</p> <br>        
	    </div>  
      <!-- <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>  -->
      <input class="btn btn-lg btn-primary " type="submit" value="login" name="btn-login" id="btn-login">  
    </form>



</body>
</html>