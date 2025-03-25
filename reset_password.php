<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['otp_verified']) || !isset($_SESSION['reset_email'])) {
    header("Location: update_password.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Update password in database
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashed_password, $_SESSION['reset_email']);
        
        if ($stmt->execute()) {
            // Clear all session variables
            session_destroy();
            $success = "Password updated successfully! You can now login with your new password.";
        } else {
            $error = "Failed to update password. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        <?php 
        if(isset($error)) { echo "<p class='error'>$error</p>"; }
        if(isset($success)) { echo "<p class='success'>$success</p>"; }
        ?>
        <form method="POST" action="">
            <div class="form-group">
                <label>New Password:</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label>Confirm Password:</label>
                <input type="password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn">Reset Password</button>
        </form>
    </div>
</body>
</html> 