<?php
include("header.php");
include("Queries.php");
include("utils.php");

session_start();


if(!isset($_GET['action'])) {
    die("An action must be specified");
}


else if($_GET['action'] == "details") {
    // Get detailed album information including tracklist
}

?>