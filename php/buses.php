<?php
include 'db.php';
include 'BusManager.php';

// Create an instance of BusManager
$busManager = new BusManager($conn);

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $busId = $_POST['bus_id'];
    $available = $_POST['available'];

    // Update the bus availability
    $result = $busManager->updateBusAvailability($busId, $available);

    // Display the result
    if ($result['status'] === 'success') {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $result['message'];
    }
}

// Retrieve all buses
$buses = $busManager->getAllBuses();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Buses</title>
    <link rel="stylesheet" href="../css/busses.css">
</head>

<body>
    <h1>Manage Buses</h1>

    <?php if (!empty($buses)) : ?>
        <?php foreach ($buses as $bus) : ?>
            <form method="post">
                <input type="hidden" name="bus_id" value="<?php echo $bus['bus_id']; ?>">
                <label><?php echo $bus['bus_name']; ?>:</label>
                <input type="number" name="available" value="<?php echo $bus['available']; ?>">
                <input type="submit" name="update" value="Update">
            </form>
        <?php endforeach; ?>
    <?php else : ?>
        <p>No buses found.</p>
    <?php endif; ?>

</body>

</html>