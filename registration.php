<!DOCTYPE html>
<html>
 <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sign Up Form</title>
        <link href='http://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
	<?php
		// Object oriented type db connection 

		// useful variables 
		$servername = "localhost";
		$username = "root";
		$dbname = "phpform";
		$tbname = "my_table";

		$message = '';
		
		// connection 
		$conn = new mysqli( $servername, $username);

		// Check connection
		if (mysqli_connect_error()) {
			die("Connection failed: " . mysqli_connect_error());
		}

		// create database if not exists 
		$db = "CREATE DATABASE IF NOT EXISTS $dbname";
		if ($conn->query($db) === FALSE) {
			$message = "Error in creating database: <br /><br />". $conn->error;
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
			$message = "Error in creating table: <br /><br />". $conn->error;
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
			$message = "You have successfully registered!";
		} else {
			$message = "Sorry! Error in registration : " . $conn->error;
		}

		$conn->close();
	?>

      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <h1>Sign Up</h1>
        <fieldset>
          <legend><span class="number">1</span>Your basic info</legend>
          <label for="name">Name:</label>
          <input type="text" id="name" name="user_name">
          
          <label for="mail">Email:</label>
          <input type="email" id="mail" name="user_email">
          
          <label for="password">Password:</label>
          <input type="password" id="password" name="user_password">
          
          <label>Age:</label>
          <input type="radio" id="under_13" value="under_13" name="user_age"><label for="under_13" class="light">Under 13</label><br>
          <input type="radio" id="over_13" value="over_13" name="user_age"><label for="over_13" class="light">13 or older</label>
        </fieldset>
        
        <fieldset>
          <legend><span class="number">2</span>Your profile</legend>
          <label for="bio">Biography:</label>
          <textarea id="bio" name="user_bio"></textarea>
        </fieldset>
        <fieldset>
        <label for="job">Job Role:</label>
        <select id="job" name="user_job">
          <optgroup label="Web">
            <option value="frontend_developer">Front-End Developer</option>
            <option value="php_developor">PHP Developer</option>
            <option value="python_developer">Python Developer</option>
            <option value="rails_developer"> Rails Developer</option>
            <option value="web_designer">Web Designer</option>
            <option value="WordPress_developer">WordPress Developer</option>
          </optgroup>
          <optgroup label="Mobile">
            <option value="Android_developer">Androild Developer</option>
            <option value="iOS_developer">iOS Developer</option>
            <option value="mobile_designer">Mobile Designer</option>
          </optgroup>
          <optgroup label="Business">
            <option value="business_owner">Business Owner</option>
            <option value="freelancer">Freelancer</option>
          </optgroup>
          <optgroup label="Other">
            <option value="secretary">Secretary</option>
            <option value="maintenance">Maintenance</option>
          </optgroup>
        </select>
        
          <label>Interests:</label>
          <input type="checkbox" id="development" value="interest_development" name="user_interest"><label class="light" for="development">Development</label><br>
          <input type="checkbox" id="design" value="interest_design" name="user_interest"><label class="light" for="design">Design</label><br>
          <input type="checkbox" id="business" value="interest_business" name="user_interest"><label class="light" for="business">Business</label>
        
        </fieldset>
        <button type="submit">Sign Up</button>
		<p><?php echo $message; ?></p>
      </form>

    </body>
</html>