<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Add Course</title>
<link rel="stylesheet" href="stylesheet.css">
</head>

<body>
	<h2>Add a Course Record</h2>
	<br><br>
	<?php
		echo "<h3>PHP Code Generates This:</h3>";
		
		//some variables
		$servername = "localhost";  //mysql is on the same host as apache (not realistic but whatevs)
		$username = "admin1234";    //username for database
		$password = "password1234";		//password for the user
		$dbname = "dunwoody_advising_schema";  	//which db you're going to use
	
		//this is the php object oriented style of creating a mysql connection
		$conn = new mysqli($servername, $username, $password, $dbname);  
	
		//check for connection success
		if ($conn->connect_error) {
			die("MySQL Connection Failed: " . $conn->connect_error);
		}
		echo "MySQL Connection Succeeded<br><br>";
		
		//pull the attribute that was passed with the html form GET request and put into a local variable.
		$course_id = $_GET["course_id"];
		$title = $_GET["title"];
		$code = $_GET["code"];
		$credits = $_GET["credits"];
		$description = $_GET["description"];
		$program_id = $_GET["program_id"];
		echo "Adding record for: " . $firstname . " " . $lastname;
	
		echo "<br><br>";
		
		//create the SQL insert statement, notice the funky string concat at the end to variablize the query
		//based on using the GET attribute
		//this statement needs to be variablized to put in the data passed from the form
		//right now it is hardcoded.
		//$sql = "INSERT INTO employees (emp_no, birth_date, first_name, last_name, gender, hire_date) VALUES
		//(" . $number . ", " . $birthdate . ", '" .  $firstname . "', '" .  $lastname . "', '" .  $gender . "', '" .  $hirehdate . "')";

		$sql2 = "INSERT INTO Course (program_id, title, credits) VALUES
		(" . $program_id . ",
		'" . $title . "',
		" .  $credits . ");";
	
		if ($conn->query($sql2) === TRUE){
			
			echo "New Program Created Successfully";
			
		} else {
		
			echo "Error: " . $sql2 . "<br>" . $conn->error;
			
		}
		echo "<br><br>";
		$sql = "INSERT INTO Course (course_id, course_program_id, code, description) VALUES
		(" . $course_id . ",
		" . $program_id . ",
		'" . $code . "',
		'" .  $description . "');";
	
		if ($conn->query($sql) === TRUE){
			
			echo "New Course Created Successfully";
			
		} else {
		
			echo "Error: " . $sql . "<br>" . $conn->error;
			
		}
		
		//always close the DB connections, don't leave 'em hanging
		$conn->close();
		
	?>
	<br><br><a href="index.html" title="Home Page" target="_parent">Return to Home</a>
</body>
</html>
