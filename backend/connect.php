<?php

// Allow requests from any origin
header("Access-Control-Allow-Origin: *");

// Allow specific HTTP methods
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

// Allow specific HTTP headers
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, X-Requested-With, Authorization');

// Allow credentials (if needed)
header('Access-Control-Allow-Credentials: true');;



$servername = "localhost";
$database = "resume";
$username = "root";
$password = "";

// Create connection

$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection

if (!$conn) {

    die("Connection failed: " . mysqli_connect_error());

}

?>