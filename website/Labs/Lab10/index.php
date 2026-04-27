
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lab 10 - Student Grades</title>
    <script>
        function confirmPublish() {
            const ok = confirm(
                "Are you sure you want to publish this grades?\n\nGrades will be saved to the database."
            );
            // Inline onclick expects a boolean return:
            return ok;
        }
    </script>
</head>
<body>
    <h1>Lab 10 - Update Student Grades</h1>
    <form id="gradeForm" method="post" action="">
        <label for="studentID">Student ID:</label>
        <input name="studentID" id="studentID" type="number" required min="1" step="1">

        <label for="assignment"><br>Assignment #:</label>
        <input name="assignment" id="assignment" type="number" required min="1" step="1">

        <label for="grade"><br>Grade:</label>
        <input name="grade" id="grade" type="text" maxlength="1" required placeholder="A-F">
        <br>
        <button type="submit" name="updateGrade" value="Publish Grade" onclick="return confirmPublish();">Publish Grade</button>
    </form>

<?php
// Only run on POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection setup
    $servername = "127.0.0.1";
    $username   = "webUser";
    $password   = "SuperSecurePasswordHere";
    $schema     = "csci3100";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $schema);

    // Check connection
    if ($conn->connect_error) {
        die("<p>Connection failed: " . htmlspecialchars($conn->connect_error) . "</p>");
    }

    // Read inputs
    $selectedStudentid  = isset($_POST["studentID"])  ? (int)$_POST["studentID"]  : -1;
    $selectedAssignment = isset($_POST["assignment"]) ? (int)$_POST["assignment"] : -1;
    $setGrade           = isset($_POST["grade"])      ? strtoupper(trim($_POST["grade"])) : "End";

    if ($selectedStudentid != -1 && $selectedAssignment != -1 && $setGrade != "End") {

        // Prepared statement for UPDATE
        $stmt = $conn->prepare("UPDATE grades SET GRADE = ? WHERE ASSIGNMENT = ? AND ID = ?");
        if (!$stmt) {
            echo "<p>Prepare failed: " . htmlspecialchars($conn->error) . "</p>";
        } else {
            // Bind: s (string), i (int), i (int)
            $stmt->bind_param("sii", $setGrade, $selectedAssignment, $selectedStudentid);

            // Execute
            $ok = $stmt->execute();

            if ($ok) {
                // Rows affected by the UPDATE
                $affected = $stmt->affected_rows;
                if ($affected > 0) {
                    echo "<p>Grade updated successfully: Rows affected: "
                        . htmlspecialchars($affected) . ".</p>";
                } else {
                    echo "<p>Update ran, but no rows were affected. Check that the student and assignment exist.</p>";
                }
            } else {
                echo "<p>Update failed: " . htmlspecialchars($stmt->error) . "</p>";
            }

            $stmt->close();
        }
    } else {
        echo "<p>Provide Student ID, Assignment #, and Grade before submitting.</p>";
    }

    $conn->close();
}
?>
</body>
</html>
