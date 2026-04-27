<html>
    <head>
        <title>Customer Login</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <form method="post" action="index.php">
            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" required><br><br>

            <label for="ID">ID:</label>
            <input type="number" id="ID" name="ID" required><br><br>

            <input type="submit" value="Enter">
        </form>
        <?php 
        // Database connection setup
        $servername = "127.0.0.1";
        $username = "webUser";
        $password = "SuperSecurePasswordHere";
        $schema = "sakila";

        $conn = new mysqli($servername, $username, $password, $schema);

        if ($conn->connect_error) {
            die("<p>Connection failed: " . $conn->connect_error . "</p>");
        }

        // Check if form was submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $lastname = $conn->real_escape_string($_POST["lastname"]);
            $id = (int) $_POST["ID"];

            $sql = "SELECT first_name, last_name FROM customer WHERE last_name = '$lastname' AND customer_id = $id";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $first = htmlspecialchars($row["first_name"]);
                $last = htmlspecialchars($row["last_name"]);
                echo "<p>Hi $first $last! Welcome back.</p>";
            } else {
                echo "<p>Login failed. Please check your last name and ID.</p>";
            }
        }




        // display a list of suggested films.
        // The suggestions will fall into two categories: actor and genre. 
        // For each category, select the top three items the user would be interested in (based on their rental history).
        // Then select three films for each item (i.e. three from each actor and three from each genre) to display.  Do not display any film the user has already rented.


        //pull rental history through rental.customer_id to see all the movies they have rented
        //Match the invintory_id in rental to the invintory_id in inventory and then using that match the film_id in inventory with the film_id in film
        $rented_result = $conn->query("
            SELECT DISTINCT inventory.film_id
            FROM rental
            JOIN inventory ON rental.inventory_id = inventory.inventory_id
            WHERE rental.customer_id = $id
        ");
        $rented_films = [];
        while ($row = $rented_result->fetch_assoc()) {
            $rented_films[] = $row['film_id'];
        }
        $rented_list = implode(',', $rented_films) ?: 'NULL'; // fallback if empty

        //these films will be excluded from the suggestions


        //Find top three actors in the rental history that they view the most
        $actor_sql = "
            SELECT actor.actor_id, actor.first_name, actor.last_name, COUNT(*) AS starring
            FROM film_actor
            JOIN actor ON film_actor.actor_id = actor.actor_id
            WHERE film_actor.film_id IN ($rented_list)
            GROUP BY actor.actor_id
            ORDER BY starring DESC
            LIMIT 3
        ";
        $actor_result = $conn->query($actor_sql);

        echo "<hr>";
        //using the film_id from earlier pull up the use the table film_actor then using actor_id go to the actor table and pull up the top three actors (actor_id) and find three films from each in this table that they have not watched
        echo "<h1 style=\"text-align:right;\"> Suggestion By Actor</h1>";
        echo "<hr>";
        while ($actor = $actor_result->fetch_assoc()) {
        $aid = $actor['actor_id'];
        echo "<h2>Films featuring {$actor['first_name']} {$actor['last_name']}:</h2>";
        $suggest_sql = "
            SELECT film.title, film.description
            FROM film_actor
            JOIN film ON film_actor.film_id = film.film_id
            WHERE film_actor.actor_id = $aid
            AND film.film_id NOT IN ($rented_list)
            LIMIT 3
        ";

        $suggest_result = $conn->query($suggest_sql);
        echo "<table style=\"width:100%\">
            <tr>
                <th>Title</th>
                <th>Description</th>
            </tr>";
        while ($film = $suggest_result->fetch_assoc()) {
                echo "<tr><td>{$film['title']}</td><td>{$film['description']}</td></tr>";
        }
        echo "</tr>
            </table>";
    }
        // add more space between sections
        echo "<br><br>";
        echo "<hr>";
        echo "<h1 style=\"text-align:right;\"> Suggestion By Category</h1>";
        echo "<hr>";
        //using the film_id from earlier pull up the use the table film_category pull up the top three categories (data category_id) and find three films from each in this table that they have not watched 
        $genre_sql = "
            SELECT category.category_id, category.name, COUNT(*) AS appearances
            FROM film_category
            JOIN category ON film_category.category_id = category.category_id
            WHERE film_category.film_id IN ($rented_list)
            GROUP BY category.category_id
            ORDER BY appearances DESC
            LIMIT 3";
        
        $genre_result = $conn->query($genre_sql);

        while ($genre = $genre_result->fetch_assoc()) {
            $cid = $genre['category_id'];
            echo "<h2>Films in {$genre['name']} genre:</h2>";
            $suggest_sql = "SELECT film.title, film.description
                FROM film_category
                JOIN film ON film_category.film_id = film.film_id
                WHERE film_category.category_id = $cid
                AND film.film_id NOT IN ($rented_list)
                LIMIT 3
            ";
            $suggest_result = $conn->query($suggest_sql);
            echo "<table style=\"width:100%\">
            
            <tr>
                <th>Title</th>
                <th>Description</th>
            </tr>";
    
            while ($film = $suggest_result->fetch_assoc()) {
                // error_log(print_r($film, true));
                echo "<tr><td>{$film['title']}</td><td>{$film['description']}</td></tr>";
            }
            echo "</tr>
            </table>";
        }



        $conn->close();
        ?>

    </body>
</html>
