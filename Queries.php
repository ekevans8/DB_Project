<?php
include 'db.inc';

// Connect to MySQL DBMS
if (!($connection = @ mysql_connect($hostName, $username, $password)))
  showerror();

// Use the cars database
if (!mysql_select_db($databaseName, $connection))
  showerror();

function get_password_hash($password) {
    // Generate a bcrypt encrypted password hash.
    // This hash will always be 60 characters long.
    return password_hash($password, PASSWORD_BCRYPT);
}

function verify_password_hash($password, $hash) {
    // Verify a bcrypt hashed password.
    return password_verify($password, $hash);
}

function login_user($username, $password){
	$SQL = "SELECT * FROM user where username = '".$username."'";
    
    $result = mysql_query($SQL);    
    while($row = mysql_fetch_object($result)) {
        echo $row->password . "<br>";
        
        if(verify_password_hash($password, $row->password))
            return true;
    }
	
	return false;
}

function register_user($username, $email, $password, $firstName, $lastName, $age, $zipcode) {
    
	$SQL = "INSERT INTO user ('username', 'firstName', 'lastName', 'age', 'email', 'password', 'zipcode', 'isModerator') VALUES 
	('".$username."', '".$firstName."', '".$lastName."', '".$age."', '".$email."', '".$password."', '".$zipcode."', '0');";
	
    return "Results: ";
}

function update_user($username, $email, $password, $firstName, $lastName, $age, $zipcode) {
 
	$SQL = "UPDATE user SET username = '".$username."', firstName = '".$firstName."', lastName = '".$lastName."', age = '".$age."'
	, email = '".$email."', password = '".$password."', zipcode = '".$zipcode."' where username = '".$username."';";
 
    return "Results: ";
}

function is_moderator($username){
	
	$SQL = "SELECT isModerator FROM user WHERE username = '".$username."'";
    
    $result = mysql_query($SQL);    
    while($row = mysql_fetch_object($result)) {        
        if($row->isModerator == 1)
            return true;
    }
    
    return false;
}

function get_profile($username){
	
	$SQL = "SELECT * FROM user WHERE username = '".$username."'";
    
    $result = mysql_query($SQL);
    while($row = mysql_fetch_object($result)) {
        return $row;
    }
    
	return null;
}

function make_moderator($username){
	$SQL = "UPDATE user SET isModerator = 1 where username = '".$username."'";
    $result = mysql_query($SQL);
    return $result;
}

function remove_moderator($username){
	$SQL = "UPDATE user SET isModerator = 0 where username = '".$username."'";
    $result = mysql_query($SQL);
    return $result;
}

function get_all_venues(){
	
	$SQL = "SELECT * FROM venue";
    
    $result = mysql_query($SQL);
    $results = array();
    while($row = mysql_fetch_array($result)) {
        $results[] = $row;
    }
	
	return $results;
}

function add_venue($venueName, $address, $city, $state, $zip){
	
	$SQL = "INSERT INTO venue ('name', 'streetAddress', 'city', 'state', 'zipcode') VALUES 
	('".$venueName."', '".$address."', '".$city."', '".$state."', '".$zip."');";
	
	return "Results: ";
}

function update_venue($venueName, $address, $city, $state, $zip){
	
	$SQL = "UPDATE venue SET name = '".$venueName."', streetAddress = '".$address."', city = '".$city."', 
	state = '".$state."', zipcode = '".$zip."' WHERE name = '".$venueName."';";
	
	return "Results: ";
}

function get_all_artist_info(){
	
	$SQL = "SELECT * FROM artist";
    
    $result = mysql_query($SQL);
    $results = array();
    while($row = mysql_fetch_array($result)) {
        $results[$row['artistId']] = $row;
    }
	
    return $results;
}

function add_artist($name, $formDate, $breakupDate, $formationZipcode){
	$SQL = "INSERT INTO artist (`name`, `formDate`, `breakupDate`, `formationZipcode`) VALUES 
	('".$name."', '".$formDate."', '".$breakupDate."', '".$formationZipcode."');";
    return mysql_query($SQL);
}

function update_artist($artistId ,$name, $formDate, $breakupDate, $formationZipcode){
	$SQL = "UPDATE artist SET name = '".$name."', formDate = '".$formDate."', formationZipcode = '".$formationZipcode."' 
	where artistId = '".$artistId."';";
    return mysql_query($SQL);
}

function remove_artist($artistId){
	
	$SQL = "delete from member where artistId = '".$artistId."';";
    mysql_query($SQL) or die(mysql_error());
    
    $SQL = "delete from comment where artistId = '".$artistId."';";
    mysql_query($SQL) or die(mysql_error());
	
    $SQL = "delete from artist where artistId = '".$artistId."';";
    return mysql_query($SQL) or die(mysql_error());
}

function add_member_to_artist($artistId, $joinDate, $leaveDate, $name){
	if($leaveDate == "") {
        $SQL = "INSERT INTO member (`artistId`, `joinDate`, `name`) 
        VALUES ('".$artistId."', '".$joinDate."', '".$name."');";
    } else {
        $SQL = "INSERT INTO member (`artistId`, `joinDate`, `leaveDate`, `name`) 
        VALUES ('".$artistId."', '".$joinDate."', '".$leaveDate."', '".$name."');";
    }
    
    return mysql_query($SQL) or die(mysql_error());
}

function get_members_for_artists(){
	
	$SQL = "select * from artistinfo;";
	
	return "Results: ";
}

function remove_member($memberId){
	
	$SQL = "Delete from member where memberId = '".$memberId."';";
    return mysql_query($SQL) or die(mysql_error());
}

function update_member($memberId, $artistId, $joinDate, $leaveDate, $name){
	if($leaveDate == "")
        $SQL = "UPDATE member SET artistId = '".$artistId."', joinDate = '".$joinDate."', name = '".$name."' WHERE memberId = '".$memberId."';";
    else
        $SQL = "UPDATE member SET artistId = '".$artistId."', joinDate = '".$joinDate."', leaveDate = '".$leaveDate."', name = '".$name."' WHERE memberId = '".$memberId."';";
	
    return mysql_query($SQL) or die(mysql_error());
}

function get_members($artistId){
	
	$SQL = "select * from member WHERE artistId = '" . $artistId . "';";
    
    $result = mysql_query($SQL);
    $results = array();
    while($row = mysql_fetch_array($result)) {
        $results[] = $row;
    }
	
	return $results;
}

function get_member_details($memberId){
	
	$SQL = "select * from member WHERE memberId = '" . $memberId . "';";
    
    $result = mysql_query($SQL);
    $results = array();
    while($row = mysql_fetch_array($result)) {
        return $row;
    }
	
	return null;
}

function add_favorite($username, $artistId){
	
	$SQL = "INSERT INTO favorite (`username`, `artistId`) VALUES ('".$username."', '".$artistId."');";
    $result = mysql_query($SQL);
}

function is_favorite($username, $artistId){
	
	$SQL = "SELECT * FROM favorite where username = '".$username."' AND artistId = '".$artistId."'";
	
    $result = mysql_query($SQL);
    while($row = mysql_fetch_array($result)) {
        if($row['artistId'] == $artistId)
            return true;
    }
    
    return false;
}

function remove_favorite($username, $artistId){
	
	$SQL = "delete from favorite where `username` = '".$username."' and `artistId` = '".$artistId."';";
	return mysql_query($SQL) or die(mysql_error());
}

function get_all_usernames_and_favorites(){
	
	$SQL = "select * from favoriteartistinfo;";
	
	return "Results: ";
}

function get_albums_per_artist($artistId){
	
	$SQL = "SELECT 
	alb.title,
    alb.albumId,
    alb.recordLabel,
    alb.releaseDate
    FROM
        album alb
            JOIN
        tracklist tl ON alb.albumId = tl.albumId
            JOIN
        song sg ON tl.songId = sg.songId
            JOIN
        artist art ON tl.artistId = art.artistId
        where art.artistId = '".$artistId."'
        group by alb.albumId;";
        
    $result = mysql_query($SQL);
    $results = array();
    while($row = mysql_fetch_array($result)) {
        $results[] = $row;
    }
	
	return $results;
}

function get_album_summary_per_albumId($albumId){
	
	$SQL = "select * from albumsummaries WHERE albumId = '".$albumId."' ORDER BY track_number;";
	
    $result = mysql_query($SQL);
    $results = array();
    while($row = mysql_fetch_array($result)) {
        $results[] = $row;
    }
	
	return $results;
}

function add_performance($duration, $venueId, $date, $title){
	
	$SQL = "INSERT INTO performance (duration, venueId, date, title) VALUES ('".$duration."', '".$venueId."', '".$date."', '".$title."');";
	
	return "Results: ";
	
}

function get_all_performances() {
    
	$SQL = "select * from performance";
    
    $result = mysql_query($SQL);
    $results = array();
    while($row = mysql_fetch_array($result)) {
        $results[] = $row;
    }
	
	return $results;
}

function get_all_performances_by_artist($artistId) {
    
	$SQL = "select * from performance p JOIN performance_playlist pl ON p.performanceId = pl.performanceId WHERE pl.artistId = '".$artistId."' GROUP BY pl.artistId";
    
    $result = mysql_query($SQL);
    $results = array();
    while($row = mysql_fetch_array($result)) {
        $results[] = $row;
    }
	
	return $results;
}

function get_performance_details($performanceId) {
    
	$SQL = "select * from performance WHERE performanceId = '".$performanceId . "'";
    
    $result = mysql_query($SQL);
    $results = array();
    while($row = mysql_fetch_array($result)) {
        return $row;
    }
	
	return null;
}

function get_performance_summary($performanceId) {
    
	$SQL = "select * from performancesummary WHERE performanceId = '".$performanceId . "'";
    
    $result = mysql_query($SQL);
    $results = array();
    while($row = mysql_fetch_array($result)) {
        $results[] = $row;
    }
	
	return $results;
}

function update_performance($performanceId, $duration, $venueId, $date){
	
	$SQL = "UPDATE performance SET duration = '".$duration."', venueId = '".$venueId."', date = '".$date."' where performanceId = '".$performanceId."';";
	
	return "Results: ";
	
}

function remove_performance($performanceId){
	
	$SQL = "DELETE FROM comment where performanceId = '".$performanceId."';
	DELETE FROM attended_performance where performanceId = '".$performanceId."';
	DELETE FROM performance_playlist where performanceId = '".$performanceId."';
	DELETE FROM performance where performanceId = '".$performanceId."';";
	
	return "Results: ";
	
}

function add_song_played_to_performance($performanceId, $songId, $artistId){
	$SQL = "INSERT INTO performance_playlist (performanceId, songId, artistId) VALUES ('".$performanceId."', '".$songId."', '".$artistId."');";
	
	return "Results: ";
	
}

function get_all_usernames_and_favorites_per_favorite($username){
	
	$SQL = "select * from favoriteartistinfo WHERE username = '".$username."';";
    
    $result = mysql_query($SQL);
    $results = array();
    while($row = mysql_fetch_array($result)) {
        $results[] = $row;
    }
	
	return $results;
}

function get_all_favorites_per_artist($artistId){
	
	$SQL = "select * from favoriteartistinfo WHERE artistId = '".$artistId."';";
    
    $result = mysql_query($SQL);
    $results = array();
    while($row = mysql_fetch_array($result)) {
        $results[] = $row;
    }
	
	return $results;
}

function get_albums(){
	
	$SQL = "select * from album;";
    
    $result = mysql_query($SQL);
    $results = array();
    while($row = mysql_fetch_array($result)) {
        $results[] = $row;
    }
	
	return $results;
}

function add_album($albumTitle, $recordLabel, $releaseDate){
	
	$SQL = "INSERT INTO album (`title`, `recordLabel`, `releaseDate`) VALUES ('".$albumTitle."', '".$recordLabel."', '".$releaseDate."');";
	
	return mysql_query($SQL) or die(mysql_error());
	
}
function remove_album($albumId){
	
	$SQL = "DELETE FROM tracklist where albumId = '".$albumId."';
	DELETE FROM album where albumId = '".$albumId."';";
	
	return mysql_query($SQL) or die(mysql_error());
	
}
function update_album($albumId, $albumTitle, $recordLabel, $releaseDate){
	
	$SQL = "UPDATE album SET title = '".$albumTitle."', recordLabel = '".$recordLabel."', releaseDate = '".$releaseDate."' 
	where albumId = '".$albumId."';";
	
	return mysql_query($SQL) or die(mysql_error());
	
}
function add_song($songTitle, $duration){
    
	$SQL = "INSERT INTO song (title, duration) VALUES ('".$songTitle."', '".$duration."');";
	mysql_query($SQL) or die(mysql_error());
    
	return mysql_insert_id();
	
}
function get_song($songId){
	
	$SQL = "SELECT * FROM song WHERE songId = '" . $songId . "'";
    
    $result = mysql_query($SQL);
    while($row = mysql_fetch_array($result)) {
        return $row;
    }
    
	return null;
	
}

function update_song($songId, $songTitle, $duration, $trackNumber){
	
	$SQL = "UPDATE song SET title = '".$songTitle."', duration = '".$duration."', track_number = '".$trackNumber."' 
	where songId = '".$songId."';";
	
	return mysql_query($SQL) or die(mysql_error());
	
}
function remove_song($songId){
	
	$SQL = "DELETE FROM tracklist where songId = '".$songId."';";
	return mysql_query($SQL) or die(mysql_error());
	
}
function link_song_to_album_and_artist($songId, $albumId, $artistId, $trackNumber){
	
	$SQL = "INSERT INTO tracklist (albumId, songId, artistId, track_number) VALUES ('".$albumId."', '".$songId."', '".$artistId."', '".$trackNumber."');";
	
	return mysql_query($SQL) or die(mysql_error());
	
}
function unlink_song_to_album_and_artist($songId, $albumId, $artistId){
	
	$SQL = "DELETE FROM tracklist WHERE songId = ".$songId."' AND albumId = '".$albumId."' AND artistId = '".$artistId."');";
	
	return mysql_query($SQL) or die(mysql_error());
	
}
function get_all_album_summaries(){
	
	$SQL = "select * from albumsummaries;";
	
	return "Results: ";
}

function remove_song_played_to_performance($performanceId, $songId, $artistId){
	
	$SQL = "DELETE FROM performance_playlist where performanceId = '".$performanceId."' AND songId = '".$songId."' AND artistId = '".$artistId."';";
	
	return mysql_query($SQL) or die(mysql_error());	
}

function add_attended_performance($username, $performanceId){
	
	$SQL = "INSERT INTO attended_performance (username, performanceId) VALUES ('".$username."', '".$performanceId."');";
	
	return mysql_query($SQL) or die(mysql_error());
	
}

function remove_atteneded_performance($username, $performanceId){
	
	$SQL = "DELETE FROM attended_performance where performanceId = '".$performanceId."' AND username = '".$username."';";
	
	return mysql_query($SQL) or die(mysql_error());
	
}

function attended_concert_by_id($username, $performanceId){
	
	$SQL = "SELECT * FROM attended_performance WHERE username = '" . $username . "' and performanceId = '" . $performanceId . "'";
    
    $result = mysql_query($SQL);
    while($row = mysql_fetch_array($result)) {
        return true;
    }
    
	return false;
	
}

function get_Attended_performances_per_username($username){
	
	$SQL = "select ap.username, ps.* from attended_performance ap
			join performance ps on ap.performanceId = ps.performanceId
			where ap.username = '".$username."';";
	
    $result = mysql_query($SQL);
    $results = array();
    while($row = mysql_fetch_array($result)) {
        $results[] = $row;
    }
	
	return $results;
}

function add_comment_for_artist($username, $artistId, $comment, $postDate){
	
	$SQL = "INSERT INTO comment (username, artistId, comment, postDate) VALUES ('".$username."', '".$artistId."', '".$comment."', '".$postDate."');";
	
	return mysql_query($SQL) or die(mysql_error());	
	
}

function add_comment_for_performance($username, $performanceId, $comment, $postDate){
	
	$SQL = "INSERT INTO comment (username, performanceId, comment, postDate) VALUES ('".$username."', '".$performanceId."', '".$comment."', '".$postDate."');";
    
	return mysql_query($SQL) or die(mysql_error());	
		
}

function remove_comment($commentId){
	
	$SQL = "DELETE FROM comment WHERE commentId = '".$commentId."';";
	
	return mysql_query($SQL) or die(mysql_error());	
	
}

function update_comment($commentId, $artistId, $performanceId, $comment){
	$artistIdStr = "artistId = '".$artistId."', ";
	$performanceIdStr = "performanceId = '".$performanceId."', ";
    
    if($artistId == -1)
        $artistIdStr = "";
    
    if($performanceId == -1)
        $performanceIdStr = "";
    
	$SQL = "UPDATE comment SET " . $artistIdStr . $performanceIdStr . " comment = '".$comment."' where commentId = '".$commentId."';";
	
	return mysql_query($SQL) or die(mysql_error());	
	
}

function get_comment_by_id($commentId) {
    
	$SQL = "SELECT * FROM comment WHERE commentId = '" . $commentId . "'";
    
    $result = mysql_query($SQL);
    while($row = mysql_fetch_array($result)) {
        return $row;
    }
    
	return null;
}

function get_comments_by_username($username) {
    
	$SQL = "SELECT * FROM comment WHERE username = '" . $username . "'";
    
    $result = mysql_query($SQL);
    $results = array();
    while($row = mysql_fetch_array($result)) {
        $results[] = $row;
    }
	
	return $results;
}

function get_comments_by_artist($artistId) {
    
	$SQL = "SELECT * FROM comment WHERE artistId = '" . $artistId . "'";
    
    $result = mysql_query($SQL);
    $results = array();
    while($row = mysql_fetch_array($result)) {
        $results[] = $row;
    }
	
	return $results;
}

function get_comments_by_performance($performanceId) {
    
	$SQL = "SELECT * FROM comment WHERE performanceId = '" . $performanceId . "'";
    
    $result = mysql_query($SQL);
    $results = array();
    while($row = mysql_fetch_array($result)) {
        $results[] = $row;
    }
	
	return $results;
}

function get_venue_by_id($venueId) {
    
	$SQL = "SELECT * FROM venue WHERE venueId = '" . $venueId . "'";
    
    $result = mysql_query($SQL);
    while($row = mysql_fetch_array($result)) {
        return $row;
    }
    
	return null;
}

?>