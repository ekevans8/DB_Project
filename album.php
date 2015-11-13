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

function add_song($title, $duration, $track_number) {
    return true;
}
    
function update_song($songId, $title, $duration, $track_number) {
    return true;
}

function remove_song($songId) {
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

    $track_number = "";
    $track_number_error = "";

    if($_GET['action'] == "editsong" && isset($_GET['songId'])) {
        $songId = intval($_GET['songId']);    
        $details = get_song_details($songId, $song_info);
        
        $title = $details['title'];
        $duration = $details['duration'];
        $track_number = $details['track_number'];
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = sanitize_input($_POST['title']);
        $duration = sanitize_input($_POST['duration']);
        $track_number = sanitize_input($_POST['track_number']);
        
        $albumId = intval($_POST['albumId']);
            
        if(isset($_POST['songId'])) {
            $songId = intval($_POST['songId']);
        }
        
        $has_error = false;
        if(empty($title)) {
            $title_error = "Title cannot be empty";
            $has_error = true;
        }
        
        if(empty($duration)) {
            $duration_error = "Duration cannot be empty";
            $has_error = true;
        }
        
        if(!$has_error) {
            // Successful
            
            if($songId == -1) {
                $ret = add_song($title, $duration, $track_number);
            } else {
                $ret = update_song($songId, $title, $duration, $track_number);
            }
            
            if(!$has_error) {
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
            <td>Duration:</td>
            <td><input type="text" name="duration" style="width:100%" value="<?=$duration?>"></input>
            <?php if(!empty($duration_error)) { ?>
            <span class="error">* <?=$duration_error?></span>
            <?php } ?>
            </td>
        </tr>
        <tr>
            <td>Track Number:</td>
            <td><input type="number" name="track_number" min="0" style="width:100%" value="<?=$track_number?>"></input>
            <?php if(!empty($track_number_error)) { ?>
            <span class="error">* <?=$track_number_error?></span>
            <?php } ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="hidden" name="albumId" value="<?=$albumId?>">
                <input type="hidden" name="songId" value="<?=$songId?>">
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

    $songId = intval($_GET['id']);
    $ret = remove_song($songId);

    // Check error code on delete?
    header('Location: artists.php?action=list', true);
}
?>