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
		$program_id = $_GET["program_id"];
		$term_id = $_GET["term_id"];
		$code = $_GET["code"];
		$name = $_GET["name"];
		$description = $_GET["description"];
		$credits = $_GET["credits"];
		$instructiontype = $_GET["instructiontype"];
		echo "Updating record for: " . $name;
	
		echo "<br><br>";
		
		//create the SQL insert statement, notice the funky string concat at the end to variablize the query
		//based on using the GET attribute
		//this statement needs to be variablized to put in the data passed from the form
		//right now it is hardcoded.
		$sql = "UPDATE COURSE_TBL SET
		program_id = ".$program_id.",
		term_id = ".$term_id.",
		code = '".$code."',
		name = '".$name."',
		description = '".$description."',
		credits = ".$credits.",
		instruction_type = ".$instructiontype."
		WHERE course_id = ".$course_id.";";
	
	
		if ($conn->query($sql) === TRUE){
			
			echo "Course ".$number." Updated Successfully";
			echo "Values: program_id = ".$program_id.",
			term_id = ".$term_id.",
			code = '".$code."',
			name = '".$name."',
			description = '".$description."',
			credits = ".$credits.",
			instruction_type = ".$instructiontype;
			
		} else {
		
			echo "Error: " . $sql . "<br>" . $conn->error;
			
		}
		
		//always close the DB connections, don't leave 'em hanging
		$conn->close();
		
	?>
	<br><br><a href="index.html" title="Home Page" target="_parent">Return to Home</a>
</body>
</html>
