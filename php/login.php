<?php
include 'db.php'; // Database connection

session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    // Adjusted to select user_id instead of id
    $sql = "SELECT user_id, password FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['loggedin'] = true;
            // Use user_id from the query result
            $_SESSION['user_id'] = $row['user_id']; // Adjusted to use user_id
            header("Location: home.php"); // Redirect to home page
            exit;
        } else {
            $error_message = "Incorrect username or password.";
        }
    } else {
        $error_message = "Account not found. <a href='signup.php'>Sign up</a>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login - Ceres Liner</title>
    <link rel="stylesheet" href="../css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="background-image"></div>
    <div class="content">
        <h1>CERES LINER </h1>

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
        <p class="centered">Experience hassle-free travel with Ceres Liner.
            <br> Our web application is designed to make your journey <br>
            smoother and more convenient than ever before.
        </p>
        <p class="about-link" style="text-align: center;">
            <a href="about_us.php" style="color:#F00; font-weight: bold; font-size: 15px;">About Us</a>
        </p>

    </div>
</body>

</html>