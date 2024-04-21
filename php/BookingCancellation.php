<?php
class BookingCancellation
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function cancelBooking($seatNumber, $bookingId)
    {
        // Check if seat number and booking ID are provided
        if ($seatNumber === null || $bookingId === null) {
            return ['status' => 'error', 'message' => 'Seat number and booking ID are required'];
        }

        // Delete the booking from the database
        $query = "DELETE FROM seat_reservations WHERE seat_number = ? AND booking_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $seatNumber, $bookingId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return ['status' => 'success', 'message' => 'Booking canceled successfully'];
        } else {
            return ['status' => 'error', 'message' => 'Failed to cancel booking'];
        }
    }
}
