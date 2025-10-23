<!DOCTYPE html>

<html>
  <head> </head>
  <body>
    <label for="students">Choose a student:</label>

    <?php 
    $selectedStudentid = -1;
      if(isset($_POST["student"])) {
        $selectedStudentid = $_POST["student"];
      }
        $students = fopen("students.txt", "r");
        if ($students) {
          # code... 
          # Only if file is existing
          ?>
          <form action="" method="post">
            <select id="students" name="student">

            <?php
            while (!feof($students)) {
              # code...
              $line=fgets($students);
              //output
              if ($line != FALSE) {
                # code...
                $items=explode(",",$line);
                //echo "<tr><td>$line</td><td>$50</td><td>$100</td></tr>";
                echo "<option value=\"$items[0]\">$items[2] $items[1]</option>";

              }
            }
        }

          # code...
        
    ?>
      </select>
      


       <input type="submit" value="Enter">
    </form>

    <table style="width: 100%">
      <link rel="stylesheet" href="tableBorder.css">
      <caption>
      <h1>Student Grades</h1>  
      
      </caption>
      <tr>
        <th>Assignment</th>
        <th>Grade</th>
      </tr>








      <?php 
        $students = fopen("students.txt", "r");
        // if ($students) {
          # code... 
          # Only if file is existing
          
          // while (!feof($students)) {
          //   # code...
          //   $line=fgets($students);
          //   //output
          //   if ($line != FALSE) {
          //     # code...
          //     // echo "<tr><td>$line</td><td>$50</td><td>$100</td></tr>";
          //     $items=explode(",",$line);
          //     // if (!feof($grades)) {
          //     //   $items=explode(",",$line);
                
          //     // }
      
                
       
            
          //   }
          $grades = fopen("grades.txt", "r");
          $lineg=fgets($grades);
          $test=0;
          if (!feof($grades)) {
            $indvGrade=explode(",",$lineg);
            while (!feof($grades)) {
              if ($indvGrade[0]== $selectedStudentid) {
                $test+=1;
                ?>
                <tr>
                  <td><?php echo $indvGrade[1]; ?></td>
                  <td><?php echo $indvGrade[2]; ?></td>
              
                <?php
              }
              $lineg=fgets($grades);
              $indvGrade=explode(",",$lineg);
            }
            if ($test==0) {
              echo "No Grades";
            }
            echo "</tr>";
          }
          
          fclose($grades);
          //}
        //} 
      
      ?>
    </table>
      
  </body>
  
</html> 
