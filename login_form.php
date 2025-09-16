<?php
// Database connection details
session_start();
include("./config.php");

// Function to securely hash the password
function hashPassword($user_password) {
    return password_hash($user_password, PASSWORD_DEFAULT);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password from the form
    $username = $_POST['username'];
    $user_password = $_POST['password'];

    // Hash the password
    $hashedPassword = hashPassword($user_password);

    // Insert username and hashed password into the database
    $stmt = $conn->prepare("INSERT INTO users (username, user_password) VALUES (:username, :user_password)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':user_password', $hashedPassword);

    try {
        $stmt->execute();
        $_SESSION['username'] = $username; // Set session variable
        echo "User created successfully";
       
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
   
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
</head>
<body>
    <h2>User Registration</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Username: <input type="text" name="username" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <input type="submit" value="Register">
    </form>
    <a href="save_user.php"><button>See active users</button></a>
    <p><a href="edit_users.php">Edit your name</a></p>
</body>
</html>