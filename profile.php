<?php
include("header.php");
include("Queries.php");
include("utils.php");

session_start();

$username = $_SESSION['username'];

if(isset($_GET['id'])) {
    $username = $_GET['id'];
}

$user_profile = get_profile($username);

if($user_profile == null) {
    die("Could not get user profile");
}


if(isset($_GET['action'])) {
    if($_GET['action'] == "addmoderator") {
        if(!isset($_GET['id'])) {
            die("Must specify id for this action");
        }
        
        make_moderator($_GET['id']);
    } else if($_GET['action'] == "removemoderator") {
        if(!isset($_GET['id'])) {
            die("Must specify id for this action");
        }
        
        remove_moderator($_GET['id']);
    }
}
?>

Welcome, <?=$user_profile->firstName?> <?=$user_profile->lastName?> (<?=$user_profile->username?>)!<br>
<a href="">Logout</a><br><br>

<?php
if(!is_moderator($user_profile->username)) {
    echo '<a href="profile.php?action=addmoderator&id=' . $user_profile->username . '">Promote to Moderator</a><br><br>';
} else {
    echo '<a href="profile.php?action=removemoderator&id=' . $user_profile->username . '">Demote to User</a><br><br>';
}
?>

<a href="artists.php?action=list">View Artists</a><br>
<br>
<b><?=$user_profile->username?>'s Favorite artists</b><br>
<?php
$favorites = get_all_usernames_and_favorites_per_favorite($username);
foreach($favorites as $favorite) {
    echo '<a href="artists.php?action=details&id=' . $favorite['artistId'] . '">' . $favorite['artistName'] . '</a><br>';
}
?>
<br>
<b>Concerts <?=$user_profile->username?> has attended</b><br>
Concert A...<br>
Concert B...<br>
Concert C...<br>
Concert D...<br>
<br>
<b><?=$user_profile->username?>'s Comments</b><br>
Comment A...<br>
Comment B...<br>
Comment C...<br>
Comment D...<br>
<br>
