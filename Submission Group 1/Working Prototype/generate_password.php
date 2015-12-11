<?php

function get_password_hash($password) {
    // Generate a bcrypt encrypted password hash.
    // This hash will always be 60 characters long.
    return password_hash($password, PASSWORD_BCRYPT);
}

function verify_password_hash($password, $hash) {
    // Verify a bcrypt hashed password.
    return password_verify($password, $hash);
}

$password = "";
if(isset($_GET['password'])) {
    $password = $_GET['password'];
}

$hash = get_password_hash($password);
$hash_verified = verify_password_hash($password, $hash);

echo "Password: " . $password . "<br>";
echo "Password hash: " . $hash . "<br>";
echo "Hash verified: " . ($hash_verified ? "True" : "False");

?>