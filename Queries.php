<?php

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



?>