<?php
include("header.php");
include("utils.php");

// Add, edit, remove album
// Add, edit, remove song
function add_album($title, $recordLabel, $releaseDate) {
    return true;
}

function update_album($albumId, $title, $recordLabel, $releaseDate) {
    return true;
}

function remove_album($albumId) {
    return true;
}


if(!isset($_GET['action'])) {
    die("An action must be specified");
}


else if($_GET['action'] == "details") {
    // Get detailed album information including tracklist
}
else if($_GET['action'] == "addalbum" || $_GET['action'] == "editalbum") {
    is_moderator_or_die();

    $albumId = -1;

    $title = "";
    $title_error = "";

    $recordLabel = "";
    $recordLabel_error = "";

    $releaseDate = "";
    $releaseDate_error = "";

    if($_GET['action'] == "editalbum" && isset($_GET['albumId'])) {
        $albumId = intval($_GET['albumId']);    
        $details = get_album_details($albumId, $album_info);
        
        $title = $details['title'];
        $recordLabel = $details['recordLabel'];
        $releaseDate = $details['releaseDate'];
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = sanitize_input($_POST['title']);
        $recordLabel = sanitize_input($_POST['recordLabel']);
        $releaseDate = sanitize_input($_POST['releaseDate']);
        
        if(isset($_POST['albumId'])) {
            $albumId = intval($_POST['albumId']);
        }
        
        $has_error = false;
        if(empty($title)) {
           $title_error = "Title cannot be blank";
           $has_error = true; 
        }
        
        if(empty($recordLabel)) {
           $recordLabel_error = "Record label cannot be blank";
           $has_error = true; 
        }
        
        if(empty($releaseDate)) {
           $releaseDate_error = "Release date cannot be blank";
           $has_error = true; 
        }
        
        if(!$has_error) {
            // Successful
            
            if($memberId == -1) {
                $ret = add_album($title, $recordLabel, $releaseDate);
            } else {
                $ret = update_album($albumId, $title, $recordLabel, $releaseDate);
            }
            
            if(!$has_error) {
                // Get album id from return value(s)
                header('Location: album.php?action=details&id=' . $albumId, true);
                die();
            }
        }
    }
    ?>

    <form action="" method="POST">
    <table>
        <tr>
            <td>Title:</td>
            <td><input type="text" name="title" style="width:100%" value="<?=$title?>"></input>
            <?php if(!empty($title_error)) { ?>
            <span class="error">* <?=$title_error?></span>
            <?php } ?>
            </td>
        </tr>
        <tr>
            <td>Record Label:</td>
            <td><input type="text" name="recordLabel" style="width:100%" value="<?=$recordLabel?>"></input>
            <?php if(!empty($recordLabel_error)) { ?>
            <span class="error">* <?=$recordLabel_error?></span>
            <?php } ?>
            </td>
        </tr>
        <tr>
            <td>Release Date:</td>
            <td><input type="date" name="releaseDate" style="width:100%" value="<?=$releaseDate?>"></input>
            <?php if(!empty($releaseDate_error)) { ?>
            <span class="error">* <?=$releaseDate_error?></span>
            <?php } ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="hidden" name="albumId" value="<?=$albumId?>">
                <input type="submit" value="Submit" style="width:100%"></input>
             </td>
        </tr>
    </table>
    </form>

<?php
}
else if($_GET['action'] == "deletealbum") {
    is_moderator_or_die();

    if(!isset($_GET['id'])) {
        die("Must specify id for this action");
    }

    $albumId = intval($_GET['id']);
    $ret = remove_album($albumId);

    // Check error code on delete?
    header('Location: artists.php?action=list', true);
}
else if($_GET['action'] == "addsong" || $_GET['action'] == "editsong") {
    is_moderator_or_die();

    if(!isset($_GET['id'])) {
        die("Must specify id for this action");
    }

    $albumId = intval($_GET['id']);
    $songId = -1;

    $title = "";
    $title_error = "";

    $duration = "";
    $duration_error = "";

    $name = "";
    $name_error = "";

    if($_GET['action'] == "editsong" && isset($_GET['songId'])) {
        $memberId = intval($_GET['songId']);    
        $details = get_song_details($songId, $song_info);
        
        $title = $details['title'];
        $duration = $details['duration'];
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