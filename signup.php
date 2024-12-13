<?php
// signup.php
include('db.php');

$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashing the password

    // Insert data using PDO
    $sql = "INSERT INTO admins (username, password) VALUES (:username, :password)";
    $stmt = $pdo->prepare($sql);

    // Bind the parameters
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);

    // Execute and check for success
    if ($stmt->execute()) {
        $msg = "Admin registered successfully! You can now log in.";
    } else {
        $msg = "Error registering admin.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Signup</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/login.css">
</head>
<body>
 <div class="login_all">
<div class="forms">
    <h1>Admin Signup</h1>
</div>
    <p><?php echo $msg; ?></p>
    <form action="signup.php" method="POST">
      <div class="forms">
      <label for="username">Username:</label>
      <input type="text" name="username" id="username" required />
      </div>

       <div class="forms">
       <label for="password">Password:</label>
       <input type="password" name="password" id="password" required />
       </div>

        <div class="forms">
        <button type="submit">Signup</button>
        </div>
    </form>
    <div class="forms">
    <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
