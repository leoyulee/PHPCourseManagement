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
		$program_id = $_GET["program_id"];
		$term_id = $_GET["term_id"];
		$code = $_GET["code"];
		$name = $_GET["name"];
		$description = $_GET["description"];
		$credits = $_GET["credits"];
		$instructiontype = $_GET["instructiontype"];

		$sql = "SELECT program_id,program_code FROM PROGRAM_TBL WHERE program_id = ".$program_id.";";
		$result = $conn->query($sql);
		$DebugOuput = "Adding course: [";
		if ($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$DebugOuput = $DebugOuput . $row["program_code"]."-";
			}
		}
		echo $DebugOuput.$code."] ".$name;
	
		echo "<br><br>";
		
		//create the SQL insert statement, notice the funky string concat at the end to variablize the query
		//based on using the GET attribute
		//this statement needs to be variablized to put in the data passed from the form
		//right now it is hardcoded.
		//$sql = "INSERT INTO employees (emp_no, birth_date, first_name, last_name, gender, hire_date) VALUES
		//(" . $number . ", " . $birthdate . ", '" .  $firstname . "', '" .  $lastname . "', '" .  $gender . "', '" .  $hirehdate . "')";

		$sql2 = "INSERT INTO COURSE_TBL(program_id, term_id, course_code, course_name, course_description, credits, instruction_type) VALUES
		(".$program_id.",
		".$term_id.",
		".$code.",
		'".$name."',
		'".$description."',
		".$credits.",
		'".$instructiontype."');";
	
		if ($conn->query($sql2) === TRUE){
			
			echo "New Course Created Successfully";
			
		} else {
		
			echo "Error: " . $sql2 . "<br>" . $conn->error;
			
		}
		
		//always close the DB connections, don't leave 'em hanging
		$conn->close();
		
	?>
	<br><br><a href="index.html" title="Home Page" target="_parent">Return to Home</a>
</body>
</html>
