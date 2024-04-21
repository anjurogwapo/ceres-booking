<?php
session_start(); // Ensure the session is started
include 'db.php'; // Ensure your database connection is correctly included
include 'BookingManager.php'; // Include the BookingManager class

// Ensure there's a logged-in user
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit; // Prevent further execution if there is no user logged in
}

$bookingManager = new BookingManager($conn); // Create a BookingManager instance
$user_id = $_SESSION['user_id']; // Make sure you have this user_id set at login

// Retrieve POST data
$seats = isset($_POST['seats']) ? json_decode($_POST['seats']) : [];
$destination = isset($_POST['destination']) ? $_POST['destination'] : '';
$totalPrice = isset($_POST['totalPrice']) ? $_POST['totalPrice'] : 0;

$response = ['status' => 'fail', 'message' => 'No data provided'];

if (!empty($seats) && !empty($destination) && !empty($totalPrice) && !empty($user_id)) {
    // Attempt to book seats using the BookingManager
    $bookingResult = $bookingManager->bookSeats($user_id, $seats, $destination, $totalPrice);

    if ($bookingResult['status'] === 'success') {
        $response = ['status' => 'success', 'message' => 'Booking successful'];
    } else {
        $response = ['status' => 'error', 'message' => 'Booking failed: ' . $bookingResult['message']];
    }
} else {
    $response = ['status' => 'error', 'message' => 'Incomplete booking data or user not logged in'];
}

header('Content-Type: application/json');
echo json_encode($response);
