<?php

class UserLogin
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function loginUser($username, $password)
    {
        $username = $this->conn->real_escape_string($username);
        $sql = "SELECT user_id, password FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $row['user_id'];
                header("Location: home.php");
                exit;
            } else {
                $error_message = "Incorrect username or password.";
            }
        } else {
            $error_message = "Account not found. <a href='signup.php'>Sign up</a>";
        }

        return $error_message ?? "";
    }
}
