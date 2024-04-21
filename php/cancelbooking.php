<?php
include 'db.php';
include 'BookingCancellation.php';

// Retrieve the seat number and booking ID from the POST request
$seatNumber = $_POST['seatNumber'] ?? null;
$bookingId = $_POST['bookingId'] ?? null;

// Create an instance of BookingCancellation
$bookingCancellation = new BookingCancellation($conn);

// Cancel the booking and get the response
$response = $bookingCancellation->cancelBooking($seatNumber, $bookingId);

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
