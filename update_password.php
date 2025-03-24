<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    
    // Check if email exists and account is active
    $sql = "SELECT * FROM users WHERE EMAIL = ? AND account_status = 'active'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Check if user has exceeded reset attempts
        if ($user['reset_attempts'] >= 3) {
            $last_attempt = strtotime($user['last_reset_attempt']);
            if (time() - $last_attempt < 3600) { // 1 hour cooldown
                $error = "Too many reset attempts. Please try again after 1 hour.";
            } else {
                // Reset attempts after cooldown
                $sql = "UPDATE users SET reset_attempts = 0 WHERE user_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $user['user_id']);
                $stmt->execute();
            }
        }
        
        if (!isset($error)) {
            // Generate OTP
            $otp = rand(100000, 999999);
            $token = bin2hex(random_bytes(32));
            $expiry = date('Y-m-d H:i:s', strtotime('+5 minutes'));
            
            // Update user record with reset token
            $sql = "UPDATE users SET 
                    reset_token = ?, 
                    reset_token_expiry = ?,
                    reset_attempts = reset_attempts + 1,
                    last_reset_attempt = NOW()
                    WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $token, $expiry, $user['user_id']);
            $stmt->execute();
            
            $_SESSION['reset_token'] = $token;
            $_SESSION['reset_email'] = $email;
            $_SESSION['otp_expiry'] = time() + (5 * 60); // OTP valid for 5 minutes
            
            // Send OTP using Postfix
            $to = $email;
            $subject = "Password Reset OTP";
            $message = "Your OTP for password reset is: $otp\nThis OTP will expire in 5 minutes.";
            $headers = "From: your-email@your-domain.com\r\n";
            $headers .= "Reply-To: your-email@your-domain.com\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();
            
            if(mail($to, $subject, $message, $headers)) {
                header("Location: verify_otp.php");
                exit();
            } else {
                error_log("Failed to send email to: " . $email);
                $error = "Failed to send OTP. Please try again.";
            }
        }
    } else {
        $error = "Email not found or account is inactive. Please enter a registered email address.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 500px;
            margin-top: 100px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: #007bff;
            color: white;
            text-align: center;
            border-radius: 10px 10px 0 0 !important;
        }
        .btn-primary {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Forgot Password</h3>
            </div>
            <div class="card-body">
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Send OTP</button>
                </form>
                <div class="text-center mt-3">
                    <a href="login.php">Back to Login</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
