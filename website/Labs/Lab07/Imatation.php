<!DOCTYPE html>
<html>
<head>
    <title>Lab 7 - Student Grades</title>
    <link rel="stylesheet" href="test.css">
    <script>
        function confirmPublish() {
            return confirm("Are you sure you want to publish these grades?\n\nGrades will be saved to the database.");
        }
    </script>

</head>
<body>

  <!--   select *
    From grades
    where ID = 8;
    INSERT INTO grades (ID, assignment, grade)
    values (8, 5, 'D')
    on duplicate key update
    grade = 'D';

    delete From grades where ID = 8 AND ASSIGNMENT=5;
    INSERT INTO grades (ID, assignment, grade)
    values (8, 5, 'D')
    on duplicate key update
    grade = 'D';
    

    WHERE grade> F OR grade=E
    WHERE GRADE NOT IN ('A', 'B', 'C', 'D', 'F')
    
    select *
    From grades
    -- WHERE grade> 'F' OR grade='E';
    WHERE GRADE NOT IN ('A', 'B', 'C', 'D', 'F');

    select *
    From grades
    WHERE ID IN (select ID From students WHERE LAST_NAME LIKE 'M%');

    select *
    From students
    WHERE LAST_NAME LIKE 'M___s';

    select concat(LAST_NAME, ', ', FIRST_NAME) AS Name from students;

    select COUNT(*) from students where 'name' like 'S%';
    -->

    <?php
    // Database connection setup
    $servername = "127.0.0.1";
    $username = "webUser";
    $password = "SuperSecurePasswordHere";
    $schema = "csci3100";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $schema);

    // Check connection
    if ($conn->connect_error) {
        die("<p>Connection failed: " . $conn->connect_error . "</p>");
    }

    // Track which student is selected
    $selectedStudentid = -1;
    if (isset($_POST["student"])) {
        $selectedStudentid = $_POST["student"];
    }
    ?>

    <!-- STUDENT DROPDOWN -->
    <form action="" method="post">
    <label for="students">Choose a student:</label>
    <select id="students" name="student">
        <?php
        $studentQuery = "SELECT id, last_name, first_name FROM students ORDER BY last_name, first_name";
        if ($result = $conn->query($studentQuery)) {
            while ($row = $result->fetch_assoc()) {
                $id = $row["id"];
                $fname = $row["first_name"];
                $lname = $row["last_name"];
                // Keep selected option after submission
                $selected = ($id == $selectedStudentid) ? "selected" : "";
                echo "<option value='$id' $selected>$fname $lname</option>";
            }
            $result->close();
        }
      
        ?>
    </select>
    <input type="submit" value="Enter">
    </form>

    <!-- GRADES TABLE -->
    <form action="" method="post">
        <input type="hidden" name="student" value="<?php echo $selectedStudentid; ?>">
        <table style="width:100%">
            <caption><h1>Student Grades</h1></caption>
            <tr>
                <th>Assignment</th>
                <th>Grade</th>
            </tr>

            <?php
            if ($selectedStudentid != -1) {
                $gradeQuery = "
                    SELECT a.assignment, g.grade
                    FROM (
                        SELECT 1 AS assignment UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL
                        SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL
                        SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10
                    ) AS a
                    LEFT JOIN grades g ON g.assignment = a.assignment AND g.id = $selectedStudentid
                    ORDER BY a.assignment
                    ";
                if ($result = $conn->query($gradeQuery)) {
                    while ($row = $result->fetch_assoc()) {
                        $assignment = htmlspecialchars($row['assignment']);
                        $grade = htmlspecialchars($row['grade']);
                        echo "<tr>
                            <td>$assignment</td>
                            <td>
                                <select name='grades[$assignment]'>
                                    <option value=''>Select a grade ...</option>
                                    <option value='A' " . ($grade == 'A' ? 'selected' : '') . ">A</option>
                                    <option value='B' " . ($grade == 'B' ? 'selected' : '') . ">B</option>
                                    <option value='C' " . ($grade == 'C' ? 'selected' : '') . ">C</option>
                                    <option value='D' " . ($grade == 'D' ? 'selected' : '') . ">D</option>
                                    <option value='F' " . ($grade == 'F' ? 'selected' : '') . ">F</option>
                                </select>
                            </td>
                        </tr>";
                    }
                    
                    if (isset($_POST["updateGrades"]) && isset($_POST["grades"])) {
                        foreach ($_POST["grades"] as $assignment => $grade) {
                            if ($grade !== '') {
                                $assignment = intval($assignment);
                                $grade = $conn->real_escape_string($grade);
                                $updateQuery = "
                                    INSERT INTO grades (ID, assignment, grade)
                                    VALUES ($selectedStudentid, $assignment, '$grade')
                                    ON DUPLICATE KEY UPDATE grade = '$grade'
                                ";
                                $conn->query($updateQuery);
                            } else {
                                // Remove entry if "Select a grade" is chosen
                                $assignment = intval($assignment);
                                $deleteQuery = "DELETE FROM grades WHERE ID = $selectedStudentid AND assignment = $assignment";
                                $conn->query($deleteQuery);
                            }
                        }
                    }
                    $result->close();
                }
            }
            ?>
        </table>
        <input type="submit" name="updateGrades" value="Publish Grades" onclick="return confirmPublish();">
    </form>


</body>
</html>