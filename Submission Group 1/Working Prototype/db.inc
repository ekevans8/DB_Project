<?php
/*
* db.inc
* These are the DBMS credentials and the database name
*/
$hostName = "localhost:3306";
$databaseName = "musictracker";
$username = "root";
$password = "";
// Show an error and stop the script
function showerror()
{
if (mysql_error())
die("Error " . mysql_errno() . " : " . mysql_error());
else
die ("Could not connect to the DBMS");
}
?>