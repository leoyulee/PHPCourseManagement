<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Add Course</title>
<link rel="stylesheet" href="stylesheet.css">
</head>

<body>
<h2>Add a Course Record</h2>
<p>This will add a record to the course table in the MySQL Database</p>
<p>Course "SENG-1234" is pre-populated as an example</p>
<!-- here is the start of the form -->
<form action="addcourseresult.php">
  <br><br>
  Program:<br>
    <?php
      //some variables
      $servername = "localhost";  //mysql is on the same host as apache (not realistic but whatevs)
      $username = "admin1234";    //username for database
      $password = "password1234";		//password for the user
      $dbname = "dunwoody_advising_schema";  	//which db you're going to use
    
      //this is the php object oriented style of creating a mysql connection
      $conn = new mysqli($servername, $username, $password, $dbname);  
    
      //check for connection success
      if ($conn->connect_error) {
        echo "MySQL Connection Failed";
        die("MySQL Connection Failed: " . $conn->connect_error);
      }
      //create the SQL select statement, notice the funky string concat at the end to variablize the query
      //based on using the GET attribute
      $sql = "SELECT program_id,program_code FROM PROGRAM_TBL;";
    
      //put the resultset into a variable, again object oriented way of doing things here
      $result = $conn->query($sql);
    
      //if there were no records found say so, otherwise create a while loop that loops through all rows
      //and echos each line to the screen. You do this by creating some crazy looking echo statements
      // in the form of HTMLText . row[column] . HTMLText . row[column].   etc...
      // the dot "." is PHP's string concatenator operator
      // here HTML Table tags are used to create a table and table rows.
     
      if ($result->num_rows > 0){
        //print rows
        echo '<select name = "program_id">';
        while($row = $result->fetch_assoc()){
          echo "<option value = \"" . $row["program_id"]. "\">" .$row["program_code"]. "</option>";
        }
        echo "</select>";
      } else {
        echo "<option value = 0> No Records Found";
      }
      // echo "</table>";
      //always close the DB connections, don't leave 'em hanging
      $conn->close();
      
    ?>
  <br><br>
  Term ID:<br>
  <input type="text" name="term_id" value="1">
  <br><br>
  Course Code:<br>
  <input type="text" name="code" value="1234">
  <br><br>
  Course Name:<br>
  <input type="text" name="name" value="Unnamed Course">
  <br><br>
  Course Description:<br>
  <input type="text" name="description" value="Placeholder Description">
  <br><br>
  Number of Credits:<br>
  <input type="text" name="credits" value="3">
  <br><br>
  Instruction Type:<br>
  <input type="text" name="instructiontype" value="Lab">
  <br><br>
  <input type="submit" value="Submit">
</form>
<br><br><a href="index.html" title="Home Page" target="_parent">Return to Home</a>
</body>
</html>
