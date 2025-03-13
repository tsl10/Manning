<?php
session_start();
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($new_password == $confirm_password) {
        // Update password in database
        $email = $_SESSION['email'];
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

        $query = "UPDATE users SET password = '$hashed_password' WHERE email = '$email'";
        if (mysqli_query($con, $query)) {
            // Clear session
            session_destroy();
            header('Location: login.php');
            exit();
        } else {
            $error = "Error resetting password. Please try again.";
        }
    } else {
        $error = "Passwords do not match.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <h2>Enter New Password</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <input type="password" name="new_password" required placeholder="New Password">
        <input type="password" name="confirm_password" required placeholder="Confirm Password">
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
