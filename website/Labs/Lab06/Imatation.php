<!DOCTYPE html>
<html>
<head>
    <title>Lab 6 - Student Grades</title>
    <link rel="stylesheet" href="test.css">
</head>
<body>

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
    <table style="width:100%">
    <caption><h1>Student Grades</h1></caption>
    <tr>
        <th>Assignment</th>
        <th>Grade</th>
    </tr>

    <?php
    if ($selectedStudentid != -1) {
        // Query grades for selected student
        $gradeQuery = "
            SELECT g.assignment, g.grade
            FROM grades g
            WHERE g.id = $selectedStudentid
            ORDER BY g.assignment
        ";
        if ($result = $conn->query($gradeQuery)) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $assignment = htmlspecialchars($row['assignment']);
                    $grade = htmlspecialchars($row['grade']);
                    echo "<tr><td>$assignment</td><td>$grade</td></tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No grades found for this student.</td></tr>";
            }
            $result->close();
        }
    }
    $conn->close();
    ?>
    </table>

</body>
</html>