<!DOCTYPE html>
<html>
<head>
  <title>Student Grades</title>
  <link rel="stylesheet" href="tableBorder.css">
</head>
<body>

  <?php
  // Load selected student (if any)
  $selectedStudentId = isset($_POST["student"]) ? $_POST["student"] : -1;

  // Handle saving grades
  if (isset($_POST["save_grades"]) && isset($_POST["student_id"])) {
      $studentId = $_POST["student_id"];
      $newGrades = [];
      for ($i = 1; $i <= 10; $i++) {
          $gradeKey = "grade" . $i;
          $gradeVal = trim($_POST[$gradeKey]);
          if ($gradeVal == "") $gradeVal = "Z"; // default missing grade
          $newGrades[$i] = $gradeVal;
      }

      // Read all existing grades
      $lines = file("grades.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
      $output = [];

      $found = false;
      foreach ($lines as $line) {
          list($sid, $aid, $g) = explode(",", $line);
          if ($sid == $studentId) {
              // Replace with new grades (once)
              if (!$found) {
                  for ($i = 1; $i <= 10; $i++) {
                      $output[] = "$studentId,$i," . $newGrades[$i];
                  }
                  $found = true;
              }
          } else {
              $output[] = trim($line);
          }
      }

      // If student didn't exist yet, add them
      if (!$found) {
          for ($i = 1; $i <= 10; $i++) {
              $output[] = "$studentId,$i," . $newGrades[$i];
          }
      }

      // Save file
      file_put_contents("grades.txt", implode("\n", $output) . "\n");

      echo "<p style='color:green;'>Grades saved successfully for student $studentId.</p>";

      // Keep showing updated grades
      $selectedStudentId = $studentId;
  }
  ?>

  <!-- Student selection form -->
  <form action="" method="post">
    <label for="students">Choose a student:</label>
    <select id="students" name="student">
      <?php
      $students = fopen("students.txt", "r");
      while (!feof($students)) {
        $line = trim(fgets($students));
        if ($line == "") continue;
        $items = explode(",", $line);
        if (count($items) >= 3) {
          $id = $items[0];
          $name = $items[2] . " " . $items[1];
          $selected = ($id == $selectedStudentId) ? "selected" : "";
          echo "<option value=\"$id\" $selected>$name</option>";
        }
      }
      fclose($students);
      ?>
    </select>
    <input type="submit" value="View Grades">
  </form>

  <!-- Grade editing form -->
  <?php
  if ($selectedStudentId != -1) {
      // Read grades for selected student
      $grades = array_fill(1, 10, "Z");
      $file = fopen("grades.txt", "r");
      while (!feof($file)) {
          $line = trim(fgets($file));
          if ($line == "") continue;
          list($sid, $aid, $g) = explode(",", $line);
          if ($sid == $selectedStudentId && isset($grades[$aid])) {
              $grades[$aid] = $g;
          }
      }
      fclose($file);
      ?>

      <h2>Grades for Student ID: <?php echo $selectedStudentId; ?></h2>

      <form action="" method="post">
        <input type="hidden" name="student_id" value="<?php echo $selectedStudentId; ?>">
        <table border="1" style="width: 50%; text-align: center;">
          <tr><th>Assignment</th><th>Grade</th></tr>
          <?php
          for ($i = 1; $i <= 10; $i++) {
            echo "<tr>
                    <td>$i</td>
                    <td><input type='text' name='grade$i' value='{$grades[$i]}' maxlength='2' style='width:40px;text-align:center;'></td>
                  </tr>";
          }
          ?>
        </table>
        <br>
        <input type="submit" name="save_grades" value="Save Grades">
      </form>

  <?php
  }
  ?>

</body>
</html>
