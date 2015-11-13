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
?>