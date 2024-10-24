<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'employee_department');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Hash the password with md5

    // Query to check if user exists in the User table with username and password
    $stmt = $conn->prepare("SELECT * FROM User WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['authenticated'] = true; // Set the session variable
        header("Location: newemployee.php"); // Redirect to new employee page
        exit();
    } else {
        echo "Invalid username or password. <a href='login.php'>Try again</a>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <h2>Login</h2>
    <form action="login.php" method="POST">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Login">
    </form>

    <!-- Add a Sign Up button -->
    <br>
    <button onclick="window.location.href='signup.php';">Sign Up</button>
</body>

</html>