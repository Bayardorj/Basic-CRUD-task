<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "books_database";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // Set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
  die(); // Terminate script execution
}

// Function to fetch online users from the database
function getOnlineUsers($conn) {
    try {
        $stmt = $conn->query("SELECT username FROM users WHERE online_status = 1");
        $onlineUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $onlineUsers;
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        return array(); // Return an empty array in case of error
    }
}
