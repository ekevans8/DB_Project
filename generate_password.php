<?php

function get_password_hash($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

function verify_password_hash($password, $hash) {
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