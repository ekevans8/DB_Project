<?php
include("header.php");
include("utils.php");

function make_performance($performanceId, $venueId, $duration, $date) {
    return array("performanceId" => $performanceId, "venueId" => $venueId, "duration" => $duration, "date" => $date);
}
$performances = array(make_performance(0, 0, 0, "2015-01-01"), make_performance(1, 0, 0, "2015-01-02"), make_performance(2, 0, 0, "2015-01-03"));

function make_comment($commentId, $username, $artistId, $performanceId, $comment, $postDate) {
    return array("commentId" => $commentId, "username" => $username, "artistId" => $artistId, "performanceId" => $performanceId, "comment" => $comment, "postDate" => $postDate);
}
$performance_comments = array(make_comment(0, "test", null, 1, "This is a test comment 1", "2015-01-01"),
make_comment(1, "test", null, 2, "This is a test comment 2", "2015-01-01"),
make_comment(2, "testi123", null, 1, "This is a test comment 3", "2015-01-01"),
make_comment(3, "test", null, 4, "This is a test comment 4", "2015-01-01"),
make_comment(4, "test", null, 1, "This is a test comment 5", "2015-01-01"),
make_comment(5, "test13", null, 0, "This is a test comment 6", "2015-01-01"),
make_comment(6, "test123", null, 1, "This is a test comment 7", "2015-01-01"),
make_comment(7, "test2qwasfd", null, 1, "This is a test comment 8", "2015-01-01"));

function get_performance_details($performanceId, $performances) {
    if(!array_key_exists($performanceId, $performances))
        return null;
    else
        return $performances[$performanceId];
}

function get_performance_comments($performanceId, $performance_comments) {
    $comments = array();
    
    foreach($performance_comments as $comment) {
        if($comment['performanceId'] == $performanceId) {
            array_push($comments, $comment);
        }
    }
    
    return $comments;
}

function add_attended_concert($performanceId) {
    return true;
}

function remove_attended_concert($performanceId) {
    return true;
}

$venue_info = null;
function get_venue_details($venueId, $venue_info) {
    return null;
}


function add_venue($name, $streetAddress, $city, $state, $zipcode) {
    return true;
}

function update_venue($venueId, $name, $streetAddress, $city, $state, $zipcode) {
    return true; 
}

function remove_venue($venueId) {
    return true;
}



if(!isset($_GET['action'])) {
    die("An action must be specified");
}
else if($_GET['action'] == "details") {
    if(!isset($_GET['id'])) {
        die("Must specify id for this action");
    }

    $performanceId = intval($_GET['id']);
    
    $details = get_performance_details($performanceId, $performances);
    $comments = get_performance_comments($performanceId, $performance_comments);
?>

    <b>Venue</b>: <?=$details['venueId']?><br>
    <b>Date</b>: <?=$details['date']?><br>
    <br>
    Did you attend this performance? <a href="performance.php?action=addattended&id=<?=$performanceId?>">Yes</a> / <a href="performance.php?action=removeattended&id=<?=$performanceId?>">No</a>
    <br>
    <br>
    <b>Comments</b><br>
<?php
    foreach($comments as $comment) {
?>
        Username: <?=$comment['username']?><br>
        Date: <?=$comment['postDate']?><br>
        Comment: <?=$comment['comment']?><br>
        (<a href="comment.php?action=editcomment&id=<?=$performanceId?>&commentId=<?=$comment['commentId']?>">Edit</a> | <a href="comment.php?action=deletecomment&performanceId=<?=$performanceId?>&id=<?=$comment['commentId']?>">Delete</a>)<br>
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
    
    $ret = add_attended_concert($performanceId);
    
    header('Location: performance.php?action=details&id=' . $performanceId, true);
}
else if($_GET['action'] == "removeattended") {
    if(!isset($_GET['id'])) {
        die("Must specify id for this action");
    }

    $performanceId = intval($_GET['id']);
    
    $ret = remove_attended_concert($performanceId);
    
    header('Location: performance.php?action=details&id=' . $performanceId, true);
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
}
?>