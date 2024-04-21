<?php

include 'db.php'; // Database connection
include 'AdminLoginManager.php'; // Include the AdminLoginManager class

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create an instance of AdminLoginManager
    $adminLoginManager = new AdminLoginManager($conn);

    // Retrieve username and password from the form submission
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Authenticate admin credentials
    if ($adminLoginManager->authenticate($username, $password)) {
        header("Location: buses.php"); // Redirect to admin home page on successful login
        exit;
    } else {
        $error_message = "Incorrect username or password.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Login - Ceres Liner</title>
    <link rel="stylesheet" href="admin_login.css">
</head>

<body>
    <h1>Admin Login to Ceres Liner</h1>
    <?php if (!empty($error_message)) : ?>
        <p class="error-message"><?= $error_message; ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        Username<br>
        <input type="text" name="username" required><br>
        Password<br>
        <input type="password" name="password" required><br>
        <button type="submit">Log In</button>
    </form>
    <div class="admin-login-link">
        <a href="login.php">Login as User</a>
    </div>
</body>

</html>