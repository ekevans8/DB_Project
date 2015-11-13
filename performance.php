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

function get_comment_details($performanceId, $commentId, $performance_comments) {
    foreach($performance_comments as $comment) {
        if($comment['performanceId'] == $performanceId && $comment['commentId'] == $commentId) {
            return $comment;
        }
    }
    
    return null;
}

function add_comment($artistId, $performanceId, $comment) {
    // Automatically get username from the current session
    // Get the current date automatically
    return true;
}

function update_comment($commentId, $comment) {
    // Only modify the comment text body
    return true;
}

function remove_comment($commentId) {
    // Check that the user deleting the comment is the same as the user who posted the comment, or a moderator
    return true;
}




if($_GET['action'] == "details") {
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
    <b>Comments</b><br>
<?php
    foreach($comments as $comment) {
?>
        Username: <?=$comment['username']?><br>
        Date: <?=$comment['postDate']?><br>
        Comment: <?=$comment['comment']?><br>
        (<a href="performance.php?action=editcomment&id=<?=$performanceId?>&commentId=<?=$comment['commentId']?>">Edit</a> | <a href="performance.php?action=deletecomment&performanceId=<?=$performanceId?>&id=<?=$comment['commentId']?>">Delete</a>)<br>
        <br>
<?php
    }
?>

<?php
}
else if($_GET['action'] == "addcomment" || $_GET['action'] == "editcomment") {
    if(!is_logged_in()) {
        die("You must be logged in to perform this action");
    }
    
    if(!isset($_GET['id'])) {
        die("Must specify id for this action");
    }

    $performanceId = intval($_GET['id']);
    $artistId = -1;
    $commentId = -1;
    
    $comment = "";

    if($_GET['action'] == "editcomment" && isset($_GET['commentId'])) {
        $commentId = intval($_GET['commentId']);    
        $details = get_comment_details($performanceId, $commentId, $performance_comments);
        
        $comment = $details['comment'];
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $comment = sanitize_input($_POST['comment']);
        
        $performanceId = intval($_POST['performanceId']);
            
        if(isset($_POST['commentId'])) {
            $commentId = intval($_POST['commentId']);
        }
        
        $has_error = false;
        
        if(!$has_error) {
            // Successful
            
            if($commentId == -1) {
                $ret = add_comment($artistId, $performanceId, $comment);
            } else {
                $ret = update_comment($commentId, $comment);
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
            <td>Comment:</td>
            <td><input type="text" name="comment" style="width:100%" value="<?=$comment?>"></input></td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="hidden" name="artistId" value="<?=$artistId?>">
                <input type="hidden" name="performanceId" value="<?=$performanceId?>">
                <input type="hidden" name="commentId" value="<?=$commentId?>">
                <input type="submit" value="Submit" style="width:100%"></input>
             </td>
        </tr>
    </table>
    </form>

<?php
}
else if($_GET['action'] == "deletecomment") {
    if(!isset($_GET['id'])) {
        die("Must specify id for this action");
    }

    if(!isset($_GET['performanceId'])) {
        die("Must specify performanceId for this action");
    }

    $commentId = intval($_GET['id']);
    $performanceId = intval($_GET['performanceId']);
    
    $ret = remove_comment($commentId);

    // Check error code on delete?
    header('Location: performance.php?action=details&id=' . $performanceId, true);
}
?>