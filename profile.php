<?php
include("header.php");
include ("utils.php");

$firstname = "Test";
$lastname = "Account";
$username = "bdawg";

if(isset($_GET['id'])) {
    $username = $_GET['id'];
}

?>

Welcome, <?=$firstname?> <?=$lastname?> (<?=$username?>)!<br>
<a href="">Logout</a><br><br>

<?php
if(is_moderator()) {
    if(!is_moderator($username)) {
        echo '<a href="profile.php?action=addmoderator&id=' . $username . '">Promote to Moderator</a><br><br>';
    } else {
        echo '<a href="profile.php?action=removemoderator&id=' . $username . '">Demote to User</a><br><br>';
    }
}
?>

<a href="artists.php?action=list">View Artists</a><br>
<br>
<b><?=$username?>'s Favorite artists</b><br>
Band A...<br>
Band B...<br>
Band C...<br>
Band D...<br>
<br>
<b>Concerts <?=$username?> has attended</b><br>
Concert A...<br>
Concert B...<br>
Concert C...<br>
Concert D...<br>
<br>
<b><?=$username?>'s Comments</b><br>
Comment A...<br>
Comment B...<br>
Comment C...<br>
Comment D...<br>
<br>