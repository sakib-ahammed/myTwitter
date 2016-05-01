
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


<nav class="navbar navbar-light" style="background-color: #e3f2fd;">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="/Twitter/view/">myTwitter</a>

      <ul class="nav navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="/Twitter/view/mySearch.php">my Search Engine</span></a>
        </li>
    </ul>

    </div>

    
    <ul class="nav navbar-nav navbar-right">
     <li ><a href="/Twitter/view/home.php">Home</a></li>

     <?php if(!isset($_SESSION['user_session'])) { ?>
      <li><a href="/Twitter/view/registration.php"><span class="glyphicon glyphicon-user"></span> Registration</a></li>
      <li><a href="/Twitter/index.php"><span class="glyphicon glyphicon-log-in"></span> Log in</a></li>

<?php }   else { ?>
      <li><a href="/Twitter/view/searchfriends.php"><span class="glyphicon glyphicon-user"></span> Find friends</a></li>
      <li><a href="/Twitter/models/logout.php"><span class="glyphicon glyphicon-log-in"></span> Log out</a></li>
<?php }?>
    </ul>
  </div>
</nav>

</body>
</html>


