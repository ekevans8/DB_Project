<?php
include("header.php");
include("utils.php");

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

if($_GET['action'] == "addcomment" || $_GET['action'] == "editcomment") {
    if(!is_logged_in()) {
        die("You must be logged in to perform this action");
    }
    
    if(!isset($_GET['performanceId']) && !isset($_GET['artistId'])) {
        die("Must specify a performanceId or an artistId for this action");
    }

    $performanceId = -1;
    $artistId = -1;
    $commentId = -1;
    
    if(isset($_GET['performanceId'])) {
        $performanceId = intval($_GET['performanceId']);
    }
    
    if(isset($_GET['artistId'])) {
        $artistId = intval($_GET['artistId']);
    }
    
    $comment = "";

    if($_GET['action'] == "editcomment" && isset($_GET['commentId'])) {
        $commentId = intval($_GET['commentId']);    
        $details = get_comment_details($performanceId, $commentId, $performance_comments);
        
        $comment = $details['comment'];
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $comment = sanitize_input($_POST['comment']);
        
        $performanceId = intval($_POST['performanceId']);
        $artistId = intval($_POST['artistId']);
            
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
            <td><textarea></textarea></td>
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