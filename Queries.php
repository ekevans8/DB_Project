<?php
include 'db.inc';
// Connect to MySQL DBMS
if (!($connection = @ mysql_connect($hostName, $username,
  $password)))
  showerror();
// Use the cars database
if (!mysql_select_db($databaseName, $connection))
  showerror();

function login_user($username, $password){
	
	$SQL = "SELECT * FROM user where username = '".$username."' AND password = '".$password."'";
	
	return "Results: ";
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
	
	$SQL = "SELECT isModerator FROM use WHERE username = '".$username."'";
	
	return "Results: ";
}

function get_profile($username){
	
	$SQL = "SELECT * FROM user WHERE username = '".$username."'";
	
	return "Results: ";
}

function make_moderator($username){
	
	$SQL = "UPDATE user SET isModerator = 1 where username = '".$username."'";
	
	return "Results: ";
}

function remove_moderator($username){
	
	$SQL = "UPDATE user SET isModerator = 0 where username = '".$username."'";
	
	return "Results: ";
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
	
	$SQL = "delete from member where artistId = '".$artistId."';
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



?>
?>