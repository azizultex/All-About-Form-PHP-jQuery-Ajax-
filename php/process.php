<?php

// Object oriented type connection 

// useful variables 
$servername = "localhost";
$username = "root";
$dbname = "phpform";
$tbname = "my_table";

// connection 
$conn = new mysqli( $servername, $username);

// Check connection
if (mysqli_connect_error()) {
    die("Connection failed: " . mysqli_connect_error());
}

// create database if not exists 
$db = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($db) === FALSE) {
	echo "Error in creating database: <br /><br />". $conn->error;
}

// change database selection 
mysqli_select_db($conn, $dbname);
				
// create dabase if not exists 
$tb = "CREATE TABLE IF NOT EXISTS $tbname (
		Serial INT NOT NULL AUTO_INCREMENT,
		PRIMARY KEY(Serial),
		UserName CHAR(30),
		UserPass CHAR(30),
		UserEmail CHAR(255),
		UserBio CHAR(255),
		UserJob CHAR(255),
		reg_date TIMESTAMP
		)";
		
if ($conn->query($tb)=== FALSE ) {
	echo "Error in creating table: <br /><br />". $conn->error;
}

// collectiong data 
function filter($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// data filter 
$user_name = $user_email = $user_password = $user_bio = $user_job = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$user_name = filter($_POST['user_name']);
	$user_email = filter($_POST['user_email']);
	$user_password = filter($_POST['user_password']);
	$user_bio = filter($_POST['user_bio']);
	$user_job = filter($_POST['user_job']);
}

$insert_data = "INSERT INTO $tbname (UserName, UserPass, UserEmail, UserBio, UserJob)
VALUES ('$user_name', '$user_email', '$user_password', '$user_bio', '$user_job')";

if ($conn->query($insert_data)=== TRUE ) {
	echo "You have successfully registered!";
} else {
	echo "Sorry! Error in registration : " . $conn->error;
}

$conn->close();