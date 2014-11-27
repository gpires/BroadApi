<?php
// Database params
$db_host = "";
$db_username = "";
$db_password = "";
$db_name = "";

// Create connection
$con = mysqli_connect($db_host, $db_username, $db_password,$db_name)or die('Error: Could not connect to database.');

// Check connection
if(mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	exit(0);
}

// Transmission
$transmission_url = "http://localhost:9091/transmission/rpc";
$transmission_user = "transmission";
$transmission_pass = "";

// Broadcasthenet API key
$btn_api_url = "http://api.btnapps.net/";
$btn_api_key = "";
$btn_results = 25;

// PushBullet API key
$pushb_api_active = FALSE; // Change to TRUE if you want to activate
$pushb_api_key = "";
$pushb_channel = "#broadapi";

?> 