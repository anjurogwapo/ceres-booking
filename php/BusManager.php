<?php
class BusManager
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllBuses()
    {
        // Retrieve all buses
        $sql = "SELECT * FROM buses";
        $result = $this->conn->query($sql);
        $buses = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $buses[] = $row;
            }
        }
        return $buses;
    }

    public function updateBusAvailability($busId, $available)
    {
        // Update the bus availability
        $sql = "UPDATE buses SET available = ? WHERE bus_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $available, $busId);
        if ($stmt->execute()) {
            return ['status' => 'success'];
        } else {
            return ['status' => 'error', 'message' => $this->conn->error];
        }
    }
}
