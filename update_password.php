<?php
session_start();
require_once 'connection.php';
require_once 'config/aws-config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    // Check if email exists in database
    $stmt = $con->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Generate OTP
        $otp = rand(100000, 999999);
        $_SESSION['reset_otp'] = $otp;
        $_SESSION['reset_email'] = $email;
        $_SESSION['otp_timestamp'] = time();
        
        // Send OTP via AWS SES
        try {
            $result = $sesClient->sendEmail([
                'Source' => 'your-verified-email@domain.com',
                'Destination' => [
                    'ToAddresses' => [$email]
                ],
                'Message' => [
                    'Subject' => [
                        'Data' => 'Password Reset OTP'
                    ],
                    'Body' => [
                        'Text' => [
                            'Data' => "Your OTP for password reset is: $otp. This OTP will expire in 10 minutes."
                        ]
                    ]
                ]
            ]);
            header("Location: verify_otp.php");
            exit();
        } catch (Exception $e) {
            $error = "Failed to send OTP. Please try again.";
        }
    } else {
        $error = "Email address not found!";
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
                    <a href="index.php">Back to Login</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
