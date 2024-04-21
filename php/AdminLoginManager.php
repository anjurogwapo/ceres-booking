<?php

class AdminLoginManager
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function authenticate($username, $password)
    {
        // Sanitize username to prevent SQL injection
        $username = $this->conn->real_escape_string($username);

        // Prepare SQL statement to fetch admin credentials
        $stmt = $this->conn->prepare("SELECT admin_id, admin_password FROM admin_user WHERE admin_username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Compare the plaintext password directly
            if ($password === $row['admin_password']) {
                // Start session and store admin ID
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['admin_id'] = $row['admin_id'];
                return true; // Authentication successful
            } else {
                return false; // Incorrect password
            }
        } else {
            return false; // Admin account not found
        }
    }
}
