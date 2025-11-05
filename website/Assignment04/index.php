<!DOCTYPE html>
<html>
<head>
    <title>SQL Query Interface</title>
</head>
<body>
    <h1>Enter SQL Query</h1>
    <form method="post">
        <textarea name="query" rows="5" cols="80" placeholder="Enter your SQL query here..."></textarea><br>
        <input type="submit" value="Execute">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["query"])) {
        $query = $_POST["query"];
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

        // Execute query
        if ($result = $conn->query($query)) {
            // Check if it's a SELECT query
            if (stripos($query, "SELECT") === 0) {
                if ($result->num_rows > 0) {
                    echo "<table border='1'><tr>";
                    // Print column headers
                    while ($field = $result->fetch_field()) {
                        echo "<th>" . htmlspecialchars($field->name) . "</th>";
                    }
                    echo "</tr>";

                    // Print rows
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        foreach ($row as $value) {
                            echo "<td>" . htmlspecialchars($value) . "</td>";
                        }
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No results found.</p>";
                }
            } else {
                // For UPDATE, DELETE, etc.
                echo "<p>Query executed successfully. " . $conn->affected_rows . " record(s) affected.</p>";
            }
        } else {
            echo "<p>Error executing query: " . htmlspecialchars($conn->error) . "</p>";
        }

        $conn->close();
    }
    ?>
</body>
</html>