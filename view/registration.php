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
    <title>myTwitter: Registration</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <style type="text/css">
  .democlass{
    color: black;
  }
  </style>
</head>
<body>
<script type="text/javascript">
  function validateEmail(email) {
      var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email);
  }

  function retrieveAllErrorFieldls() {
      console.log("OK");
      document.getElementById("errorname").innerHTML = "Name can contain any letters or numbers with spaces";
      //$("#errorname").attr("class", "helpblock");
      //document.getElementById("errorname").setAttribute("class", "democlass");
      $("#errorname").css("color", "gray"); 
      document.getElementById("errorusername").innerHTML = "Username can contain any letters or numbers, without spaces";
      $("#errorusername").css("color", "gray");
      document.getElementById("errorpassword").innerHTML = "Password should be at least 4 characters upto 8 characters";
      $("#errorpassword").css("color", "gray");
      document.getElementById("errorconfirmpassword").innerHTML = "Please confirm password";
      $("#errorconfirmpassword").css("color", "gray");
      document.getElementById("erroremail").innerHTML = "Please provide your valid email";
      $("#erroremail").css("color", "gray");

  }

  function checkUserIdDuplication(username) {
      var boolvalue = 0;
      xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
          if (xhttp.responseText=="yes") {
            //alert("Username already exist !");
            document.getElementById("errorusername").innerHTML = "Username already exist !";
            $("#errorusername").css("color", "red");
            boolvalue = 0;
          }
          else if(xhttp.responseText == "no") {
            boolvalue = 1;
          }
        }
      }
      xhttp.open("GET", "../models/checkduplication.php?uname="+username, false);
      xhttp.send();
      if (boolvalue == 0) {
        return true;
      }
      else {
        return false;
      }
  }

  function checkregistration() {
    var jscheck = 1;
    retrieveAllErrorFieldls();
    var name = document.forms["registrationform"]["name"].value;
    var username = document.forms["registrationform"]["username"].value;
    var password = document.forms["registrationform"]["password"].value;
    var confirmpassword = document.forms["registrationform"]["password_confirm"].value;
    var email = document.forms["registrationform"]["email"].value;
    var regexpuname = /^[A-Za-z0-9-_]{4,20}$/;
    var u = regexpuname.test(username);
    var regexppass = /^[A-Za-z0-9]{4,8}$/;
    var p = regexppass.test(password);
    var regexpname = /^[A-Za-z0-9- ]{4,20}$/;
    var n = regexpname.test(name);
    var xhttp;

    if (name == "" || name == null) {
        jscheck = 0;
        document.getElementById("errorname").innerHTML = "Please enter your name";
        $("#errorname").css("color", "red");
    }
    else if(!n) {
      jscheck = 0;
      document.getElementById("errorname").innerHTML = "Please enter your name by (letter,digit,space,highfen)";
      $("#errorname").css("color", "red");
      console.log("called");
    }

    if (username == "" || username == null) {
        jscheck = 0;
        document.getElementById("errorusername").innerHTML = "Please enter user ID";
        $("#errorusername").css("color", "red");
    }
    else if(!u) {
      jscheck = 0;
      document.getElementById("errorusername").innerHTML = "Please enter user ID by (letter,digit,underscore)";
      $("#errorusername").css("color", "red");
    }
    if(password == "" || password == null) {
      jscheck = 0;
      document.getElementById("errorpassword").innerHTML = "Please enter password";
      $("#errorpassword").css("color", "red");
    }
    else if(!p) {
      jscheck = 0;
      document.getElementById("errorpassword").innerHTML = "Password should be at least 4 characters with letter,numbers,underscore and highfen";
      $("#errorpassword").css("color", "red");
    }
    if (confirmpassword != password) {
      jscheck = 0;
      document.getElementById("errorconfirmpassword").innerHTML = "Password does not match";
      $("#errorconfirmpassword").css("color", "red");
    }
    if (!validateEmail(email)) {
      jscheck = 0;
      document.getElementById("erroremail").innerHTML = "Please provide valid email";
      $("#erroremail").css("color", "red");
    }
    if(jscheck == 0) {
      return false;
    }
    var isuexist = checkUserIdDuplication(username);
    if (isuexist){
      jscheck = 0;
    }
    if (jscheck == 0) {
      return false;
    }

  }
</script>
<br>
<div class="container">
  <div class="row">
    <div class="col-md-6">
    
          <form name="registrationform" class="form-horizontal" action="../models/regprocess.php" method="POST" onsubmit="return checkregistration()">
          <fieldset>
            <div id="legend">
              <legend class="">Registration</legend>
            </div>
            <div class="control-group">
              <label class="control-label" for="name">Name</label>
              <div class="controls">
                <input type="text" id="name" name="name" placeholder="" class="form-control input-lg">
                <p class="help-block" id="errorname">Name can contain any letters or numbers with spaces</p>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="username">Username</label>
              <div class="controls">
                <input type="text" id="username" name="username" placeholder="" class="form-control input-lg">
                <p class="help-block" id="errorusername">Username can contain any letters or numbers, without spaces</p>
              </div>
            </div>
         
            <div class="control-group">
              <label class="control-label" for="email">E-mail</label>
              <div class="controls">
                <input type="email" id="email" name="email" placeholder="" class="form-control input-lg">
                <!--<email id="email" name="email" placeholder="" class="form-control input-lg">-->
                <p class="help-block" id="erroremail">Please provide valid your email</p>
              </div>
            </div>
         
            <div class="control-group">
              <label class="control-label" for="password">Password</label>
              <div class="controls">
                <input type="password" id="password" name="password" placeholder="" class="form-control input-lg">
                <p class="help-block" id="errorpassword">Password should be at least 4 characters</p>
              </div>
            </div>
         
            <div class="control-group">
              <label class="control-label" for="password_confirm">Confirm Password</label>
              <div class="controls">
                <input type="password" id="password_confirm" name="password_confirm" placeholder="" class="form-control input-lg">
                <p class="help-block" id="errorconfirmpassword">Please confirm password</p>
              </div>
            </div>
         
            <div class="control-group">
              <!-- Button -->
        <input type="checkbox" name="checkbox" id="checkbox" value="1"><span> tweet is in private</span></input>
              <div class="controls">

                <button class="btn btn-success" >Create account</button>
              </div>
            </div>
          </fieldset>
          <ul class="text-center">
    <br><br>
    <h6>If you click the "Create account" button, we will consider as agreeing to our "Terms Of Service".</h6>
    </ul>
        </form>
    
    </div> 

<div class="col-md-6">
<<<<<<< HEAD
  <div class="pull-right">
      <form class="form-signin" action="../">       
        <h4 class="form-signin-heading">Already registrated?</h4>    
        <button class="btn btn-lg btn-primary btn-block" type="submit">Log in</button> 
      </form>
  </div>
</div>

=======
<div class="pull-right">
    <form class="form-signin" action="../">       
      <h4 class="form-signin-heading">Already registrated?</h4>    
      <button class="btn btn-lg btn-primary btn-block" type="submit">Log in</button> 
    </form>
</div>
</div>


>>>>>>> bf2fd72058cb94713eeb047052f17f13d6b9531d
  </div>
 </div>

</body>
</html>