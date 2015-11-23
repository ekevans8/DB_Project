<?php
include("header.php");
include("Queries.php");
include("utils.php");

if(!isset($_SESSION['username'])) {
    die();
}

if($_GET['action'] == "addcomment" || $_GET['action'] == "editcomment") {
    if(!is_logged_in()) {
        die("You must be logged in to perform this action");
    }

    $performanceId = -1;
    $artistId = -1;
    $commentId = -1;
    $comment = "";
    
    if(isset($_GET['performanceId']))
        $performanceId = intval($_GET['performanceId']);
    
    if(isset($_GET['artistId']))
        $artistId = intval($_GET['artistId']);

    if($_GET['action'] == "editcomment" && isset($_GET['commentId'])) {
        $commentId = intval($_GET['commentId']);    
        $details = get_comment_by_id($commentId);
        
        $comment = $details['comment'];
        
        $performanceId = $details['performanceId'] == null ? -1 : $details['performanceId'];
        $artistId = $details['artistId'] == null ? -1 : $details['artistId'];
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
            
            $postDate = date("Y-m-d");
            
            if($artistId != -1) {
                $redirect_page = "artists.php?action=details&id=" . $artistId;
            } else if($performanceId != -1) {
                $redirect_page = "performance.php?action=details&id=" . $performanceId;
            } else {
                $redirect_page = 'artists.php?action=list';
            }
            
            if($commentId == -1) {
                if($artistId != -1) {
                    $ret = add_comment_for_artist($_SESSION['username'], $artistId, $comment, $postDate);
                } else if($performanceId != -1) {
                    $ret = add_comment_for_performance($_SESSION['username'], $performanceId, $comment, $postDate);
                }
            } else {
                $ret = update_comment($commentId, $artistId, $performanceId, $comment);
            }
            
            if(!$has_error) {
                header('Location: ' . $redirect_page, true);
                die();
            }
        }
    }
?>
	<form action="" method="post" style="display: block;">
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon" id="basic-addon3">Comment</span>
				<textarea name="comment" id="comment" tabindex="1" class="form-control" placeholder="Comment Text"><?=$comment?></textarea>
			</div>
		</div>
		<input type="hidden" name="artistId" value="<?=$artistId?>">
		<input type="hidden" name="performanceId" value="<?=$performanceId?>">
		<input type="hidden" name="commentId" value="<?=$commentId?>">
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
else if($_GET['action'] == "deletecomment") {
    if(!isset($_GET['id'])) {
        die("Must specify id for this action");
    }

    $commentId = intval($_GET['id']);
    
    if(isset($_GET['artistId'])) {
        $artistId = intval($_GET['artistId']);
        $redirect_page = "artists.php?action=details&id=" . $artistId;
    } else if(isset($_GET['performanceId'])) {
        $performanceId = intval($_GET['performanceId']);
        $redirect_page = "performance.php?action=details&id=" . $performanceId;
    } else {
        $redirect_page = 'artists.php?action=list';
    }
    
    $ret = remove_comment($commentId);

    // Check error code on delete?
    header('Location: ' . $redirect_page, true);
}
?>