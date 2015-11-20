<?php
include("header.php");
include("Queries.php");
include("utils.php");

$username = "b-dawg";

$artists = get_all_artist_info();

function get_member_details($memberId, $member_info) {
    foreach($member_info as $member) {
        if($member['memberId'] == $memberId) {
            return $member;
        }
    }
    
    return null;
}




function get_artist_details($artist_id, $artists) {
    if(!array_key_exists($artist_id, $artists))
        return null;
    else
        return $artists[$artist_id];
}

function remove_favorite($user_id, $artist_id) {
    return true;
}

function is_artist_favorite($user_id, $artist_id) {
    return false;
}

function add_performance($venueId, $duration, $date) {
    return true;
}

function update_performance($performanceId, $venueId, $duration, $date) {
    return true;
}

function remove_performance($performanceId) {
    return true;
}

function get_performance_details($performance_id) {
    return null;
}

function add_member($joinDate, $leaveDate, $name) {
    return true;
}

function update_member($memberId, $joinDate, $leaveDate, $name) {
    return true;
}

function remove_member($memberId) {
    return true;
}






if(!isset($_GET['action']) || empty($_GET['action']) || $_GET['action'] == "list") {
?>

Artist list:<br>
<?php
foreach($artists as $artist) {
    echo '<a href="artists.php?action=details&id=' . $artist["artistId"] . '">' . $artist["name"] . '</a><br>';
}
    echo '<br>';

    if(is_moderator($username)) {
?>
<a href="artists.php?action=addartist">Add new artist</a>

<?php
    }
}
else if($_GET['action'] == "addfavorite") {
    if(!isset($_GET['id'])) {
        die("Need to specify id for details action");
    }
    
    $artist_id = intval($_GET['id']);
    
    add_favorite(0, $artist_id);
    
    echo "Artist added to favorites!";
}
else if($_GET['action'] == "removefavorite") {
    if(!isset($_GET['id'])) {
        die("Must specify id for this action");
    }
    
    $artist_id = intval($_GET['id']);
    
    remove_favorite(0, $artist_id);
    
    echo "Artist removed from favorites!";
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
<h1><?=$details['name']?></h1>
Date formated: <?=$details['formDate']?><br>
<?php
if(!empty($details['breakupDate'])) {
?>
Date disbanded: <?=$details['breakupDate']?><br>
<?php } ?>
Formation Zipcode: <?=$details['formationZipCode']?><br>
<br>
<?php if(is_artist_favorite(0, $details['artistId'])) { ?>
<a href="artists.php?action=removefavorite&id=<?=$details['artistId']?>">Remove from favorites</a>
<?php } else { ?>
<a href="artists.php?action=addfavorite&id=<?=$details['artistId']?>">Add to favorites</a>
<?php
}

if(is_moderator($username)) {
?>
| <a href="artists.php?action=editartist&id=<?=$details['artistId']?>">Edit artist</a> | <a href="artists.php?action=deleteartist&id=<?=$details['artistId']?>">Delete artist</a> | <a href="artists.php?action=addmember&id=<?=$details['artistId']?>">Add Member</a><br>
<?php } ?>
<br>
<br>
Members:<br>
<?php
foreach(get_members($details['artistId']) as $member) {
    echo 'Name: ' . $member['name'] . '<br>';
    echo 'Join Date: ' . $member['joinDate'] . '<br>';
    if(!empty($member['leaveDate'])) {
        echo 'Leave Date: ' . $member['leaveDate'] . '<br>';
    }
    echo '<a href="artists.php?action=editmember&memberId=' . $member['memberId'] . '">Edit Member</a><br>';
    echo '<a href="artists.php?action=deletemember&id=' . $member['memberId'] . '">Remove Member</a><br>';
    echo '<br>';
}
?>
<br>
Releases:<br>
<?php
foreach($artists_releases[$details['artistId']] as $release) {
    echo 'Title: ' . $release['title'] . '<br>';
    echo 'Record Label: ' . $release['recordLabel'] . '<br>';
    echo 'Release Date: ' . $release['releaseDate'] . '<br>';
    echo '<a href="tracklist.php?id=' . $release['albumId'] . '">View tracklist</a><br>';
    echo '<br>';
}
?>
<br>
Performances:<br>
<?php if(is_moderator($username)) { ?>
<a href="artists.php?action=addperformance&id=<?=$details['artistId']?>">Add performance</a><br>
<?php } ?>
<br>
<br>
Who Favorited This Artist?<br>
<br>
<br>
Comments:<br>
<a href="comment.php?action=addcomment&artistId=<?=$details['artistId']?>">Add comment</a><br>
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

    if($_GET['action'] == "editartist" && isset($_GET['id'])) {
        if(!isset($_GET['id'])) {
            die("Must specify id for this action");
        }
        
        $artistId = intval($_GET['id']);
        
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
            <td>Date Formed:</td>
            <td><input type="date" name="formDate" style="width:100%" value="<?=$formDate?>"></input>
            <?php if(!empty($formDate_error)) { ?>
            <span class="error">* <?=$formDate_error?></span>
            <?php } ?>
            </td>
        </tr>
        <tr>
            <td>Date Disbanded:</td>
            <td><input type="date" name="breakupDate" style="width:100%" value="<?=$breakupDate?>"></input>
            <?php if(!empty($breakupDate_error)) { ?>
            <span class="error">* <?=$breakupDate_error?></span>
            <?php } ?>
            </td>
        </tr>
        <tr>
            <td>Formation Zipcode:</td>
            <td><input type="number" name="formationZipCode" min="10000" max="99999" style="width:100%" value="<?=$formationZipCode?>"></input>
            <?php if(!empty($formationZipCode_error)) { ?>
            <span class="error">* <?=$formationZipCode_error?></span>
            <?php } ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="hidden" name="artistId" value="<?=$artistId?>">
                <input type="submit" value="Submit" style="width:100%"></input>
             </td>
        </tr>
    </table>
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
else if($_GET['action'] == "addperformance" || $_GET['action'] == "editperformance") {
    is_moderator_or_die();

    if(!isset($_GET['id'])) {
        die("Must specify id for this action");
    }

    $artistId = intval($_GET['id']);
    $performanceId = -1;

    $venueId = 0;
    $venueId_error = "";

    $duration = 0;
    $duration_error = "";

    $date = "";
    $date_error = "";

    if($_GET['action'] == "editperformance" && isset($_GET['performanceId'])) {
        $performanceId = intval($_GET['performanceId']);    
        $details = get_performance_details($performanceId);
        
        $venueId = $details['venueId'];
        $duration = $details['duration'];
        $date = $details['date'];
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $venueId = intval($_POST['venueId']);
        $duration = doubleval($_POST['duration']);
        $date = sanitize_input($_POST['date']);
        
        $artistId = intval($_POST['artistId']);
            
        if(isset($_POST['performanceId'])) {
            $performanceId = intval($_POST['performanceId']);
        }
        
        $has_error = false;
        
        if(!$has_error) {
            // Successful
            
            if($performanceId == -1) {
                $ret = add_performance($venueId, $duration, $date);
            } else {
                $ret = update_performance($performanceId, $venueId, $duration, $date);
            }
            
            if(!$has_error) {
                header('Location: artists.php?action=list', true);
                die();
            }
        }
    }
    ?>

    <form action="" method="POST">
    <table>
        <tr>
            <td>Venue:</td>
            <td>
                <select name="venueId" style="width:100%">
                    <option value="0">Venue 1</option>
                    <option value="1">Venue 2</option>
                    <option value="2">Venue 3</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Duration:</td>
            <td><input type="number" name="duration" min="0" step="0.01" style="width:100%" value="<?=$duration?>"></input>
            <?php if(!empty($duration_error)) { ?>
            <span class="error">* <?=$duration_error?></span>
            <?php } ?>
            </td>
        </tr>
        <tr>
            <td>Date:</td>
            <td><input type="date" name="date" style="width:100%" value="<?=$date?>"></input>
            <?php if(!empty($date_error)) { ?>
            <span class="error">* <?=$date_error?></span>
            <?php } ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="hidden" name="artistId" value="<?=$artistId?>">
                <input type="hidden" name="performanceId" value="<?=$performanceId?>">
                <input type="submit" value="Submit" style="width:100%"></input>
             </td>
        </tr>
    </table>
    </form>

<?php
}
else if($_GET['action'] == "deleteperformance") {
    is_moderator_or_die();

    if(!isset($_GET['id'])) {
        die("Must specify id for this action");
    }

    $performanceId = intval($_GET['id']);
    $ret = remove_performance($performanceId);

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
        $details = get_member_details($memberId, $member_info);
        
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
                $ret = add_member($joinDate, $leaveDate, $name);
            } else {
                $ret = update_member($memberId, $joinDate, $leaveDate, $name);
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
            <td>Join Date:</td>
            <td><input type="date" name="joinDate" style="width:100%" value="<?=$joinDate?>"></input>
            <?php if(!empty($joinDate_error)) { ?>
            <span class="error">* <?=$joinDate_error?></span>
            <?php } ?>
            </td>
        </tr>
        <tr>
            <td>Leave Date:</td>
            <td><input type="date" name="leaveDate" style="width:100%" value="<?=$leaveDate?>"></input>
            <?php if(!empty($leaveDate_error)) { ?>
            <span class="error">* <?=$leaveDate_error?></span>
            <?php } ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="hidden" name="artistId" value="<?=$artistId?>">
                <input type="hidden" name="memberId" value="<?=$memberId?>">
                <input type="submit" value="Submit" style="width:100%"></input>
             </td>
        </tr>
    </table>
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
