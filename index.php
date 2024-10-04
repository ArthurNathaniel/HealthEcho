<?php
// index.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthEcho - Home</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file if you have one -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #777;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Welcome to HealthEcho</h1>
        <p>Your suggestions matter! Help us improve by submitting your suggestions or viewing analytics.</p>

        <div style="text-align: center;">
            <a href="suggestion.php" class="button">Submit a Suggestion</a>
            <a href="analytics.php" class="button">View Analytics</a>
        </div>

        <div class="footer">
            <p>&copy; <?php echo date("Y"); ?> HealthEcho. All Rights Reserved.</p>
        </div>
    </div>

</body>
</html>
