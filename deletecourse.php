<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Delete a Course Record</title>
<link rel="stylesheet" href="stylesheet.css">
<script>
    function backToManageCourses() {
        window.location.assign("managecourses.php")
    }
    function deleteCourses(coursesToDelete) {
        let output = "course_delete=" + coursesToDelete[0];
        for (let i=1, i < coursesToDelete.length; i++) {
          output += "&course_delete=" + coursesToDelete[i]
        }
        window.location.assign("deletecourseresult.php?" + output)//window.location.protocol + window.location.hostname + "/PHPCourseManagement/updatecourse.html?course_id=" + courseID)
    }
</script>
</head>

<body>
<h2>Delete a Course Record Confirmation</h2>
<p>Are you sure you want to delete the following course(s)?</p>
<br>
<hr> <!-- This is the hr tag, or "horizonatal reference" -->
<br>
<form action="deletecourseresult.php">
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
      echo $VarName . " " . $VarValue;
      if ($VarName == 'course_delete') {
        $sqlDelete = "SELECT course_id, season, program_code, course_code, course_name, course_description, credits, required, instruction_type
        FROM TERM_TBL t, PROGRAM_TBL p, COURSE_TBL c
        WHERE c.course_id = ". $VarValue ."
        and c.program_id = p.program_id
        and c.term_id = t.term_id;";
        echo $sqlDelete;
        //put the resultset into a variable
        $result = $conn->query($sqlDelete);
        echo "<br><br>";
        if ($result == true){
          echo "result true " . $VarName . " " . $VarValue;
          echo "<table style=\"width:25%\">";
          echo "<tr>
          <td><strong>Course ID</strong></td>
          <td><strong>Season</strong></td>
          <td><strong>Program Code</strong></td>
          <td><strong>Course Code</strong></td>
          <td><strong>Course Name</strong></td>
          <td><strong>Course Description</strong></td>
          <td><strong>Credits</strong></td>
          <td><strong>Is Required?</strong></td>
          <td><strong>Instruction Type</strong></td>
          </tr>";
          //print rows
          $functionOutput = "[";
          $functionOutputCount = 0;
          /*while($row == $result->fetch_assoc()){
            $functionOutputCount += 1;
            if ($functionOutputCount == 1){
              $functionOutput = $functionOutput . $course_id;
            }else{
              $functionOutput = $functionOutput . ",".$course_id;
            }
            $output = "<tr>
            <td>".$row["course_id"]."</td>
            <td>".$row["season"]."</td>
            <td>".$row["program_code"]."</td>
            <td>".$row["course_code"]."</td>
            <td>".$row["course_name"]."</td>
            <td>".$row["course_description"]."</td>
            <td>".$row["credits"]."</td>";
            if ($row["required"] == NULL) {
                $output = $output . "<td>false</td>";
            } else {
                $output = $output . "<td>".$row["required"]."</td>";
            }
            $output = $output . "<td>".$row["instruction_type"]."</td>";
            echo $output;
          }*/
          $functionOutput = $functionOutput . "]";
          echo "</table>"
          echo "<input type=\"submit\" value=\"Yes\">";
          echo "<input type=\"button\" onclick = \"updateCourse(".$functionOutput.")\" value = \"Yes\">";
          echo "<input type=\"button\" onclick = \"backToManageCourses()\" value = \"No\">";
        } else {
            echo "Error: " . $sqlDelete . "<br>" . $conn->error;
        }
      }
    }
    $conn->close();
  ?>
</form>
<br>
<hr> <!-- This is the hr tag, or "horizonatal reference" -->
<br><br><a href="index.html" title="Home Page" target="_parent">Return to Home</a>
</body>
</html>
