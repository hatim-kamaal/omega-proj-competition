<?php
//Database credentials
$dbHost = '208.91.198.197:3306';
$dbUsername = 'championship';
$dbPassword = 'championship@123';
$dbName = 'Championship';
//Connect with the database


$db=mysql_connect($dbHost,$dbUsername,$dbPassword);
mysql_select_db($dbName,$db);

?>