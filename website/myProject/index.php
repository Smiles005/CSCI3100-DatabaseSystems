<?php
// Set the redirection URL
$redirectUrl = "newpage.php";

// Set the timer duration in seconds
$timerDuration = 5; // 5 seconds

// Output the HTML with JavaScript for the timer
?>

<!doctype html>
<html lang="en">
<head>
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
            background: #acc8cdff;
            color: #111;
        }
        h1 { font-size: 3rem; }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timer Page</title>
    <script>
        // JavaScript to handle the countdown and redirection
        let countdown = <?php echo $timerDuration; ?>;
        function startTimer() {
            const timerElement = document.getElementById('timer');
            const interval = setInterval(() => {
                if (countdown <= 0) {
                    clearInterval(interval);
                    window.location.href = "<?php echo $redirectUrl; ?>";
                } else {
                    timerElement.textContent = countdown;
                    countdown--;
                }
            }, 1000);
        }
        window.onload = startTimer;
    </script>

    </head>
    <body>
        <div>
        <h1>Hi</h1>
        <h2>Redirecting in <span id="timer"><?php echo $timerDuration; ?></span> seconds...</h2>
    </div>
    </body>
</html>