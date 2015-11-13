<?php
include("header.php");
include("utils.php");

function make_artist($artistid, $artistname, $dateformed, $datedisbanded, $zipcode) {
    return array("artistId" => $artistid, "name" => $artistname, "formDate" => $dateformed, "breakupDate" => $datedisbanded, "formationZipcode" => $zipcode);
}
$artists = array(make_artist(0, "Artist A", "2014-01-20", "2015-01-01", 20130), make_artist(1, "Artist B", "2014-02-20", "2015-02-01", 20131), make_artist(2, "Artist C", "2014-03-20", "", 20132));

function get_artist_details($artist_id, $artists) {
    if(!array_key_exists($artist_id, $artists))
        return null;
    else
        return $artists[$artist_id];
}



function make_release($albumid, $title, $recordlabel, $releasedate) {
    return array("albumId" => $albumid, "title" => $title, "recordLabel" => $recordlabel, "releaseDate" => $releasedate);
}

$artists_releases = array(array(make_release(0, "Album A", "Test", "1208103129"), make_release(1, "Album B", "Test", "1208103129"), make_release(2, "Album C", "Test", "1208103129")),
array(make_release(3, "Album A", "Test", "1208103129"), make_release(4, "Album B", "Test", "1208103129"), make_release(5, "Album C", "Test", "1208103129")),
array(make_release(6, "Album A", "Test", "1208103129"), make_release(7, "Album B", "Test", "1208103129"), make_release(8, "Album C", "Test", "1208103129")));

function is_moderator() {
    return true;
}

function is_moderator_or_die() {
    if(!is_moderator()) {
        die("Must be a moderator to access this part of the website");
    }
    
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

    if(is_moderator()) {
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
    
    //add_favorite($artist_id);
    
    echo "Artist added to favorites!";
}
else if($_GET['action'] == "removefavorite") {
    if(!isset($_GET['id'])) {
        die("Must specify id for this action");
    }
    
    $artist_id = intval($_GET['id']);
    
    //remove_favorite($artist_id);
    
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
Formation Zipcode: <?=$details['formationZipcode']?><br>
<br>
<a href="artists.php?action=addfavorite&id=<?=$details['artistId']?>">Add to favorites</a> | <a href="artists.php?action=removefavorite&id=<?=$details['artistId']?>">Remove from favorites</a>
<?php
if(is_moderator()) {
?>
| <a href="artists.php?action=deleteartist&id=<?=$details['artistId']?>">Delete artist</a>
<?php } ?>
<br>
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
<br>
Comments:<br>
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

$formationZipcode = 0;
$formationZipcode_error = "";

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
    $formationZipcode = $details['formationZipcode'];
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize_input($_POST['name']);
    $formDate = sanitize_input($_POST['formDate']);
    $breakupDate = sanitize_input($_POST['breakupDate']);
    $formationZipcode = sanitize_input($_POST['formationZipcode']);
    
    if(isset($_POST['artistId'])) {
        $artistId = intval($_POST['artistId']);
    }
    
    $has_error = false;
    if(empty($name)) {
        $name_error = "Artist name cannot be empty";
        $has_error = true;
    }
    
    if($formationZipcode <= 9999) {
        $formationZipcode_error = "Formation zipcode must be 5 digits";
        $has_error = true;
    }
    
    if(!$has_error) {
        // Successful
        
        if($artistId == -1) {
            //$ret = add_artist($name, $formDate, $breakupDate, $formationZipcode);
        } else {
            //$ret = update_artist($artistId, $name, $formDate, $breakupDate, $formationZipcode);
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
        <td><input type="number" name="formationZipcode" min="10000" max="99999" style="width:100%" value="<?=$formationZipcode?>"></input>
        <?php if(!empty($formationZipcode_error)) { ?>
        <span class="error">* <?=$formationZipcode_error?></span>
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
//$ret = remove_artist($artistId);

// Check error code on delete?
header('Location: artists.php?action=list', true);
}
?>

