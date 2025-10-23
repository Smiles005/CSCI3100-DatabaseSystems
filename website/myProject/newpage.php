<?php
// /Users/klie7829/Library/CloudStorage/OneDrive-BenedictineCollege/2025 5 Semester Fall/Database/website/myProject/newpage.php
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>It Worked</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
        body { font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; padding: 2rem; }
        button { padding: .6rem 1rem; font-size: 1rem; cursor: pointer; }
        #result { margin-top: 1rem; color: #1a73e8; font-weight: 600; }
    </style>
</head>
<body>
    <h1>It Worked!!!</h1>

    <button id="pushBtn" type="button">Push me</button>
    <p id="result" aria-live="polite"></p>

    <script>
        document.getElementById('pushBtn').addEventListener('click', function () {
            document.getElementById('result').textContent = 'Button pushed!';
            // optional: briefly flash to indicate action
            this.disabled = true;
            setTimeout(() => { this.disabled = false; }, 800);
        });
    </script>


    <ul>
        <li><a href="index.php"> Back</a> </li>
        <li><a href="../..">Go back to the index</a></li>
        
    </ul>
</body>
</html>