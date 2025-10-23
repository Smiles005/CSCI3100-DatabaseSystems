<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Calculator</title>
    <link rel="stylesheet" href="calcStyle.css">
    <style>
        .calculator {
            max-width: 400px;
            margin: auto;
            padding: 1em;
            border: 1px solid #ccc;
        }

        .operator-group {
            margin: 0.5em 0;
        }

        .result {
            margin-top: 1em;
            font-weight: bold;
        }

        .copy-forms {
            margin-top: 1em;
            display: flex;
            gap: 10px;
        }
    </style>
</head>

<body>
    <div class="calculator">
        <h2>My Calculator</h2>
        <?php
        // Defaults
        $operand1 = isset($_POST['operand1']) ? $_POST['operand1'] : '';
        $operand2 = isset($_POST['operand2']) ? $_POST['operand2'] : '';
        $operator = isset($_POST['operator']) ? $_POST['operator'] : '';
        $result = 0;
        $error = '';

        // Do calculation only if operator was posted
        if (isset($_POST['operator'])) {
            if (!is_numeric($operand1) || !is_numeric($operand2)) {
                $error = "Error: Please enter valid numbers.";
            } else {
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
                        $symbol = '×';
                        break;
                    case 'divide':
                        if ($operand2 == 0) {
                            $error = "Error: Division by zero is not allowed.";
                            $result = 0;
                        } else {
                            $result = $operand1 / $operand2;
                            $symbol = '÷';
                        }
                        break;
                    default:
                        $error = "Error: Invalid operator selected.";
                }
            }
        }
        ?>

        <!-- Main Calculator Form -->
        <form action="" method="post">
            <label for="operand1">First Number:</label>
            <input type="text" id="operand1" name="operand1" value="<?php echo htmlspecialchars($operand1); ?>"
                required>

            <label for="operand2">Second Number:</label>
            <input type="text" id="operand2" name="operand2" value="<?php echo htmlspecialchars($operand2); ?>"
                required>

            <label>Operator:</label>
            <div class="operator-group">
                <input type="radio" id="add" name="operator" value="add" <?php if ($operator == "add")
                    echo "checked"; ?>>
                <label for="add">+</label>

                <input type="radio" id="subtract" name="operator" value="subtract" <?php if ($operator == "subtract")
                    echo "checked"; ?>>
                <label for="subtract">-</label>

                <input type="radio" id="multiply" name="operator" value="multiply" <?php if ($operator == "multiply")
                    echo "checked"; ?>>
                <label for="multiply">×</label>

                <input type="radio" id="divide" name="operator" value="divide" <?php if ($operator == "divide")
                    echo "checked"; ?>>
                <label for="divide">÷</label>
            </div>

            <input type="submit" value="Enter">
        </form>

        <!-- Display Result -->
        <div class="result">
            <?php
            if ($error) {
                echo "<p style='color:red;'>$error</p>";
            } else {
                echo "<p>Result: $result</p>";
            }
            ?>
        </div>

        <!-- Copy Result Buttons -->
        <div class="copy-forms">
            <!-- Copy to Operand1 -->
            <form action="" method="post">
                <input type="hidden" name="operand1" value="<?php echo $result; ?>">
                <input type="hidden" name="operand2" value="<?php echo htmlspecialchars($operand2); ?>">
                <input type="submit" value="Copy → First Number">
            </form>

            <!-- Copy to Operand2 -->
            <form action="" method="post">
                <input type="hidden" name="operand2" value="<?php echo $result; ?>">
                <input type="hidden" name="operand1" value="<?php echo htmlspecialchars($operand1); ?>">
                <input type="submit" value="Copy → Second Number">
            </form>

            <!-- Show History -->
            <!-- <div class="history">
                <h3>Calculation History</h3>
                <?php
                $historyFile = "calcHistory.txt";
                if (file_exists($historyFile)) {
                    echo htmlspecialchars(file_get_contents($historyFile));
                } else {
                    echo "No history yet.";
                }
                ?> -->
    </div>
</div>
</body>
</html>