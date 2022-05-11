<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Delete Course</title>
<link rel="stylesheet" href="stylesheet.css">
</head>

<body>
	<h2>Delete a Course Record</h2>
	<hr>
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
		$emp_no = $_GET["emp_id"];
		echo "Searching for: " . $emp_no;
	
		echo "<br><br>";
		
		//create the SQL select statement, notice the funky string concat at the end to variablize the query
		//based on using the GET attribute
		$sql = "DELETE FROM Course where emp_no = ".$emp_no."";
	
		//put the resultset into a variable, again object oriented way of doing things here
		$result = $conn->query($sql);
	
		//if there were no records found say so, otherwise create a while loop that loops through all rows
		//and echos each line to the screen. You do this by creating some crazy looking echo statements
		// in the form of HTMLText . row[column] . HTMLText . row[column].   etc...
		// the dot "." is PHP's string concatenator operator
		// here HTML Table tags are used to create a table and table rows.
		echo "<br><br>";
		if ($result == true){
			//print rows
			echo "<strong>Course Deleted Successfully</strong><br>";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		//always close the DB connections, don't leave 'em hanging
		$conn->close();
		
	?>
	<br><br><a href="index.html" title="Home Page" target="_parent">Return to Home</a>
</body>
</html>
