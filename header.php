<?php
session_start();
?>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>

	
<?php if(isset($_SESSION['username'])) { ?>
Welcome, <?=$_SESSION['firstname']?> <?=$_SESSION['lastname']?> (<a href="profile.php"><?=$_SESSION['username']?></a>)!<br>
<a href="register.php?action=update?>">Edit Profile</a> | <a href="profile.php?action=delete">Delete Account</a> | <a href="login.php?action=logout">Logout</a><br><br>

<a href="profile.php">Home</a> | <a href="artists.php?action=list">View Artists</a> | <a href="album.php?action=list">View Albums</a> | <a href="performance.php?action=list">View Performances</a> | <a href="performance.php?action=listvenues">View Venues</a><br>
<br>
<?php } elseif("$_SERVER[REQUEST_URI]" == "/"){?>
<div class="page-header">
  <h1>Welcome to our Database Project</h1>
</div>
<ul class="nav nav-pills">
  <li class="active">
    <a href="/">Home</a>
  </li>
  <li>
    <a href="login.php?action=login">Login</a>
  </li>
  <li><a href="register.php">Register</a></li>
</ul>
<?php } elseif("$_SERVER[REQUEST_URI]" == "/login.php?action=login"){ ?> 
<div class="page-header">
  <h1>Login To The Site</h1>
</div>
<ul class="nav nav-pills">
  <li>
    <a href="/">Home</a>
  </li>
  <li class="active">
    <a href="login.php?action=login">Login</a>
  </li>
  <li><a href="register.php">Register</a></li>
</ul>
<?php } else { ?>
<div class="page-header">
  <h1>Register To The Site</h1>
</div>
<ul class="nav nav-pills">
  <li>
    <a href="/">Home</a>
  </li>
  <li>
    <a href="login.php?action=login">Login</a>
  </li>
  <li class="active">
	<a href="register.php">Register</a>
  </li>
</ul>
<?php } ?>
<br>