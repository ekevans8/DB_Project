<?php
include("header.php");
include("Queries.php");
include("utils.php");

if(!isset($_SESSION['username'])) {
    die();
}

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

<?php
if(isset($_GET['id'])) { ?>
<b>Viewing <?=$user_profile['firstName']?> <?=$user_profile['lastName']?> (<?=$user_profile['username']?>)'s profile</b><br>
<br>
<?php } ?>

<?php
if(is_moderator($_SESSION['username'])) {
    if(!is_moderator($user_profile['username'])) {
        echo '<a href="profile.php?action=addmoderator&id=' . $user_profile['username'] . '">Promote to Moderator</a><br><br>';
    } else {
        echo '<a href="profile.php?action=removemoderator&id=' . $user_profile['username'] . '">Demote to User</a><br><br>';
    }
}
?>

<b><?=$user_profile['username']?>'s favorite artists</b><br>
<?php
$favorites = get_all_usernames_and_favorites_per_favorite($username);
foreach($favorites as $favorite) {
    echo '<a href="artists.php?action=details&id=' . $favorite['artistId'] . '">' . $favorite['artistName'] . '</a><br>';
}
?>
<br>
<b>Concerts <?=$user_profile['username']?> has attended</b><br>
<?php
$performances = get_Attended_performances_per_username($username);

foreach($performances as $performance) {
    echo '<a href="performance.php?action=details&id='.$performance['performanceId'].'">'.$performance['title'].'</a><br>';
}
?>
<br>
<b><?=$user_profile['username']?>'s Comments</b><br>
<?php
$comments = get_comments_by_username($username);

foreach($comments as $comment) {
    if($comment['performanceId'] != null)
        echo '<a href="performance.php?action=details&id='.$comment['performanceId'].'">'.$comment['comment'].'</a> on ' . $comment['postDate'] . '<br>';
    else if($comment['artistId'] != null)
        echo '<a href="artists.php?action=details&id='.$comment['artistId'].'">'.$comment['comment'].'</a> on ' . $comment['postDate'] . '<br>';
    else
        echo $comment['comment'].' on ' . $comment['postDate'] . '<br>';
}
?>
<br>
