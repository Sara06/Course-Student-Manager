<?php

// query database for records
 require('database.php');  
         		  
$query = 'SELECT *
          FROM sk_courses
          ORDER BY courseID';
$statement = $db->prepare($query);
$statement->execute();
$courses = $statement->fetchAll();
$statement->closeCursor();
//query database for students
$query = 'SELECT *
          FROM sk_students';
$statement = $db->prepare($query);
$statement->execute();
$students = $statement->fetchAll();
$statement->closeCursor();

//XML output for courses
if (mysql_num_rows($courses) > 0)
{
   // create DomDocument object
   $doc = new_xmldoc("1.0");
   
   // add root node
   $root = $doc->add_root("sk_courses");
   
   // iterate through result set
   while(list($courseID, $courseName) = mysql_fetch_row($courses))
   {
      // create item node
      $record = $root->new_child("course", "");
            
      // attach title and artist as children of item node
      $record->new_child("courseID", $courseID);
      $record->new_child("courseName", $courseName);
   }

// print the tree 
echo $doc->dumpmem();
}
// Json output for course
$myArray = array();
if (mysql_num_rows($courses) > 0) {

    while($row = mysql_fetch_row($courses)) {
            $myArray[] = $row;
    }
	header('Content-Type: application/json');
    echo json_encode($myArray);
}
//xml output for student data
if (mysql_num_rows($students) > 0)
{
   // create DomDocument object
   $doc = new_xmldoc("1.0");
   
   // add root node
   $root = $doc->add_root("sk_students");
   
   // iterate through result set
   while(list($studentID,$courseID, $firstName,$lastName,$email) = mysql_fetch_row($students))
   {
      // create item node
      $record = $root->new_child("student", "");
            
      // attach title and artist as children of item node
	  $record->new_child("studentID", $studentID);
      $record->new_child("courseID", $courseID);
      $record->new_child("firstName", $firstName);
	  $record->new_child("lastName", $lastName);
	  $record->new_child("email", $email);
   }

// print the tree 
echo $doc->dumpmem();
}

//Json output for students data
$temp = array();
 if (mysql_num_rows($students) > 0) {

    while($row = mysql_fetch_row($students)) {
            $temp[] = $row;
    }
	header('Content-Type: application/json');
    echo json_encode($temp);
}



// close connection
//mysql_close($connection);
?>