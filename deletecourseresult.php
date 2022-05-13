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
		
		$SplitURI = explode('?', $_SERVER['REQUEST_URI']); //Returns "/PHPCourseManagement/managecourses.php","course_delete=1&course_delete=2&course_delete=3" where the ? is the divider
		$FormInfo = $SplitURI[1]; //The variables we want
		foreach (explode('&', $FormInfo) as $chunk) //for each variable pair given from splitting the variables connected by a & do
		{
			$param = explode("=", $chunk); //[0] being the name, [1] being the value. Akin to $_GET[0] = [1]
			$VarName = $param[0];
			$VarValue = $param[1];
			if ($VarName == 'course_delete') {
				echo "Deleting: " . $VarValue;
				echo "<br><br>";
				//create the SQL select statement, notice the funky string concat at the end to variablize the query
				//based on using the GET attribute
				$sql = "DELETE FROM Course where course_id = ".$VarValue.";";
				//put the resultset into a variable, again object oriented way of doing things here
				$result = $conn->query($sql);
				//if there were no records found say so, otherwise create a while loop that loops through all rows
				//and echos each line to the screen. You do this by creating some crazy looking echo statements
				// in the form of HTMLText . row[column] . HTMLText . row[column].   etc...
				// the dot "." is PHP's string concatenator operator
				// here HTML Table tags are used to create a table and table rows.
				if ($result == true){
					//print rows
					echo "<strong>Course with ID of ".$VarValue." Deleted Successfully</strong><br>";
				} else {
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
			}
		}
		$conn->close();
	?>
	<br><br><a href="index.html" title="Home Page" target="_parent">Return to Home</a>
</body>
</html>
