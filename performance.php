<?php
include("header.php");
include("Queries.php");
include("utils.php");

if(!isset($_SESSION['username'])) {
    die();
}

if(!isset($_GET['action']) || $_GET['action'] == "list") {
    $performances = get_all_performances();
    
    foreach($performances as $performance) {
        echo '<a href="performance.php?action=details&id='.$performance['performanceId'].'">'.$performance['title'].'</a> ('.$performance['date'].')<br>';
    }
}

else if($_GET['action'] == "showvenue") {
    if(!isset($_GET['venueId'])) {
        die("Must specify venueId for this action");
    }
        
    $venueId = intval($_GET['venueId']);
    
    $venue = get_venue_by_id($venueId);
?>
<b>Venue</b>: <?=$venue['name']?><br>
<b>Street Address</b>: <?=$venue['streetAddress']?><br>
<b>City</b>: <?=$venue['city']?><br>
<b>State</b>: <?=$venue['state']?><br>
<b>Zipcode</b>: <?=$venue['zipcode']?><br>
<br>
<b>Performances</b>:<br>
<?php
    $performances = get_performances_by_venue($venueId);
    
    foreach($performances as $performance) {
        echo '<a href="performance.php?action=details&id='.$performance['performanceId'].'">'.$performance['title'].'</a> ('.$performance['date'].')<br>';
    }
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
    <form action="" method="POST">
    <table>
        <tr>
            <td>Artist:</td>
            <td>
                <select name="artistId" style="width:100%">
<?php
$artists = get_all_artist_info();

foreach($artists as $artist) {
    echo '<option value="'.$artist['artistId'].'">'.$artist['name'].'</option>';
}
?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Song:</td>
            <td>
                <select name="songId" style="width:100%">

<?php
$songs = get_all_songs();

foreach($songs as $song) {
    echo '<option value="'.$song['songId'].'">'.$song['title'].'</option>';
}
?>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="hidden" name="performanceId" value="<?=$performanceId?>">
                <input type="submit" value="Submit" style="width:100%"></input>
            </td>
        </tr>
    </table>
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

    <b>Title</b>: <?=$details['title']?><br>
<?php 
$venue = get_venue_by_id($details['venueId']);
?>
    <b>Venue</b>: <a href="performance.php?action=showvenue&venueId=<?=$venue['venueId']?>"><?=$venue['name']?></a><br>
    <b>Date</b>: <?=$details['date']?><br>
    <b>Duration (minutes)</b>: <?=$details['duration']?><br>
    <br>
<?php
if(is_moderator($_SESSION['username'])) {
?>
<a href="performance.php?action=addsong&performanceId=<?=$performanceId?>">Add song</a><br>
<br>
<?php
}
?>
    Did you attend this performance? <a href="performance.php?action=addattended&id=<?=$performanceId?>">Yes</a> / <a href="performance.php?action=removeattended&id=<?=$performanceId?>">No</a><br>
    Attended? <?php echo attended_concert_by_id($_SESSION['username'], $performanceId) ? "Yes" : "No"; ?>
    <br>
    <br>
    <b>Setlist</b>:<br>
<?php
$i = 1;
foreach($summary as $songinfo) {
    echo $i . ') <a href="artists.php?action=details&id='.$songinfo['artistId'].'">' . $songinfo['Artist'] . '</a> - ' . $songinfo['SongTitle'];
    
    if(is_moderator($_SESSION['username'])) {
        echo ' (<a href="performance.php?action=removesong&performanceId='.$songinfo['performanceId'].'&songId='.$songinfo['songId'].'&artistId='.$songinfo['artistId'].'">Remove</a>)';
    }
    
    echo '<br>';
    $i++;
}
?>
    <br>
    <b>Users who attended this concert</b><br>
<?php
    $users = get_users_at_performance($performanceId);
    
    foreach($users as $user) {
        echo '<a href="profile.php?id='.$user['username'].'">'.$user['username'].'</a><br>';
    }
?>
    <br>
    <b>Comments</b><br>
<?php
    foreach($comments as $comment) {
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
        <br>
<?php
    }
?>
    <a href="comment.php?action=addcomment&performanceId=<?=$performanceId?>">Add comment</a><br>
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

    if($_GET['action'] == "editmember" && isset($_GET['venueId'])) {
        $venueId = intval($_GET['venueId']);    
        $details = get_venue_details($venueId, $venueId_info);
        
        $name = $details['joinDate'];
        $streetAddress = $details['leaveDate'];
        $city = $details['name'];
        $state = $details['name'];
        $zipcode = $details['name'];
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
                header('Location: artists.php?action=details&id=' . $artistId, true);
                die();
            }
        }
    }
    ?>

    <form action="" method="POST">
    <table>
        <tr>
            <td>Name:</td>
            <td><input type="text" name="name" style="width:100%" value="<?=$name?>"></input>
            <?php if(!empty($name_error)) { ?>
            <span class="error">* <?=$name_error?></span>
            <?php } ?>
            </td>
        </tr>
        <tr>
            <td>Street Address:</td>
            <td><input type="text" name="streetAddress" style="width:100%" value="<?=$streetAddress?>"></input>
            <?php if(!empty($streetAddress_error)) { ?>
            <span class="error">* <?=$streetAddress_error?></span>
            <?php } ?>
            </td>
        </tr>
        <tr>
            <td>City:</td>
            <td><input type="text" name="city" style="width:100%" value="<?=$city?>"></input>
            <?php if(!empty($city_error)) { ?>
            <span class="error">* <?=$city_error?></span>
            <?php } ?>
            </td>
        </tr>
        <tr>
            <td>State:</td>
            <td><input type="text" name="state" style="width:100%" value="<?=$state?>"></input>
            <?php if(!empty($state_error)) { ?>
            <span class="error">* <?=$state_error?></span>
            <?php } ?>
            </td>
        </tr>
        <tr>
            <td>Zipcode:</td>
            <td><input type="number" name="zipcode" min="10000" max="99999" style="width:100%" value="<?=$zipcode?>"></input>
            <?php if(!empty($zipcode_error)) { ?>
            <span class="error">* <?=$zipcode_error?></span>
            <?php } ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type="submit" value="Submit" style="width:100%"></input></td>
        </tr>
    </table>
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