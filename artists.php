<?php
include("header.php");
include("Queries.php");
include("utils.php");

if(!isset($_SESSION['username'])) {
    die();
}

$username = $_SESSION['username'];

$artists = get_all_artist_info();

function get_artist_details($artist_id, $artists) {
    if(!array_key_exists($artist_id, $artists))
        return null;
    else
        return $artists[$artist_id];
}


if(!isset($_GET['action']) || empty($_GET['action']) || $_GET['action'] == "list") {?>
<div class="panel panel-default">
  <div class="panel-heading">All artists</div>
  <div class="panel-body">
	<ul class="list-group">

<?php
foreach($artists as $artist) {
    echo '<a class="list-group-item" href="artists.php?action=details&id=' . $artist["artistId"] . '">' . $artist["name"] . '</a>';
}
?>
	</ul>
	</div>
</div>
<?php
    if(is_moderator($username)) {
?>
<a class="btn btn-info btn-block" href="artists.php?action=addartist">Add new artist</a>

<?php
    }
}
else if($_GET['action'] == "addfavorite") {
    if(!isset($_GET['id'])) {
        die("Need to specify id for details action");
    }
    
    $artist_id = intval($_GET['id']);
    
    add_favorite($_SESSION['username'], $artist_id);
    
    echo "Artist added to favorites!";
    
    header('Location: artists.php?action=details&id=' . $artist_id, true);
}
else if($_GET['action'] == "removefavorite") {
    if(!isset($_GET['id'])) {
        die("Must specify id for this action");
    }
    
    $artist_id = intval($_GET['id']);
    
    remove_favorite($_SESSION['username'], $artist_id);
    
    echo "Artist removed from favorites!";
    
    header('Location: artists.php?action=details&id=' . $artist_id, true);
}
else if($_GET['action'] == "details") {
    if(!isset($_GET['id'])) {
        die("Need to specify id for details action");
    }
    
    $artist_id = intval($_GET['id']);
    
    $details = get_artist_details($artist_id, $artists);
    
    if(!$details) {
        echo "Artist id " . $artist_id . " does not exist in the database";
    } else {
// Display artist details
?>
<div class="panel panel-default">
  <div class="panel-heading"><h3><?=$details['name']?></h3><?php
if(is_moderator($username)) {
?>
<div class="btn-group">
  <button type="button" class="btn btn-info dropdown-toggle navbar-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Edit: <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="artists.php?action=editartist&artistId=<?=$details['artistId']?>">Edit artist</a></li>
    <li><a href="artists.php?action=deleteartist&id=<?=$details['artistId']?>">Delete artist</a></li>
    <li><a href="artists.php?action=addmember&id=<?=$details['artistId']?>">Add Member</a></li>
    <li><a href="album.php?action=addalbum">Add album</a></li>
  </ul>
</div>
<?php } ?></div>
  <div class="panel-body">
    <b>Date formated</b>: <?=$details['formDate']?><br>
	<?php
	if(!empty($details['breakupDate'])) {
	?>
	<b>Date disbanded</b>: <?=$details['breakupDate']?><br>
	<?php } ?>
	<b>Formation Zipcode</b>: <?=$details['formationZipCode']?><br>
  </div>
</div>

<br>
<?php if(is_favorite($_SESSION['username'], $details['artistId'])) { ?>
<a class="btn btn-warning btn-block" href="artists.php?action=removefavorite&id=<?=$details['artistId']?>">Remove from favorites</a><br>
<?php } else { ?>
<a class="btn btn-success btn-block" href="artists.php?action=addfavorite&id=<?=$details['artistId']?>">Add to favorites</a><br>
<?php } ?>
<div class="panel panel-default">
  <div class="panel-heading"><h4>Members</h4></div>
  <div class="panel-body">
	<ul class="list-group">
<?php
foreach(get_members($details['artistId']) as $member) {
    echo '<li class="list-group-item"> Name: ' . $member['name'] . '<br>';
    echo 'Join Date: ' . $member['joinDate'] . '<br>';
    if(!empty($member['leaveDate'])) {
        echo 'Leave Date: ' . $member['leaveDate'] . '<br>';
    }
    
    if(is_moderator($_SESSION['username'])) {
        echo '<a href="artists.php?action=editmember&id=' . $details['artistId'] . '&memberId=' . $member['memberId'] . '">Edit Member</a><br>';
        echo '<a href="artists.php?action=deletemember&id=' . $member['memberId'] . '">Remove Member</a>';
    }
	echo '</li>';
}
?>
	</ul>
  </div>
</div>
<br>
<div class="panel panel-default">
  <div class="panel-heading"><h4>Albums</h4></div>
  <div class="panel-body">
	<ul class="list-group">
<?php
$artist_releases = get_albums_per_artist($details['artistId']);
foreach($artist_releases as $release) {
    echo '<li class="list-group-item"> Title: ' . $release['title'] . '<br>';
    echo 'Record Label: ' . $release['recordLabel'] . '<br>';
    echo 'Release Date: ' . $release['releaseDate'] . '<br>';
    echo '<a href="album.php?action=details&id=' . $release['albumId'] . '">View tracklist</a><br>';
    echo '</li>';
}
?>
	</ul>
  </div>
</div>
<br>
<div class="panel panel-default">
  <div class="panel-heading"><h4>Performances</h4></div>
  <div class="panel-body">
	<ul class="list-group">
<?php
$performances = get_all_performances_by_artist($details['artistId']);

foreach($performances as $performance) {
    echo '<a class="list-group-item" href="performance.php?action=details&id='.$performance['performanceId'].'">'.$performance['title'].'</a>';
}
?>
	</ul>
  </div>
</div>
<br>
<div class="panel panel-default">
  <div class="panel-heading"><h4>Who Favorited This Artist?</h4></div>
  <div class="panel-body">
	<ul class="list-group">
<?php
$favorites = get_all_favorites_per_artist($details['artistId']);

foreach($favorites as $favorite) {
    echo '<a class="list-group-item" href="profile.php?id='.$favorite['username'].'">'.$favorite['username'].'</a>';
}
?>
	</ul>
  </div>
</div>
<br>
<div class="panel panel-default">
  <div class="panel-heading"><h4>Comments</h4></div>
  <div class="panel-body">
	<ul class="list-group">
<?php
    $comments = get_comments_by_artist($details['artistId']);
	echo '<li class="list-group-item">
	<a href="comment.php?action=addcomment&artistId='.$details['artistId'].'">Add comment</a>';
    foreach($comments as $comment) {
		echo '<li class="list-group-item">';
        if($comment['username'] == null) {
            echo 'Username: <i>Deleted user</i><br>';
        } else {
?>
        Username: <a href="profile.php?id=<?=$comment['username']?>"><?=$comment['username']?></a>&nbsp;&nbsp;&nbsp;&nbsp;
<?php } ?>
        Date: <?=$comment['postDate']?><br>
        Comment: <?=$comment['comment']?><br>
        
        <?php if($comment['username'] == $_SESSION['username'] || is_moderator($_SESSION['username'])) { ?>
        (<a href="comment.php?action=editcomment&id=<?=$details['artistId']?>&commentId=<?=$comment['commentId']?>">Edit</a> | <a href="comment.php?action=deletecomment&artistId=<?=$details['artistId']?>&id=<?=$comment['commentId']?>">Delete</a>)<br>
        <?php } ?>
        </li>
<?php
    }
?>
  </div>
</div>
<?php
    }
}
else if($_GET['action'] == "addartist" || $_GET['action'] == "editartist") {
    is_moderator_or_die();

    $name = "";
    $name_error = "";

    $formDate = "";
    $formDate_error = "";

    $breakupDate = "";
    $breakupDate_error = "";

    $formationZipCode = 0;
    $formationZipCode_error = "";

    $artistId = -1;
	
	if($_GET['action'] == "editartist" && isset($_GET['artistId'])) {
        if(!isset($_GET['artistId'])) {
            die("Must specify id for this action");
        }
        
        $artistId = intval($_GET['artistId']);
        
        // Get artist information from database and set fields above
        $details = get_artist_details($artistId, $artists);
        
        $name = $details['name'];
        $formDate = $details['formDate'];
        $breakupDate = $details['breakupDate'];
        $formationZipCode = $details['formationZipCode'];
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = sanitize_input($_POST['name']);
        $formDate = sanitize_input($_POST['formDate']);
        $breakupDate = sanitize_input($_POST['breakupDate']);
        $formationZipCode = sanitize_input($_POST['formationZipCode']);
        
        if(isset($_POST['artistId'])) {
            $artistId = intval($_POST['artistId']);
        }
        
        $has_error = false;
        if(empty($name)) {
            $name_error = "Artist name cannot be empty";
            $has_error = true;
        }
        
        if($formationZipCode <= 9999) {
            $formationZipCode_error = "Formation zipcode must be 5 digits";
            $has_error = true;
        }
        
        if(!$has_error) {
            // Successful
            
            if($artistId == -1) {
                $ret = add_artist($name, $formDate, $breakupDate, $formationZipCode);
            } else {
                $ret = update_artist($artistId, $name, $formDate, $breakupDate, $formationZipCode);
            }
            
            if(!$has_error) {
                header('Location: artists.php?action=list', true);
                die();
            }
        }
    }
        
    // Display add artist page
    ?>
	<form action="" method="post" style="display: block;">
		<div class="form-group">
			<input type="text" name="name" id="name" tabindex="1" class="form-control" placeholder="Name" value="<?=$name?>">
		</div>
		<?php if(!empty($name_error)) { ?>
            <span class="error"><font color="red">* <?=$name_error?></font></span>
        <?php } ?>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon3">Formation Date</span>
				<input type="date" name="formDate" id="formDate" tabindex="2" class="form-control" placeholder="Date Formed" value="<?=$formDate?>">
			</div>
		</div>
		<?php if(!empty($formDate_error)) { ?>
            <span class="error"><font color="red">* <?=$formDate_error?></font></span>
        <?php } ?>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon3">Breakup Date</span>
				<input type="date" name="breakupDate" id="breakupDate" tabindex="3" class="form-control" placeholder="Date Disbanded" value="<?=$breakupDate?>">
			</div>
		</div>
		<?php if(!empty($breakupDate_error)) { ?>
            <span class="error"><font color="red">* <?=$breakupDate_error?></font></span>
        <?php } ?>
		<div class="form-group">
			<input type="number"  min="10000" max="99999" name="formationZipCode" id="formationZipCode" tabindex="3" class="form-control" placeholder="Formation Zipcode" value="<?=$formationZipCode?>">
		</div>
		<?php if(!empty($formationZipCode_error)) { ?>
            <span class="error"><font color="red">* <?=$formationZipCode_error?></font></span>
        <?php } ?>
		<div class="form-group">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
					<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Save">
				</div>
			</div>
		</div>
	</form>
<?php
}
else if($_GET['action'] == "deleteartist") {
    is_moderator_or_die();

    if(!isset($_GET['id'])) {
        die("Must specify id for this action");
    }

    $artistId = intval($_GET['id']);
    $ret = remove_artist($artistId);

    // Check error code on delete?
    header('Location: artists.php?action=list', true);
}
else if($_GET['action'] == "addmember" || $_GET['action'] == "editmember") {
    is_moderator_or_die();

    if(!isset($_GET['id'])) {
        die("Must specify id for this action");
    }

    $artistId = intval($_GET['id']);
    $memberId = -1;

    $joinDate = "";
    $joinDate_error = "";

    $leaveDate = "";
    $leaveDate_error = "";

    $name = "";
    $name_error = "";

    if($_GET['action'] == "editmember" && isset($_GET['memberId'])) {
        $memberId = intval($_GET['memberId']);    
        $details = get_member_details($memberId);
        
        $joinDate = $details['joinDate'];
        $leaveDate = $details['leaveDate'];
        $name = $details['name'];
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $joinDate = sanitize_input($_POST['joinDate']);
        $leaveDate = sanitize_input($_POST['leaveDate']);
        $name = sanitize_input($_POST['name']);
        
        $artistId = intval($_POST['artistId']);
            
        if(isset($_POST['memberId'])) {
            $memberId = intval($_POST['memberId']);
        }
        
        $has_error = false;
        
        if(!$has_error) {
            // Successful
            
            if($memberId == -1) {
                $ret = add_member_to_artist($artistId, $joinDate, $leaveDate, $name);
            } else {
                $ret = update_member($memberId, $artistId, $joinDate, $leaveDate, $name);
            }
            
            if(!$has_error) {
                header('Location: artists.php?action=details&id=' . $artistId, true);
                die();
            }
        }
    }
    ?>

	<form action="" method="post" style="display: block;">
		<div class="form-group">
			<input type="text" name="name" id="name" tabindex="1" class="form-control" placeholder="Name" value="<?=$name?>">
		</div>
		<?php if(!empty($name_error)) { ?>
            <span class="error"><font color="red">* <?=$name_error?></font></span>
        <?php } ?>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon3">Join Date</span>
				<input type="date" name="joinDate" id="joinDate" tabindex="2" class="form-control" placeholder="Password" value="<?=$joinDate?>">
			</div>
		</div>
		<?php if(!empty($joinDate_error)) { ?>
            <span class="error"><font color="red">* <?=$joinDate_error?></font></span>
        <?php } ?>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon3">Leave Date</span>
				<input type="date" name="leaveDate" id="leaveDate" tabindex="3" class="form-control" placeholder="leaveDate" value="<?=$leaveDate?>">
			</div>
		<?php if(!empty($leaveDate_error)) { ?>
            <span class="error"><font color="red">* <?=$leaveDate_error?></font></span>
        <?php } ?>
		<input type="hidden" name="artistId" value="<?=$artistId?>">
        <input type="hidden" name="memberId" value="<?=$memberId?>">
		<br>
		<div class="form-group">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
					<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Save">
				</div>
			</div>
		</div>
	</form>
	
<?php
}
else if($_GET['action'] == "deletemember") {
    is_moderator_or_die();

    if(!isset($_GET['id'])) {
        die("Must specify id for this action");
    }

    $memberId = intval($_GET['id']);
    $ret = remove_member($memberId);

    // Check error code on delete?
    header('Location: artists.php?action=list', true);
}
?>
