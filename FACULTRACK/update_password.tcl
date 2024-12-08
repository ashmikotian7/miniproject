<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $newPassword = $_POST['new_password'];

    // Hash the new password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update the password
    $sql = "UPDATE admin SET password = ?, reset_token = NULL, token_expiry = NULL WHERE reset_token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $hashedPassword, $token);

    if ($stmt->execute()) {
        echo "Password reset successful!";
        header("Location: adminlogin.html");
    } else {
        echo "Failed to reset password. Please try again.";
    }

    $stmt->close();
}

$conn->close();
?>
