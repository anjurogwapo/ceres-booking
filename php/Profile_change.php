<?php
session_start();
include 'db.php';

class UserProfile
{
    private $conn;
    private $user_id;

    public function __construct($conn, $user_id)
    {
        $this->conn = $conn;
        $this->user_id = $user_id;
    }

    public function getUserInfo()
    {
        $sql = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateProfile($username, $age, $address, $phone_number, $emergency_contact_name, $emergency_contact_address, $emergency_contact_phone, $emergency_contact_relationship)
    {
        $sql = "UPDATE users SET username = ?, age = ?, address = ?, phone_number = ?, emergency_contact_name = ?, emergency_contact_address = ?, emergency_contact_phone = ?, emergency_contact_relationship = ? WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sissssssi", $username, $age, $address, $phone_number, $emergency_contact_name, $emergency_contact_address, $emergency_contact_phone, $emergency_contact_relationship, $this->user_id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'] ?? 0;

// Initialize the UserProfile class
$userProfile = new UserProfile($conn, $user_id);

// Fetch user information from the database for pre-filling the form
$userInfo = $userProfile->getUserInfo();

if (!$userInfo) {
    echo "<p>Profile information is not available.</p>";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $age = $conn->real_escape_string($_POST['age']);
    $address = $conn->real_escape_string($_POST['address']);
    $phone_number = $conn->real_escape_string($_POST['phone_number']);
    $emergency_contact_name = $conn->real_escape_string($_POST['emergency_contact_name']);
    $emergency_contact_address = $conn->real_escape_string($_POST['emergency_contact_address']);
    $emergency_contact_phone = $conn->real_escape_string($_POST['emergency_contact_phone']);
    $emergency_contact_relationship = $conn->real_escape_string($_POST['emergency_contact_relationship']);

    // Update user profile
    if ($userProfile->updateProfile($username, $age, $address, $phone_number, $emergency_contact_name, $emergency_contact_address, $emergency_contact_phone, $emergency_contact_relationship)) {
        header("Location: profile.php");
        exit;
    } else {
        echo "<p>Failed to update profile. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../css/profilechange.css">
</head>

<body>
    <div class="profile-header">
        <span>CERES LINER</span>
        <nav>
            <a href="book.php">Book</a> |
            <a href="track.php">Track</a> |
            <a href="updates.php">Updates</a> |
            <a href="profile.php">Profile</a> |
            <a href="login.php">Logout</a>
        </nav>
    </div>

    <form method="POST" action="profile_change.php" style="margin-top: 20px;">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($userInfo['username']); ?>" required><br>

        <label for="age">Age:</label><br>
        <input type="text" id="age" name="age" value="<?php echo htmlspecialchars($userInfo['age'] ?? ''); ?>"><br>

        <label for="address">Address:</label><br>
        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($userInfo['address'] ?? ''); ?>"><br>

        <label for="phone_number">Phone Number:</label><br>
        <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($userInfo['phone_number'] ?? ''); ?>"><br>

        <label for="emergency_contact_name">Emergency Contact Name:</label><br>
        <input type="text" id="emergency_contact_name" name="emergency_contact_name" value="<?php echo htmlspecialchars($userInfo['emergency_contact_name'] ?? ''); ?>"><br>

        <label for="emergency_contact_address">Emergency Contact Address:</label><br>
        <input type="text" id="emergency_contact_address" name="emergency_contact_address" value="<?php echo htmlspecialchars($userInfo['emergency_contact_address'] ?? ''); ?>"><br>

        <label for="emergency_contact_phone">Emergency Contact Phone:</label><br>
        <input type="text" id="emergency_contact_phone" name="emergency_contact_phone" value="<?php echo htmlspecialchars($userInfo['emergency_contact_phone'] ?? ''); ?>"><br>

        <label for="emergency_contact_relationship">Emergency Contact Relationship:</label><br>
        <input type="text" id="emergency_contact_relationship" name="emergency_contact_relationship" value="<?php echo htmlspecialchars($userInfo['emergency_contact_relationship'] ?? ''); ?>"><br>

        <button type="submit">Save Changes</button>
        <button type="button" onclick="location.href='profile.php'">Cancel</button>
    </form>
</body>

</html>