<?php
// login.php
session_start();
include('db.php');

$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to fetch the admin
    $sql = "SELECT * FROM admins WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify the password
    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id']; // Store admin ID in session
        header('Location: analytics.php'); // Redirect to analytics page
        exit;
    } else {
        $msg = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body>
    <h1>Admin Login</h1>
    <p><?php echo $msg; ?></p>
    <form action="login.php" method="POST">
        <label for="username">Username:</label><br>
        <input type="text" name="username" id="username" required /><br><br>

        <label for="password">Password:</label><br>
        <input type="password" name="password" id="password" required /><br><br>

        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="signup.php">Signup here</a></p>
</body>
</html>
