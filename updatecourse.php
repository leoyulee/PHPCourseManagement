<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Update Course</title>
<link rel="stylesheet" href="stylesheet.css">
</head>

<body>
<h2>Update a Course Record</h2>
<p>Find and Update course by Course ID</p>
<br>
<hr> <!-- This is the hr tag, or "horizonatal reference" -->
<br>
<p>This will search the courses table in the MySQL Database</p>
<p>The PHP Page will simply display the results of the query</p>
<p>Course "Weedman" is pre-populated as an example</p>
<form action="deletecourse.php">
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
  function createSelectFromResult($label,$result,$value_column,$display_column,$selected_value) {
    echo $label.":<br>";
    //if there were no records found say so, otherwise create a while loop that loops through all rows
    //and echos each line to the webpage.
    if ($result->num_rows > 0){
      echo '<select name = "'.$value_column.'">';
      //add rows
      while($row = $result->fetch_assoc()){
        $rowOutput = "<option value = \"" . $row[$value_column];
        if ($selected_program_id == $row[$value_column]) {
          $rowOutput = $rowOutput . " selected";
        }
        $rowOutput = $rowOutput . "\">" .$row[$display_column]. "</option>";
        echo $rowOutput;
      }
      echo "</select>";
    } else {
      echo "No Records Found";
    }
    echo "<br><br>";
  }
  function createForm($connection, $course_id, $selected_program_id, $selected_term_id, $course_code, $course_name, $course_description, $credits, $instruction_type) {
    echo 'Course ID:<br>
    <input type="text" name="course_id" value="'.$course_id.'"><br><br>';
    //create the SQL select statement to query program information
    $sqlProgram = "SELECT program_id,program_code FROM PROGRAM_TBL;";
    //put the resultset into a variable
    $resultProgram = $connection->query($sqlProgram);
    //create the SQL select statement to query program information
    $sqlTerm = "SELECT term_id,season FROM TERM_TBL;";
    //put the resultset into a variable
    $resultTerm = $connection->query($sqlTerm);
    createSelectFromResult("Term", $resultTerm, "term_id", "season", $selected_term_id);
    createSelectFromResult("Program", $resultProgram, "program_id", "program_code", $selected_program_id);
    echo 'Course Code:<br>
    <input type="text" name="code" value="'.$course_code.'">
    <br><br>
    Course Name:<br>
    <input type="text" name="name" value="'.$course_name.'">
    <br><br>
    Course Description:<br>
    <input type="text" name="description" value="'.$course_description.'">
    <br><br>
    Number of Credits:<br>
    <input type="text" name="credits" value="'.$credits.'">
    <br><br>
    Instruction Type:<br>
    <input type="text" name="instructiontype" value="'.$instruction_type.'">
    <br><br>
    <input type="submit" value="Submit">';
  }
  $requestedCourse = $_GET['course_id'];
  if ($requestedCourse == NULL) {
    $requestedCourse = 1;
  }
  $sqlRequested = "SELECT course_id, program_id, term_id, course_code, course_name, course_description, credits, instruction_type
        FROM COURSE_TBL
        WHERE COURSE_TBL.course_id = ".$requestedCourse.";";
  $resultRequested = $conn->query($sqlRequested);
  if ($resultRequested->num_rows > 0){
    echo 'Showing values of course with ID of '.$requestedCourse."<br>";
    if ($resultRequested->num_rows > 1){
      echo 'Potentially not showing the right course! Multiple courses were returned with the same ID!<br>';
    }
    while ($row = $resultRequested->fetch_assoc()){
      createForm($conn, $requestedCourse, $row["program_id"], $row["term_id"], $row["course_code"], $row["course_name"], $row["course_description"], $row["credits"], $row["instruction_type"]);
      break;
    }
  }else{
    echo 'Showing values of a default course as the course with ID of '.$requestedCourse." couldn't be found.<br>";
    createForm($conn, $requestedCourse, NULL,NULL,"1234","Unnamed Course","Placeholder Description","3","Lab");
  }
  //close the DB connection
  $conn->close();
?>
  
</form>
<br>
<hr> <!-- This is the hr tag, or "horizonatal reference" -->
<br><br><a href="index.html" title="Home Page" target="_parent">Return to Home</a>
</body>
</html>
