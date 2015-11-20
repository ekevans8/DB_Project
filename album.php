<?php
include("header.php");
include("Queries.php");
include("utils.php");

if(!isset($_SESSION['username'])) {
    die();
}

if(!isset($_GET['action']) || $_GET['action'] == "list") {
    $albums = get_albums();
    
    foreach($albums as $album) {
        echo '<a href="album.php?action=details&id=' . $album['albumId'] .'">' . $album['title'] . '</a> (' . $album['releaseDate'] . ') from ' . $album['recordLabel'] . '<br>';
    }
    
    if(is_moderator($_SESSION['username']))
        echo '<br><a href="album.php?action=addalbum">Add album</a><br>';
}
else if($_GET['action'] == "details") {
    // Get detailed album information including tracklist
    $albumId = intval($_GET['id']);
    $songs = get_album_summary_per_albumId($albumId);
    
    if($songs != null) {        
        $total_duration = 0;
        $artist_name = $songs[0]['Artist_Name'];
        $same_artist = true;
        
        
        foreach($songs as $song) {
            if($song['Artist_Name'] != $artist_name) {
                $same_artist = false;
                break;
            }
        }
        
        echo '<b>' . $songs[0]['Album_Title'] . '</b><br>';
        
        if($same_artist) {
            echo $artist_name . "<br>";
        }
        
        echo "<br>";
        
        foreach($songs as $song) {
            if(!$same_artist)
                echo $song['track_number'] . ") " . $song['Artist_Name'] . ' - ' . $song['Song_Title'] . " (" . $song['duration'] . ")";
            else
                echo $song['track_number'] . ") " . $song['Song_Title'] . " (" . $song['duration'] . ")";
            
            if(is_moderator($_SESSION['username']))
                echo ' <a href="album.php?action=editsong&id='.$song['albumId'].'&songId='.$song['songId'].'">Edit song</a> | <a href="album.php?action=removesong&id='.$song['songId'].'">Remove song</a>';
            
            echo "<br>";
            
            $total_duration += $song['duration'];
        }
        
        echo "<br><b>Total length</b>: " . $total_duration . "<br>";
    }
    
    echo "<br>";
    
    if(is_moderator($_SESSION['username']))
        echo '<a href="album.php?action=addsong&id=' . $albumId . '">Add song</a><br>';
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
            
            if($albumId == -1) {
                $ret = add_album($title, $recordLabel, $releaseDate);
            } else {
                $ret = update_album($albumId, $title, $recordLabel, $releaseDate);
            }
            
            if(!$has_error) {
                // Get album id from return value(s)
                if($albumId != -1)
                    header('Location: album.php?action=details&id=' . $albumId, true);
                else
                    header('Location: artists.php', true);
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

    $artistId = -1;
    $artist_error = "";
    
    $title = "";
    $title_error = "";

    $duration = "";
    $duration_error = "";

    $track_number = "";
    $track_number_error = "";

    if($_GET['action'] == "editsong" && isset($_GET['songId'])) {
        $songId = intval($_GET['songId']);    
        $details = get_song($songId);
        
        $title = $details['title'];
        $duration = $details['duration'];
        $track_number = $details['track_number'];
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $artistId = intval($_POST['artistid']);
        $title = sanitize_input($_POST['title']);
        $duration = doubleval($_POST['duration']);
        $track_number = intval($_POST['track_number']);
        
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
                $songId = add_song($title, $duration, $track_number);
                $ret = link_song_to_album_and_artist($songId, $albumId, $artistId);
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
            <td>Artist:</td>
            <td>
                <select name="artistid">
                <?php
                    $artists = get_all_artist_info();
                    foreach($artists as $artist) {
                        echo '<option value="'.$artist['artistId'].'">'.$artist['name'].'</option>';
                    }
                ?>
                </select>
            </td>
            <?php if(!empty($track_number_error)) { ?>
            <span class="error">* <?=$artist_error?></span>
            <?php } ?>
            </td>
        </tr>
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
            <td><input type="number" step="any" name="duration" style="width:100%" value="<?=$duration?>"></input>
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
else if($_GET['action'] == "removesong") {
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