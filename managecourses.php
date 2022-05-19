<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Add Course</title>
<link rel="stylesheet" href="stylesheet.css">
<script>
    function newCourse() {
        window.location.assign("addcourse.php");
    }
    function updateCourse(courseID) {
        window.location.assign("updatecourse.php?course_id=" + courseID);//window.location.protocol + window.location.hostname + "/PHPCourseManagement/updatecourse.html?course_id=" + courseID)
    }
</script>
</head>

<body>
	<h2>Course Management</h2>
	<form action="deletecourse.php">
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
            // echo "MySQL Connection Succeeded<br><br>";
            
            $SplitURI = explode('?', $_SERVER['REQUEST_URI']); //Returns "/PHPCourseManagement/managecourses.php","course_delete=1&course_delete=2&course_delete=3" where the ? is the divider
            $FormInfo = $SplitURI[1]; //The variables we want
            foreach (explode('&', $FormInfo) as $chunk)
            {
                $param = explode("=", $chunk); //[0] being the name, [1] being the value. Akin to $_GET[0] = [1]
                $VarName = $param[0];
                $VarValue = $param[1];
                if ($VarName == 'course_delete') {
                    $sqlDelete = "DELETE FROM COURSE_TBL where course_id = ".$VarValue.";";
	
                    //put the resultset into a variable
                    $result = $conn->query($sqlDelete);
                    echo "<br><br>";
                    if ($result == true){
                        //print rows
                        echo "<strong>Course with ID of ".$VarValue." Deleted Successfully</strong><br>";
                    } else {
                        echo "Error: " . $sqlDelete . "<br>" . $conn->error;
                    }
                }
            }
            echo "<input type=\"button\" onclick = \"newCourse()\" value = \"New Course\">";
            
            //pull the attribute that was passed with the html form GET request and put into a local variable.
            $program_id = $_GET["program_id"];
            $term_id = $_GET["term_id"];
            $code = $_GET["code"];
            $name = $_GET["name"];
            $description = $_GET["description"];
            $credits = $_GET["credits"];
            $instructiontype = $_GET["instructiontype"];

            $sql = "SELECT course_id, season, program_code, course_code, course_name, course_description, credits, required, instruction_type
            FROM TERM_TBL t, PROGRAM_TBL p, COURSE_TBL c
            WHERE c.program_id = p.program_id
            and c.term_id = t.term_id;";
            $result = $conn->query($sql);
            if ($result->num_rows > 0){
                echo "<input type=\"submit\" value=\"Delete Selected\">";
                echo "<table>";
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
                <td><strong>Update?</strong></td>
                <td><strong>Delete?</strong></td>
                </tr>";
                //print rows
                while($row = $result->fetch_assoc()){
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
                    $output = $output . "<td>".$row["instruction_type"]."</td>
                    <td><input type=\"button\" onclick = \"updateCourse(".$row["course_id"].")\" value = \"Update\"></td>
                    <td><input type=\"checkbox\" name=\"course_delete\" value=\"".$row["course_id"]."\"></td>
                    </tr>";
                    echo $output;
                }
                echo "</table>";
            } else {
                echo "No Records Found";
            }
            

            //always close the DB connections, don't leave 'em hanging
            $conn->close();
            
        ?>
    </form>
	<br><br><a href="index.html" title="Home Page" target="_parent">Return to Home</a>
</body>
</html>
