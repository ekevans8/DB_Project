<?php

function sanitize_input($input) {
    $output = $input;
    
    //$output = mysqli_real_escape_string($sql, $input);
    
    return $output;
}

function is_logged_in() {
    return true;
}

function is_moderator_or_die() {
    if(!is_moderator($_SESSION['username'])) {
        die("Must be a moderator to access this part of the website");
    }
    
    return true;
}


?>