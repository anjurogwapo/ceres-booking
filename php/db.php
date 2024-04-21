
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ceres_liner_db"; // database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


class Database
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "ceresfinal.sql";
    private $conn;

    // Constructor to establish database connection
    public function __construct()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Method to fetch bus availability information
    public function getBusUpdates()
    {
        $sql = "SELECT bus_name, available FROM buses ORDER BY bus_name ASC";
        $result = $this->conn->query($sql);
        return $result;
    }

    // Close the database connection
    public function closeConnection()
    {
        $this->conn->close();
    }
}
