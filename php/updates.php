<?php
include 'db.php';

// Instantiate the Database class
$db = new Database();

// Fetch bus availability updates
$result = $db->getBusUpdates();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Bus Updates</title>
    <link rel="stylesheet" href="../css/updates.css">
</head>

<body>
    <div class="profile-header">
        <span>CERES LINER</span>
        <nav>
            <a href="book.php">Book</a> |
            <a href="track.php">Track</a> |
            <a href="updates.php">Updates</a> |
            <a href="profile.php">Profile</a> |
            <a href="home.php">Home</a>
        </nav>
        <div class="updates-container">
            <h2>Bus Availability Updates</h2>
            <?php if ($result->num_rows > 0) : ?>
                <table class="center">
                    <thead>
                        <tr>
                            <th>Route Name</th>
                            <th>Available Buses</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <tr>
                                <td><?= htmlspecialchars($row['bus_name']); ?></td>
                                <td><?= htmlspecialchars($row['available']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>No updates available at the moment. Please check back later.</p>
            <?php endif; ?>

            <?php
            // Close the database connection
            $db->closeConnection();
            ?>
        </div>
</body>

</html>