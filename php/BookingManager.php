<?php
class BookingManager
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getReservedSeats($userId)
    {
        $sql = "SELECT seat_number FROM seat_reservations WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $seats = [];
        while ($row = $result->fetch_assoc()) {
            $seats[] = $row['seat_number'];
        }

        return $seats;
    }

    public function bookSeats($userId, $seats, $destination, $totalPrice)
    {
        // Begin transaction to ensure data integrity for all seat bookings
        $this->conn->begin_transaction();
        try {
            foreach ($seats as $seatNumber) {
                // Include user_id in the INSERT statement
                $stmt = $this->conn->prepare("INSERT INTO seat_reservations (user_id, seat_number, status, destination, price) VALUES (?, ?, 'reserved', ?, ?) ON DUPLICATE KEY UPDATE status='reserved', destination=?, price=?");
                // Adjusted bind_param to include $userId
                $stmt->bind_param("iisssi", $userId, $seatNumber, $destination, $totalPrice, $destination, $totalPrice);
                $stmt->execute();
            }
            // Commit the transaction
            $this->conn->commit();
            return ['status' => 'success', 'message' => 'Booking successful'];
        } catch (Exception $e) {
            // Roll back the transaction in case of error
            $this->conn->rollback();
            return ['status' => 'error', 'message' => 'Booking failed: ' . $e->getMessage()];
        }
    }
}
