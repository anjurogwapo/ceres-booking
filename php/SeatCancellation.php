<?php
class SeatCancellation
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function cancelSeats($seatsToCancel)
    {
        $response = ['status' => 'fail'];

        if (!empty($seatsToCancel)) {
            $this->conn->begin_transaction();
            try {
                foreach ($seatsToCancel as $seatNumber) {
                    // Prepare a DELETE statement to remove the seat reservation
                    $stmt = $this->conn->prepare("DELETE FROM seat_reservations WHERE seat_number = ?");
                    $stmt->bind_param("i", $seatNumber);
                    $stmt->execute();

                    // Check if the DELETE operation was successful
                    if ($stmt->affected_rows > 0) {
                        $response['status'] = 'success';
                    } else {
                        // If no rows were affected, it means the seat was not found or already removed
                        throw new Exception("Failed to cancel seat: $seatNumber. Seat not found or already canceled.");
                    }
                }
                $this->conn->commit();
                $response['message'] = 'Cancellation successful';
            } catch (Exception $e) {
                // If any error occurs, roll back the transaction
                $this->conn->rollback();
                $response['status'] = 'error';
                $response['message'] = 'Cancellation failed: ' . $e->getMessage();
            }
        } else {
            $response['message'] = 'No seats provided for cancellation';
        }

        return $response;
    }
}
