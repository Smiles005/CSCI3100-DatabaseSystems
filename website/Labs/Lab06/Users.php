<!DOCTYPE html>
<html>
    <head>
    <title>Testing</title>
    </head>
    <body>
        <?php

            $servername = "127.0.0.1";
            $username = "webUser";
            $password = "SuperSecurePasswordHere";
            $schema = "csci3100";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $schema);

            // Check connection
            if ($conn->connect_error) {
                echo $conn->connect_error;
                die("Connection failed: " . $conn->connect_error);
            }

            echo "<p>Connected successfully</p>";
            
            //execute query
            if ($result = $conn->query("SELECT ID, last_name, first_name FROM students")) {
                //process results
                while ($row = $result->fetch_array(MYSQLI_BOTH)) {
                    $studentID = $row[0];
                    $lastName = $row['last_name'];
                    $firstName = $row['first_name'];
                    echo "<p>$studentID - $lastName, $firstName</p>";
                }       

                //close result set
                $result->close();
            }       

            //close connection
            $conn->close();
            $conn = null;

        ?> 
    </body>
</html>
