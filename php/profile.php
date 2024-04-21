<?php
session_start();

include 'db.php'; // Database connection setup

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'] ?? 0;

// Fetch user information from the database
$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo "Error preparing statement: " . $conn->error;
    exit;
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$userInfo = $result->fetch_assoc();

if (!$userInfo) {
    echo "<p>Profile information is not available.</p>";
    exit;
}

// Fetch user's bookings from the database
$bookingSql = "SELECT * FROM seat_reservations WHERE user_id = ?";
$bookingStmt = $conn->prepare($bookingSql);
if (!$bookingStmt) {
    echo "Error preparing statement: " . $conn->error;
    exit;
}
$bookingStmt->bind_param("i", $user_id);
$bookingStmt->execute();
$bookingsResult = $bookingStmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="../css/profile.css">
</head>

<body>
    <div class="profile-header">
        <span>CERES LINER</span>
        <nav>
            <a href="book.php">Book</a> |
            <a href="track.php">Track</a> |
            <a href="updates.php">Updates</a> |
            <a href="#">Profile</a> |
            <a href="login.php">Log-out</a>
        </nav>
    </div>

    <div style="text-align:center;">
        <div class="profile-picture">P</div>
        <h2>My Profile</h2>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($userInfo['username']); ?></p>
        <button onclick="location.href='profile_change.php'">Edit Profile</button>
    </div>

    <div class="profile-info">
        <h3>Personal Information</h3>
        <p>Age: <?php echo htmlspecialchars($userInfo['age'] ?? 'Not available'); ?></p>
        <p>Address: <?php echo htmlspecialchars($userInfo['address'] ?? 'Not available'); ?></p>
        <p>Phone Number: <?php echo htmlspecialchars($userInfo['phone_number'] ?? 'Not available'); ?></p>
    </div>

    <div class="emergency-info">
        <h3>In case of emergency</h3>
        <p><strong>Contact Person:</strong> <?php echo htmlspecialchars($userInfo['emergency_contact_name'] ?? 'Not available'); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($userInfo['emergency_contact_address'] ?? 'Not available'); ?></p>
        <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($userInfo['emergency_contact_phone'] ?? 'Not available'); ?></p>
        <p><strong>Relationship:</strong> <?php echo htmlspecialchars($userInfo['emergency_contact_relationship'] ?? 'Not available'); ?></p>
    </div>

    <div class="bookings-info">
        <h3>My Bookings</h3>
        <?php if ($bookingsResult->num_rows > 0) : ?>
            <ul>
                <?php while ($booking = $bookingsResult->fetch_assoc()) : ?>
                    <li>
                        Seat Number: <?php echo htmlspecialchars($booking['seat_number']); ?>,
                        Destination: <?php echo htmlspecialchars($booking['destination']); ?>,
                        Price: ₱<?php echo htmlspecialchars($booking['price']); ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else : ?>
            <p>No bookings found.</p>
        <?php endif; ?>
    </div>
</body>

</html>