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
  <?php
    echo "Program:<br>";
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
    //create the SQL select statement to query program information
    $sqlProgram = "SELECT program_id,program_code FROM PROGRAM_TBL;";
  
    //put the resultset into a variable
    $resultProgram = $conn->query($sqlProgram);
  
    //if there were no records found say so, otherwise create a while loop that loops through all rows
    //and echos each line to the screen.
    echo '<select name = "program_id">';
    if ($resultProgram->num_rows > 0){
      //add rows
      while($row = $resultProgram->fetch_assoc()){
        echo "<option value = \"" . $row["program_id"]. "\">" .$row["program_code"]. "</option>";
      }
    } else {
      echo "<option value = \"NULL\"> No Records Found";
    }
    echo "</select>";

    echo "<br><br>";
    echo "Term:<br>";

    //create the SQL select statement to query program information
    $sqlTerm = "SELECT term_id,season FROM TERM_TBL;";
  
    //put the resultset into a variable
    $resultTerm = $conn->query($sqlTerm);
  
    //if there were no records found say so, otherwise create a while loop that loops through all rows
    //and echos each line to the screen.
    echo '<select name = "term_id">';
    if ($resultTerm->num_rows > 0){
      //add rows
      while($row = $resultTerm->fetch_assoc()){
        echo "<option value = \"" . $row["term_id"]. "\">" .$row["season"]. "</option>";
      }
    } else {
      echo "<option value = \"NULL\"> No Records Found";
    }
    echo "</select>";

    //close the DB connection
    $conn->close();
  ?>
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
