<!-- Task 1: Creating a “graffiti wall” web page

This will be a web page that displays a wall of text. Anyone who visits can add to the wall.
Add an HTML form to your index.php file:
<form action="index.php" method="POST">

It should have two elements: a <textarea name="enteredtext"> and a submit button. (Example: http://www.echoecho.com/htmlforms08.htmLinks to an external site.) Test it.
Add a line of PHP code so that what was entered in the form appears on the page:
<?php echo ($_POST['enteredtext']); ?>

Now whatever you type into the text area should appear on the page when you hit submit. Show the instructor that this works: ______
Task 2: Saving the graffiti

Next, we want to make the graffiti persist from one hit to another. Therefore, we need to store the text in a file and make the file appear on the page.
Create a file in the project called “graffitidb.txt”. Open it and add one phrase to it so we will know it works when we read the file.
This tutorial explains how to use fread to read a file: http://www.tizag.com/phpT/fileread.phpLinks to an external site.
Display the contents of the file instead of the echo command from step 3. Test this.
Now what we need to do with the entered text is “append” it to the graffitidb.txt file. Check this tutorial: http://www.tizag.com/phpT/fileappend.phpLinks to an external site.
Think about where in the index.php file the commands to append to the file need to go, and then put them there.
Test your program. Show the result to the instructor: ______
Extra tasks:

Add a “horizontal rule” <hr> between graffiti posts. ______
Protect the page from malicious HTML/JavaScript code entered as a graffiti post.
Upload your index.php file to a publically accessible server somewhere, and get at least 4 other students to add to your wall by visiting your page.
Figure out how to use JavaScript to select all the text in the <textarea> when it is clicked. -->

<html>

<head>
    <script>
        window.onload = function () {
            const textarea = document.querySelector('textarea');
            textarea.addEventListener('click', function () {
                this.select();
            });
        };
    </script>
</head>

<body>
    <form action="index.php" method="POST">
        <textarea name="enteredtext"></textarea>

        <input type="submit" value="Enter">
    </form>
    <?php echo (htmlspecialchars($_POST['enteredtext'])); ?>
    <?php $myFile = "graffitidb.txt";
    // $fh = fopen($myFile, 'r')
    // $myFile = "graffitidb.txt";
    $fh = fopen($myFile, 'r');

    $theData = fread($fh, filesize($myFile));
    fclose($fh);
    echo $theData;
    $fh = fopen($myFile, 'a') or die("can't open file");
    $stringData = htmlspecialchars($_POST['enteredtext']);
    fwrite($fh, $stringData . "<hr />");
    fclose($fh);
    ?>
</body>

</html>