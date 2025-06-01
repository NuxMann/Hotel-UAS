<?php

$SERVER_NAME = "localhost"; //NAME SERVER 
$USER_ID = "root"; //NAME USER
$PASSWORD = "root"; //PASSWORD
$DATABASE_NAME = "db_master_hotel";

$connection = mysqli_connect($SERVER_NAME, $USER_ID, $PASSWORD, $DATABASE_NAME);

if(!$connection) {
    echo "Not Found 404";
}


?>