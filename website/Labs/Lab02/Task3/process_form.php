<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $username = htmlspecialchars($_POST['username'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $contact = htmlspecialchars($_POST['contact'] ?? 'Not specified');
    $interests = isset($_POST['interests']) ? array_map('htmlspecialchars', $_POST['interests']) : [];
    $country = htmlspecialchars($_POST['country'] ?? 'Not specified');

    // Display the submitted data
    echo "<h2>Form Submission Results</h2>";
    echo "<p><strong>Username:</strong> " . ($username ?: "Not provided") . "</p>";
    echo "<p><strong>Email:</strong> " . ($email ?: "Not provided") . "</p>";
    echo "<p><strong>Preferred Contact Method:</strong> $contact</p>";
    echo "<p><strong>Interests:</strong> " . (empty($interests) ? "None selected" : implode(", ", $interests)) . "</p>";
    echo "<p><strong>Country:</strong> $country</p>";
    echo "<p><a href='intakeForm.html'>Back to Form</a></p>";
} else {
    echo "<p>No form data submitted.</p>";
    echo "<p><a href='intakeForm.html'>Back to Form</a></p>";
}
?>