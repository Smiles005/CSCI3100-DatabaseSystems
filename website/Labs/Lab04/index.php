<!DOCTYPE html>
<!-- 
For this lab you will need to read from two text files (Students.txt and Grades.txt), parse the data as described below, and then produce an HTML table of output.

The Students file contains a number of records, with each record containing the data for a single student.  For this lab a record is defined as one line of text (so each record is on its own line in the file).  A student record consists of a student ID, followed by the last name and then first name of the student.  The different record elements are separated by a comma.

The grades file follows the same general structure as the student file.  The record data consists of a student ID, followed by an assignment number and the grade on the assignment.  There is no guarantee that we will have an entry for each student on each assignment (in fact, some students have no grades).

The expected output should be something similar to this (though you may certainly style it differently):

Output Demo

 

To read and process file data in PHP, you will need to use some new functions:

fgets returns a single string from a file.  It reads to the end of a line (which quite handily matches our record format)
explode will break a string into tokens based on a delimiter you provide.  It returns an array of strings.
feof will tell you whether or not you have reached the end of a file.  It's quite useful for loop controls (hint, hint)
Start by reading the student data and producing the table. Once you have the table correctly printing out, you can add in the grades. 
-->
<html>
  <head> </head>
  <body>
    <table style="width: 100%">
      <link rel="stylesheet" href="tableBorder.css">
      <caption>
      <h1>Students and Grades</h1>  
      
      </caption>
      <tr>
        <th>ID</th>
        <th>Last Name</th>
        <th>First Name</th>
        <th colspan="10">Grades</th>
      </tr>
      <?php 
        $students = fopen("students.txt", "r");
        if ($students) {
          # code... 
          # Only if file is existing
          
          while (!feof($students)) {
            # code...
            $line=fgets($students);
            //output
            if ($line != FALSE) {
              # code...
              // echo "<tr><td>$line</td><td>$50</td><td>$100</td></tr>";
              $items=explode(",",$line);
              // if (!feof($grades)) {
              //   $items=explode(",",$line);
                
              // }
              ?>
              <tr>
                <td><?php echo $items[0]; ?></td>
                <td><?php echo $items[1]; ?></td>
                <td><?php echo $items[2]; ?></td>
                
                <?php
            
            }
            $grades = fopen("grades.txt", "r");
            $lineg=fgets($grades);
            if (!feof($grades)) {
              $indvGrade=explode(",",$lineg);
              while (!feof($grades)) {
                if ($indvGrade[0]== $items[0]) {
                  echo "<td>$indvGrade[1] = $indvGrade[2]</td>";
                }
                $lineg=fgets($grades);
                $indvGrade=explode(",",$lineg);
              }   
            }
            
            fclose($grades);
            echo "</tr>";
          }
        } 
      
      ?>
    </table>
  </body>
</html>
