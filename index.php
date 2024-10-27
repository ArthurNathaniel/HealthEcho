<?php
// index.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthEcho - Home</title>
<link rel="stylesheet" href="./css/base.css">
<link rel="stylesheet" href="./css/index.css">
</head>
<body>

    <div class="healthecho_all">
        <h1>Welcome to HealthEcho</h1>
        <p>Your suggestions matter! Help us improve by submitting your suggestions or viewing analytics.</p>

        <div class="healtheccho_btn">
            <a href="suggestion.php">
                <button>Submit a Suggestion</button>
            </a>
        </div>

        <div class="footer">
            <p>&copy; <?php echo date("Y"); ?> HealthEcho. All Rights Reserved.</p>
        </div>
    </div>

</body>
</html>
