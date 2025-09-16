<html>
    <head>
        <title>Calculator Result</title>
        <link rel="stylesheet" href="resultStyle.css">

    </head>
    
<body>
    <div class="result">
        <h2>Calculation Result</h2>
        <?php
        // Retrieve and validate inputs
        $operand1 = isset($_POST['operand1']) ? $_POST['operand1'] : '';
        $operand2 = isset($_POST['operand2']) ? $_POST['operand2'] : '';
        $operator = isset($_POST['operator']) ? $_POST['operator'] : '';

        // Check if inputs are numeric
        if (!is_numeric($operand1) || !is_numeric($operand2)) {
            echo '<p class="error">Error: Please enter valid numbers.</p>';
        } else {
            $result = 0;
            $symbol = '';
            
            // Perform calculation based on operator
            switch ($operator) {
                case 'add':
                    $result = $operand1 + $operand2;
                    $symbol = '+';
                    break;
                case 'subtract':
                    $result = $operand1 - $operand2;
                    $symbol = '-';
                    break;
                case 'multiply':
                    $result = $operand1 * $operand2;
                    $symbol = '*';
                    break;
                case 'divide':
                    if ($operand2 == 0) {
                        echo '<p class="error">Error: Division by zero is not allowed.</p>';
                        exit;
                    }
                    $result = $operand1 / $operand2;
                    $symbol = '/';
                    break;
                default:
                    echo '<p class="error">Error: Invalid operator selected.</p>';
                    exit;
            }
            
            // Display the calculation
            echo "<p>$operand1 $symbol $operand2 = $result</p>";
        }
        ?>
        <p><a href="calcultor.html">Back to Calculator</a></p>
    </div>
    </body>
</html>