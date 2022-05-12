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
  
</form>
<br>
<hr> <!-- This is the hr tag, or "horizonatal reference" -->
<br><br><a href="index.html" title="Home Page" target="_parent">Return to Home</a>
</body>
</html>
