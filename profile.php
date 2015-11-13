<?php
include("header.php");

$firstname = "Test";
$lastname = "Account";
$username = "bdawg";

?>

Welcome, <?=$firstname?> <?=$lastname?> (<?=$username?>)!<br>
<a href="">Logout</a><br><br>

<a href="artists.php?action=list">View Artists</a> | <a href="concerts.php?action=list">View Concerts</a><br>
<br>
<b>Favorite artists</b><br>
Band A...<br>
Band B...<br>
Band C...<br>
Band D...<br>
<br>
<b>Concerts attended</b><br>
Concert A...<br>
Concert B...<br>
Concert C...<br>
Concert D...<br>
<br>
<b>Comments</b><br>
Comment A...<br>
Comment B...<br>
Comment C...<br>
Comment D...<br>
<br>