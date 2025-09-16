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

// Check if form is submitted for editing user information
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $newUsername = $_POST['new_username'];
    $userId = $_POST['user_id'];

    try {
        // Update the username in the database
        $stmt = $conn->prepare("UPDATE users SET username = :new_username WHERE user_id = :user_id");
        $stmt->bindParam(':new_username', $newUsername);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        echo "User information updated successfully";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Fetch user details from the database
try {
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $_SESSION['username']);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
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
    <title>Edit User Information</title>
</head>
<body>
    <h2>Edit User Information</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
        Current Username: <?php echo $user['username']; ?><br><br>
        New Username: <input type="text" name="new_username" required><br><br>
        New Password: <input type="text" name="new_user_password" required><br><br>
        <input type="submit" name="submit" value="Update">
    </form>
</body>
</html>