<?php
include 'db.php'; // Database connection
include 'UserSignup.php'; // Include the UserSignup class

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract and sanitize inputs
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($conn->real_escape_string($_POST['password']), PASSWORD_DEFAULT); // Password hashing
    // Additional fields
    $age = $conn->real_escape_string($_POST['age']);
    $address = $conn->real_escape_string($_POST['address']);
    $phone_number = $conn->real_escape_string($_POST['phone_number']);
    $emergency_contact_name = $conn->real_escape_string($_POST['emergency_contact_name']);
    $emergency_contact_address = $conn->real_escape_string($_POST['emergency_contact_address']);
    $emergency_contact_phone = $conn->real_escape_string($_POST['emergency_contact_phone']);
    $emergency_contact_relationship = $conn->real_escape_string($_POST['emergency_contact_relationship']);

    // Handle file upload for profile picture
    $profile_picture = ''; // Default value if no picture is uploaded
    if (isset($_FILES["profile_picture"]["name"]) && $_FILES["profile_picture"]["name"] != '') {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            $profile_picture = htmlspecialchars(basename($_FILES["profile_picture"]["name"]));
        }
    }

    // Package user data into an array
    $userData = [$username, $email, $password, $age, $address, $phone_number, $emergency_contact_name, $emergency_contact_address, $emergency_contact_phone, $emergency_contact_relationship, $profile_picture];

    // Create an instance of UserSignup class
    $userSignup = new UserSignup($conn);

    // Call the signUp method to create the user account
    $message = $userSignup->signUp($userData);

    // Display the result message
    echo $message;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Signup - CERES LINER</title>
    <link rel="stylesheet" href="../css/signup.css">
    <style>
        body {
            background-image: url('signup.gif');
            background-size: cover;
        }
    </style>
</head>

<body>
    <h1>Welcome to <b>CERES LINER</b></h1>
    <form method="POST" action="signup.php" enctype="multipart/form-data">
        Username<br>
        <input type="text" name="username" required><br>
        Email<br>
        <input type="email" name="email" required><br>
        Password<br>
        <input type="password" name="password" required><br>
        <!-- Additional fields for profile information -->
        Age<br>
        <input type="number" name="age"><br>
        Address<br>
        <input type="text" name="address"><br>
        Phone Number<br>
        <input type="text" name="phone_number"><br>
        Emergency Contact Name<br>
        <input type="text" name="emergency_contact_name"><br>
        Emergency Contact Address<br>
        <input type="text" name="emergency_contact_address"><br>
        Emergency Contact Phone<br>
        <input type="text" name="emergency_contact_phone"><br>
        Emergency Contact Relationship<br>
        <select name="emergency_contact_relationship">
            <option value="Mother">Mother</option>
            <option value="Father">Father</option>
            <option value="Grandparents">Grandparents</option>
            <option value="Siblings">Siblings</option>
            <option value="Guardian">Guardian</option>
        </select><br>
        Profile Picture<br>
        <input type="file" name="profile_picture"><br>
        <button type="submit">Create Account</button>
    </form>
    <div class="login-link">
        <p>Already have an account? <a href="login.php">Log in</a></p>
    </div>
</body>

</html>