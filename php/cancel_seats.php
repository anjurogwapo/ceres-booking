<?php
include 'db.php';
include 'SeatCancellation.php';

// Retrieve the seat numbers to cancel from the POST request
$seatsToCancel = isset($_POST['seatsToCancel']) ? json_decode($_POST['seatsToCancel']) : [];

// Create an instance of SeatCancellation
$seatCancellation = new SeatCancellation($conn);

// Cancel the seats and get the response
$response = $seatCancellation->cancelSeats($seatsToCancel);

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
