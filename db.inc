<?php
/*
* db.inc
* These are the DBMS credentials and the database name
*/
$hostName = "localhost:/usr/cslocal/mysqldata/triton.sock";
$databaseName = "mferna6db";
$username = "mferna6";
$password = "Cosc*ktyy";
// Show an error and stop the script
function showerror()
{
if (mysql_error())
die("Error " . mysql_errno() . " : " . mysql_error());
else
die ("Could not connect to the DBMS");
}
?>