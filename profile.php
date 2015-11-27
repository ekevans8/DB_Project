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
    } else if($_GET['action'] == "delete") {
        delete_user($_SESSION['username']);
        session_destroy();  
        $_SESSION = array();
        //die("Your account has been removed from the database.");
        header("Location: login.php", true);
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
        echo '<a class="btn btn-success btn-block" href="profile.php?action=addmoderator&id=' . $user_profile['username'] . '">Promote to Moderator</a><br><br>';
    } else {
        echo '<a class="btn btn-warning btn-block" href="profile.php?action=removemoderator&id=' . $user_profile['username'] . '">Demote to User</a><br><br>';
    }
}
?>
<div class="panel panel-default">
  <div class="panel-heading"><?=$user_profile['username']?>'s Favorite Artists</div>
  <div class="panel-body">
		<ul class="list-group">
		<?php
		$favorites = get_all_usernames_and_favorites_per_favorite($username);
		foreach($favorites as $favorite) {
			echo '<a class="list-group-item" href="artists.php?action=details&id=' . $favorite['artistId'] . '">' . $favorite['artistName'] . '</a>';
		}
		?>
		</ul>
	</div>
</div>
<br>
<div class="panel panel-default">
  <div class="panel-heading">Concerts <?=$user_profile['username']?> Has Attended</div>
  <div class="panel-body">
	<ul class="list-group">
		<?php
		$performances = get_Attended_performances_per_username($username);

		foreach($performances as $performance) {
			echo '<a class="list-group-item" href="performance.php?action=details&id='.$performance['performanceId'].'">'.$performance['title'].'</a>';
		}
		?>
	</ul>
	</div>
</div>
<br>
<div class="panel panel-default">
  <div class="panel-heading"><?=$user_profile['username']?>'s Comments</div>
  <div class="panel-body">
	<ul class="list-group">
		<?php
		$comments = get_comments_by_username($username);

		foreach($comments as $comment) {
			if($comment['performanceId'] != null)
				echo '<a class="list-group-item" href="performance.php?action=details&id='.$comment['performanceId'].'">'.$comment['comment'].' on ' . $comment['postDate'].'</a>';
			else if($comment['artistId'] != null)
				echo '<a class="list-group-item" href="artists.php?action=details&id='.$comment['artistId'].'">'.$comment['comment'].' on ' . $comment['postDate'].'</a>';
			else
				echo $comment['comment'].' on ' . $comment['postDate'] . '<br>';
		}
		?>
	</ul>
	</div>
</div>
<br>
<div class="panel panel-default">
  <div class="panel-heading">Top songs <?=$user_profile['username']?> Saw Live</div>
  <div class="panel-body">
	<ul class="list-group">
<?php
$song_ranking = get_most_seen_songs_per_user($username);

$i = 1;
foreach($song_ranking as $song) {
    if($song['NumberSeen'] == 1)
        echo '<li class="list-group-item">
		<span class="badge">'.$song['NumberSeen'].'</span>'.$i.') <a href="artists.php?action=details&id=' . $song['artistId'] . '">' . $song['Artist'] . '</a> - ' . $song['SongTitle'] . ' (Seen ' . $song['NumberSeen'] . ' time)</li>';
    else
        echo '<li class="list-group-item">
		<span class="badge">'.$song['NumberSeen'].'</span>'.$i.') <a href="artists.php?action=details&id=' . $song['artistId'] . '">' . $song['Artist'] . '</a> - ' . $song['SongTitle'] . ' (Seen ' . $song['NumberSeen'] . ' times) </li>';
    $i++;
}
?>
</ul>
	</div>
</div>
<br>
