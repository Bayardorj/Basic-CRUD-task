<?php
// Include config.php for database connection
include("./config.php");

// Check if user is logged in
session_start();
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: login_form.php");
    exit;
}

// Fetch books from the database
try {
    $stmt = $conn->query("SELECT * FROM books");
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit; // Terminate script execution
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fetch Books</title>
</head>
<body>
    <h2>Active users</h2>
    <p>Active users: <br> <?php echo $_SESSION['username']; ?></p>
    <p><a href="logout.php">Logout</a></p>
    <p><a href="edit_users.php">Edit your name</a></p>
    <table border="1">

        
    </table>
</body>
</html>