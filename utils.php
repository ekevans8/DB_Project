<?php

function sanitize_input($input) {
    $output = $input;
    
    //$output = mysqli_real_escape_string($sql, $input);
    
    return $output;
}

function get_password_hash($password) {
    // Generate a bcrypt encrypted password hash.
    // This hash will always be 60 characters long.
    return password_hash($password, PASSWORD_BCRYPT);
}

function verify_password_hash($password, $hash) {
    // Verify a bcrypt hashed password.
    return password_verify($password, $hash);
}

function is_logged_in() {
    return true;
}

?>