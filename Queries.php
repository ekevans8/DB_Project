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
	
	return "Results: ";
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
	
	return "Results: ";
}

function add_artist($name, $formDate, $breakupDate, $formationZipcode){
	$SQL = "INSERT INTO artist ('name', 'formDate', 'breakupDate', 'formationZipcode') VALUES 
	('".$name."', '".$formDate."', '".$breakupDate."', '".$formationZipcode."');";
	
	return "Results: ";
}

function update_artist($artistId ,$name, $formDate, $breakupDate, $formationZipcode){
	$SQL = "UPDATE artist SET name = '".$name."', formDate = '".$formDate."', formationZipcode = '".$formationZipcode."' 
	where artistId = '".$artistId."';";
	
	return "Results: ";
}

function remove_artist($artistId){
	
	$SQL = "delete from tracklist where artistId = '".$artistId."';
	delete from member where artistId = '".$artistId."';
	delete from artist where artistId = '".$artistId."';";
	
	return "Results: ";
}

function add_member_to_artist($artistId, $joinDate, $leaveDate, $name){
	
	$SQL = "INSERT INTO member ('artistId', 'joinDate', 'leaveDate', 'name') 
	VALUES ('".$artistId."', '".$joinDate."', '".$leaveDate."', '".$name."');";
	
	return "Results: ";
}

function get_members_for_artists(){
	
	$SQL = "select * from artistinfo;";
	
	return "Results: ";
}

function add_favorite($username, $artistId){
	
	$SQL = "INSERT INTO favorite ('username', 'artistId') VALUES ('".$username."', '".$artistId."');";
	
	return "Results: ";
}

function is_favorite($username, $artistId){
	
	$SQL = "SELECT * FROM favorite where username = '".$username."' AND artistId = '".$artistId."'";
	
	return "Results: ";
}

function remove_favorate($username, $artistId){
	
	$SQL = "delete from favorite where username = '".$username."' and artistId = '".$artistId."';";
	
	return "Results: ";
}

function get_all_usernames_and_favorites(){
	
	$SQL = "select * from favoriteartistinfo;";
	
	return "Results: ";
}

function add_album($albumTitle, $recordLabel, $releaseDate){
	
	$SQL = "INSERT INTO album (title, recordLabel, releaseDate) VALUES ('".$albumTitle."', '".$recordLabel."', '".$releaseDate."');";
	
	return "Results: ";
	
}

function remove_album($albumId){
	
	$SQL = "DELETE FROM tracklist where albumId = '".$albumId."';
	DELETE FROM album where albumId = '".$albumId."';";
	
	return "Results: ";
	
}

function update_album($albumId, $albumTitle, $recordLabel, $releaseDate){
	
	$SQL = "UPDATE album SET title = '".$albumTitle."', recordLabel = '".$recordLabel."', releaseDate = '".$releaseDate."' 
	where albumId = '".$albumId."';";
	
	return "Results: ";
	
}

function add_song($songTitle, $duration, $trackNumber){
	
	$SQL = "INSERT INTO song (title, duration, track_number) VALUES ('".$songTitle."', '".$duration."', '".$trackNumber."');";
	
	return "Results: ";
	
}

function update_song($songId, $songTitle, $duration, $trackNumber){
	
	$SQL = "UPDATE song SET title = '".$songTitle."', duration = '".$duration."', track_number = '".$trackNumber."' 
	where songId = '".$songId."';";
	
	return "Results: ";
	
}

function remove_song($songId){
	
	$SQL = "DELETE FROM tracklist where songId = '".$songId."';
	DELETE FROM album where songId = '".$songId."';";
	
	return "Results: ";
	
}

function link_song_to_album_and_artist($songId, $albumId, $artistId){
	
	$SQL = "INSERT INTO tracklist (albumId, songId, artistId) VALUES ('".$songId."', '".$albumId."', '".$artistId."');";
	
	return "Results: ";
	
}

function unlink_song_to_album_and_artist($songId, $albumId, $artistId){
	
	$SQL = "DELETE FROM tracklist WHERE songId = ".$songId."' AND albumId = '".$albumId."' AND artistId = '".$artistId."');";
	
	return "Results: ";
	
}

function get_all_album_summaries(){
	
	$SQL = "select * from albumsummaries;";
	
	return "Results: ";
}

?>