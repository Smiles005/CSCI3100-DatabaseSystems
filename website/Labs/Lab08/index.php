<?php 
  header('Content-Type: text/xml'); // Tell browser it's XML

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
        $xw = xmlwriter_open_memory();
        xmlwriter_set_indent($xw, 1);
        $res = xmlwriter_set_indent_string($xw, ' ');

        xmlwriter_start_document($xw, '1.0', 'UTF-8');
        $studentsQuery = "
                          SELECT s.id, s.last_name, s.first_name, 
                          GROUP_CONCAT(CONCAT(g.assignment, ' = ', g.grade) SEPARATOR ',  ') AS all_grades
                          FROM students s
                          LEFT JOIN grades g ON s.id = g.id
                          GROUP BY s.id, s.last_name, s.first_name
                          ORDER BY s.id
                          ";
        // SELECT s.id, s.last_name, s.first_name 
        //             FROM students s
        //             LEFT JOIN grades g ON g.id = s.id
        //             ORDER BY s.id";

        // A first element
          /* xmlwriter_start_element($xw, 'tag1');

          // Attribute 'att1' for element 'tag1'
          xmlwriter_start_attribute($xw, 'att1');
          xmlwriter_text($xw, 'valueofatt1');
          xmlwriter_end_attribute($xw);
 */




        
  // Add XSL stylesheet link
  xmlwriter_write_pi($xw, 'xml-stylesheet', 'type="text/xsl" href="students.xsl"');

  xmlwriter_start_element($xw, 'Students'); // Root element

  if ($result = $conn->query($studentsQuery)) {
    while ($row = $result->fetch_assoc()) {
      xmlwriter_start_element($xw, 'Student');

      foreach ($row as $key => $value) {
        xmlwriter_start_element($xw, $key);
        xmlwriter_text($xw, $value !== null ? $value : 'NULL');
        xmlwriter_end_element($xw);
      }

      xmlwriter_end_element($xw); // Student
    }
    } else {
      xmlwriter_start_element($xw, 'Error');
      xmlwriter_text($xw, $conn->error);
      xmlwriter_end_element($xw);
  }

  xmlwriter_end_element($xw); // Students
  xmlwriter_end_document($xw);
          
      echo xmlwriter_output_memory($xw);
      $conn->close();
          
          
      ?>
        <!-- </table> -->
