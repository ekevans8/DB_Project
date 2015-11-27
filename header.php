<?php
session_start();
?>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>

<STYLE type="text/css">
	.btn-login {
		background-color: #59B2E0;
		outline: none;
		color: #fff;
		font-size: 14px;
		height: auto;
		font-weight: normal;
		padding: 14px 0;
		text-transform: uppercase;
		border-color: #59B2E6;
	}
	.btn-login:hover,
	.btn-login:focus {
		color: #fff;
		background-color: #53A3CD;
		border-color: #53A3CD;
	}
</STYLE>
	
<?php if(isset($_SESSION['username'])) { ?>
<div class="page-header">
  <h1>Welcome, <?=$_SESSION['firstname']?> <?=$_SESSION['lastname']?> (<a href="profile.php"><?=$_SESSION['username']?></a>)!</h1>
  <ul class="nav nav-pills nav-justified">
  <li>
    <a href="/register.php?action=update">Edit Profile</a> 
  </li>
  <li>
    <a href="/profile.php?action=delete">Delete Account</a>
  </li>
  <li>
	<a href="/login.php?action=logout">Logout</a>
  </li>
</ul>
</div>
<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<ul class="nav navbar-nav navbar-left">
        <li><a href="profile.php">My Profile</a></li>
		<li><a href="artists.php?action=list">View Artists</a></li>
		<li><a href="album.php?action=list">View Albums</a></li>
		<li><a href="performance.php?action=list">View Performances</a></li>
		<li><a href="performance.php?action=listvenues">View Venues</a></li>
      </ul>
	</div>
</nav>
<?php } else if($_SERVER[REQUEST_URI] == "/"){?>
<div class="page-header">
  <h1>Welcome to the Music Tracker!</h1>
</div>
<ul class="nav nav-pills nav-justified">
  <li class="active">
    <a href="/">Home</a>
  </li>
  <li>
    <a href="login.php?action=login">Login</a>
  </li>
  <li><a href="register.php">Register</a></li>
</ul>
<?php } else if($_SERVER[REQUEST_URI] == "/login.php?action=login" || $_SERVER[REQUEST_URI] == "/login.php"){ ?> 
<div class="page-header">
  <h1>Login as an Existing User</h1>
</div>
<ul class="nav nav-pills nav-justified">
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
  <h1>Register as a New User</h1>
</div>
<ul class="nav nav-pills nav-justified">
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
