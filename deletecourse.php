<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Delete a Course Record</title>
<link rel="stylesheet" href="stylesheet.css">
</head>

<body>
<h2>Delete a Course Record Confirmation</h2>
<p>Are you sure you want to delete this course?</p>
<br>
<hr> <!-- This is the hr tag, or "horizonatal reference" -->
<br>
<p>This will search the courses table in the MySQL Database</p>
<p>The PHP Page will simply display the result</p>
<form action="deletecourseresult.php">
  Course ID:<br>
  <input type="text" name="emp_id" value="500000">
  <br><br>
  <input type="submit" value="Submit">
</form>
<br>
<hr> <!-- This is the hr tag, or "horizonatal reference" -->
<br><br><a href="index.html" title="Home Page" target="_parent">Return to Home</a>
</body>
</html>
