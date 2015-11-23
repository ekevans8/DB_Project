<?php
include("header.php");
include("Queries.php");
include("utils.php");

if(!isset($_SESSION['username'])) {
    die();
}

if(!isset($_GET['action']) || $_GET['action'] == "list") {
    $performances = get_all_performances();
    echo "<div class='panel panel-default'>
	<div class='panel-heading'>Performances</div>
		<div class='panel-body'>
		<ul class='list-group'>";
    foreach($performances as $performance) {
        echo '<a class="list-group-item" href="performance.php?action=details&id='.$performance['performanceId'].'">'.$performance['title'].' ('.$performance['date'].')</a>';
    }
	echo '</ul>
	</div>
</div>';
}

else if($_GET['action'] == "listvenues") {
    $venues = get_all_venues();
    echo '<div class="panel panel-default">
	  <div class="panel-heading"><h4>Venues</h4></div>
	  <div class="panel-body">
		<ul class="list-group">';
    foreach($venues as $venue) {
        echo '<a class="list-group-item" href="performance.php?action=showvenue&venueId='.$venue['venueId'].'">'.$venue['name'].'</a>';
    }
	echo '</ul>
  </div>
</div>';
}

else if($_GET['action'] == "showvenue") {
    if(!isset($_GET['venueId'])) {
        die("Must specify venueId for this action");
    }
        
    $venueId = intval($_GET['venueId']);
    
    $venue = get_venue_by_id($venueId);
?>
<div class="panel panel-default">
  <div class="panel-heading"><h4><?=$venue['name']?></h4></div>
  <div class="panel-body">
	<ul class="list-group">
<b>Street Address</b>: <?=$venue['streetAddress']?><br>
<b>City</b>: <?=$venue['city']?><br>
<b>State</b>: <?=$venue['state']?><br>
<b>Zipcode</b>: <?=$venue['zipcode']?><br><br>
<?php if(is_moderator($_SESSION['username'])) { ?>
<a class="btn btn-success btn-block" href="performance.php?action=editvenue&venueId=<?=$venue['venueId']?>">Edit venue</a>
	</ul>
  </div>
</div>
<?php } ?>
<div class="panel panel-default">
  <div class="panel-heading"><h4>Performances</h4></div>
  <div class="panel-body">
	<ul class="list-group">
<?php
    $performances = get_performances_by_venue($venueId);
    
    foreach($performances as $performance) {
        echo '<li class="list-group-item"><a href="performance.php?action=details&id='.$performance['performanceId'].'">'.$performance['title'].'</a> ('.$performance['date'].')</li>';
    }
	echo '</ul>
  </div>
</div>';
}
else if($_GET['action'] == "removesong") {
    if(!isset($_GET['performanceId'])) {
        die("Must specify performanceId for this action");
    }
    
    if(!isset($_GET['songId'])) {
        die("Must specify songId for this action");
    }
    
    if(!isset($_GET['artistId'])) {
        die("Must specify artistId for this action");
    }
    
    $performanceId = intval($_GET['performanceId']);
    $songId = intval($_GET['songId']);
    $artistId = intval($_GET['artistId']);
    
    remove_song_played_to_performance($performanceId, $songId, $artistId);
    
    header('Location: performance.php?action=details&id=' . $performanceId, true);
    die();
}
else if($_GET['action'] == "addsong") {
    if(!isset($_GET['performanceId'])) {
        die("Must specify performanceId for this action");
    }
    
    $performanceId = intval($_GET['performanceId']);
    
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(!isset($_POST['songId'])) {
            die("Must specify songId for this action");
        }
        
        if(!isset($_POST['artistId'])) {
            die("Must specify artistId for this action");
        }
        
        if(!isset($_POST['performanceId'])) {
            die("Must specify performanceId for this action");
        }
        
        $songId = intval($_POST['songId']);
        $artistId = intval($_POST['artistId']);
        $performanceId = intval($_POST['performanceId']);
        
        add_song_played_to_performance($performanceId, $songId, $artistId);
        
        header('Location: performance.php?action=details&id=' . $performanceId, true);
        die();
    }
?>

	<form action="" method="post" style="display: block;">
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon3">Artist</span>
				<select name="artistId" class="form-control" style="width:100%">
					<?php
					$artists = get_all_artist_info();

					foreach($artists as $artist) {
						echo '<option value="'.$artist['artistId'].'">'.$artist['name'].'</option>';
					}
					?>
                </select>
			</div>
		</div>

		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon3">Song</span>
				<select name="songId" class="form-control" style="width:100%">
					<?php
					$songs = get_all_songs();

					foreach($songs as $song) {
						echo '<option value="'.$song['songId'].'">'.$song['title'].'</option>';
					}
					?>
                </select>
			</div>
		</div>

		<input type="hidden" name="performanceId" value="<?=$performanceId?>">
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
else if($_GET['action'] == "details") {
    if(!isset($_GET['id'])) {
        die("Must specify id for this action");
    }

    $performanceId = intval($_GET['id']);
    
    $details = get_performance_details($performanceId);
    $comments = get_comments_by_performance($performanceId);
    $summary = get_performance_summary($performanceId);
?>
<div class="panel panel-default">
  <div class="panel-heading"><?=$details['title']?></div>
  <div class="panel-body">
		<ul class="list-group">
			<?php 
			$venue = get_venue_by_id($details['venueId']);
			?>
				<b>Venue</b>: <a href="performance.php?action=showvenue&venueId=<?=$venue['venueId']?>"><?=$venue['name']?></a><br>
				<b>Date</b>: <?=$details['date']?><br>
				<b>Duration (minutes)</b>: <?=$details['duration']?><br>
		</ul>
		<?php
		if(is_moderator($_SESSION['username'])) {
		?>
		<a href="artists.php?action=editperformance&id=-1&performanceId=<?=$details['performanceId']?>">Edit performance</a> | <a href="artists.php?action=deleteperformance&id=<?=$details['performanceId']?>">Remove performance</a> | <a href="performance.php?action=addsong&performanceId=<?=$performanceId?>">Add song</a><br>
		<br>
		<?php
		}
		?>
	</div>
</div> 
    Did you attend this performance? <a href="performance.php?action=addattended&id=<?=$performanceId?>">Yes</a> / <a href="performance.php?action=removeattended&id=<?=$performanceId?>">No</a><br>
    Attended? <?php echo attended_concert_by_id($_SESSION['username'], $performanceId) ? "Yes" : "No"; ?>
    <br><br>
	<div class="panel panel-default">
	  <div class="panel-heading">Setlist</div>
	  <div class="panel-body">
			<ul class="list-group">
<?php
$i = 1;
foreach($summary as $songinfo) {
    echo '<li class="list-group-item">'.$i . ') <a href="artists.php?action=details&id='.$songinfo['artistId'].'">' . $songinfo['Artist'] . '</a> - ' . $songinfo['SongTitle'];
    
    if(is_moderator($_SESSION['username'])) {
        echo ' (<a href="performance.php?action=removesong&performanceId='.$songinfo['performanceId'].'&songId='.$songinfo['songId'].'&artistId='.$songinfo['artistId'].'">Remove</a>)';
    }
    
    echo '</li>';
    $i++;
}
?>
		</ul>
	</div>
</div> 
    <br>
	<div class="panel panel-default">
	  <div class="panel-heading">Users who attended this concert</div>
	  <div class="panel-body">
			<ul class="list-group">
<?php
    $users = get_users_at_performance($performanceId);
    
    foreach($users as $user) {
        echo '<a class="list-group-item" href="profile.php?id='.$user['username'].'">'.$user['username'].'</a>';
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
	echo '<li class="list-group-item">
		<a href="comment.php?action=addcomment&performanceId='.$performanceId.'">Add comment</a>
	<li>';
    foreach($comments as $comment) {
		echo '<li class="list-group-item">';
        if($comment['username'] == null) {
            echo 'Username: <i>Deleted user</i><br>';
        } else {
?>
        Username: <a href="profile.php?id=<?=$comment['username']?>"><?=$comment['username']?></a><br>
<?php } ?>
        Date: <?=$comment['postDate']?><br>
        Comment: <?=$comment['comment']?><br>
        
        <?php if($comment['username'] == $_SESSION['username'] || is_moderator($_SESSION['username'])) { ?>
        (<a href="comment.php?action=editcomment&performanceId=<?=$performanceId?>&commentId=<?=$comment['commentId']?>">Edit</a> | <a href="comment.php?action=deletecomment&performanceId=<?=$performanceId?>&id=<?=$comment['commentId']?>">Delete</a>)<br>
		<?php } ?>
		</li>
<?php } ?>
	</ul>
  </div>
</div>
<?php
}
else if($_GET['action'] == "addattended") {    
    if(!isset($_GET['id'])) {
        die("Must specify id for this action");
    }

    $performanceId = intval($_GET['id']);
    
    if(!attended_concert_by_id($_SESSION['username'], $performanceId))
        $ret = add_attended_performance($_SESSION['username'], $performanceId);
    
    header('Location: performance.php?action=details&id=' . $performanceId, true);
    die();
}
else if($_GET['action'] == "removeattended") {
    if(!isset($_GET['id'])) {
        die("Must specify id for this action");
    }

    $performanceId = intval($_GET['id']);
    
    $ret = remove_atteneded_performance($_SESSION['username'], $performanceId);
    
    header('Location: performance.php?action=details&id=' . $performanceId, true);
    die();
}
else if($_GET['action'] == "addvenue" || $_GET['action'] == "editvenue") {
    is_moderator_or_die();

    $name = "";
    $name_error = "";
    
    $streetAddress = "";
    $streetAddress_error = "";
    
    $city = "";
    $city_error = "";
    
    $state = "";
    $state_error = "";
    
    $zipcode = 10000;
    $zipcode_error = "";

    if($_GET['action'] == "editvenue" && isset($_GET['venueId'])) {
        $venueId = intval($_GET['venueId']);    
        $details = get_venue_by_id($venueId);
        
        $name = $details['name'];
        $streetAddress = $details['streetAddress'];
        $city = $details['city'];
        $state = $details['state'];
        $zipcode = $details['zipcode'];
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = sanitize_input($_POST['name']);
        $streetAddress = sanitize_input($_POST['streetAddress']);
        $city = sanitize_input($_POST['city']);
        $state = sanitize_input($_POST['state']);
        $zipcode = sanitize_input($_POST['zipcode']);
        
        $has_error = false;
        if(empty($name)) {
            $name_error = "Name cannot be empty";
            $has_error = true;
        }
        
        if(empty($streetAddress)) {
            $streetAddress_error = "Street address cannot be empty";
            $has_error = true;
        }
        
        if(empty($city)) {
            $city_error = "City cannot be empty";
            $has_error = true;
        }
        
        if(empty($state)) {
            $state_error = "State cannot be empty";
            $has_error = true;
        }
    
        if($zipcode <= 9999) {
            $zipcode_error = "Zipcode must be 5 digits";
            $has_error = true;
        }
        
        if(isset($_POST['venueId'])) {
            $venueId = intval($_POST['venueId']);
        }
        
        if(!$has_error) {
            // Successful
            
            if($venueId == -1) {
                $ret = add_venue($name, $streetAddress, $city, $state, $zipcode);
            } else {
                $ret = update_venue($venueId, $name, $streetAddress, $city, $state, $zipcode);
            }
            
            if(!$has_error) {
                header('Location: performance.php?action=showvenue&venueId=' . $venueId, true);
                die();
            }
        }
    }
    ?>

	<form id="login-form" action="" method="post" style="display: block;">
		<div class="form-group">
			<input type="text" name="name" id="name" tabindex="1" class="form-control" placeholder="Name" value="<?=$name?>">
		</div>
		<?php if(!empty($name_error)) { ?>
            <span class="error"><font color="red">* <?=$name_error?></font></span>
        <?php } ?>
		
		<div class="form-group">
			<input type="text" name="streetAddress" id="streetAddress" tabindex="1" class="form-control" placeholder="Street Address" value="<?=$streetAddress?>">
		</div>
		<?php if(!empty($streetAddress_error)) { ?>
            <span class="error"><font color="red">* <?=$streetAddress_error?></font></span>
        <?php } ?>
		
		<div class="form-group">
			<input type="text" name="city" id="city" tabindex="1" class="form-control" placeholder="City" value="<?=$city?>">
		</div>
		<?php if(!empty($city_error)) { ?>
            <span class="error"><font color="red">* <?=$city_error?></font></span>
        <?php } ?>
		
		<div class="form-group">
			<input type="text" name="state" id="state" tabindex="1" class="form-control" placeholder="State" value="<?=$state?>">
		</div>
		<?php if(!empty($state_error)) { ?>
            <span class="error"><font color="red">* <?=$state_error?></font></span>
        <?php } ?>
		
		<div class="form-group">
			<input type="number" name="zipcode" min="10000" max="99999" id="zipcode" tabindex="1" class="form-control" placeholder="Zipcode" value="<?=$zipcode?>">
		</div>
		<?php if(!empty($zipcode_error)) { ?>
            <span class="error"><font color="red">* <?=$zipcode_error?></font></span>
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
else if($_GET['action'] == "deletevenue") {
    is_moderator_or_die();

    if(!isset($_GET['id'])) {
        die("Must specify id for this action");
    }

    $venueId = intval($_GET['id']);
    $ret = remove_venue($venueId);

    // Check error code on delete?
    header('Location: artists.php?action=list', true);
    die();
}
?>