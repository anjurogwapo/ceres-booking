<?php
class UserSignup
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function signUp($userData)
    {
        $sql = "INSERT INTO users (username, email, password, age, address, phone_number, emergency_contact_name, emergency_contact_address, emergency_contact_phone, emergency_contact_relationship, profile_picture) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssisssssss", ...$userData);

        if ($stmt->execute()) {
            return "Account created successfully.";
        } else {
            return "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}
