<?php
session_start();
?>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>

<?php if(isset($_SESSION['username'])) { ?>
Welcome, <?=$_SESSION['firstname']?> <?=$_SESSION['lastname']?> (<?=$_SESSION['username']?>)!<br>
<a href="login.php?action=logout">Logout</a><br><br>

<a href="artists.php?action=list">View Artists</a> | <a href="album.php?action=list">View Albums</a> | <a href="performance.php?action=list">View Performances</a><br>
<br>
<?php } else { ?>
<a href="login.php?action=login">Login</a><br><br>
<?php } ?>
