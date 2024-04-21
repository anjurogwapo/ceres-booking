<?php
class UserProfile
{
    private $conn;
    private $user_id;

    public function __construct($conn, $user_id)
    {
        $this->conn = $conn;
        $this->user_id = $user_id;
    }

    // Method to fetch user information from the database
    public function fetchUserInfo()
    {
        $sql = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Method to update user information in the database
    public function updateUserInfo($username, $age, $address, $phone_number, $emergency_contact_name, $emergency_contact_address, $emergency_contact_phone, $emergency_contact_relationship)
    {
        $sql = "UPDATE users SET username = ?, age = ?, address = ?, phone_number = ?, emergency_contact_name = ?, emergency_contact_address = ?, emergency_contact_phone = ?, emergency_contact_relationship = ? WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sissssssi", $username, $age, $address, $phone_number, $emergency_contact_name, $emergency_contact_address, $emergency_contact_phone, $emergency_contact_relationship, $this->user_id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}
