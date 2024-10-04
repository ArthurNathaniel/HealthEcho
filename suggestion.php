<?php
// suggestion.php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = isset($_POST['name']) && !empty($_POST['name']) ? $_POST['name'] : 'Anonymous';
    $role = $_POST['role'];
    $suggestion = $_POST['suggestion']; // QuillJS content

    // Remove HTML tags from the suggestion
    $suggestion = strip_tags($suggestion);

    // Insert data using PDO
    $sql = "INSERT INTO suggestions (name, role, suggestion) VALUES (:name, :role, :suggestion)";
    $stmt = $pdo->prepare($sql);

    // Bind the parameters
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':suggestion', $suggestion);

    // Execute and check for success
    if ($stmt->execute()) {
        // Redirect to thank you page after successful submission
        header('Location: thankyou.php');
        exit;
    } else {
        $msg = "Error submitting your suggestion.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit a Suggestion - HealthEcho</title>
    
    <!-- QuillJS Styles and Script -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
        function copyQuillContent() {
            var quillContent = document.querySelector('.ql-editor').innerHTML;
            document.getElementById('suggestion').value = quillContent;
        }
    </script>
</head>
<body>
    <h1>Submit Your Suggestion</h1>
    <form action="suggestion.php" method="POST" onsubmit="copyQuillContent()">
        <label for="name">Name (Optional):</label><br>
        <input type="text" name="name" id="name" placeholder="Enter your name (optional)" /><br><br>

        <label for="role">You are a:</label><br>
        <select name="role" id="role" required>
            <option value="" disabled selected>Select your role</option>
            <option value="staff">Staff</option>
            <option value="patient">Patient</option>
            <option value="anonymous">Anonymous</option>
        </select><br><br>

        <label for="suggestion">Your Suggestion:</label><br>

        <!-- Quill editor container -->
        <div id="editor-container" style="height: 200px;"></div>
        
        <!-- Hidden textarea to store Quill content -->
        <textarea name="suggestion" id="suggestion" style="display:none;"></textarea><br><br>

        <button type="submit">Submit Suggestion</button>
    </form>

    <!-- QuillJS Initialization -->
    <script>
        var quill = new Quill('#editor-container', {
            theme: 'snow'
        });
    </script>
</body>
</html>
analytics.php