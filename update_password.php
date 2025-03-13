<?php
session_start();
include('connection.php');

// Function to generate OTP
function generateOTP($length = 6) {
    $characters = '0123456789';
    $otp = '';
    for ($i = 0; $i < $length; $i++) {
        $otp .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $otp;
}

// Function to send OTP via AWS SES
function sendOTP($email, $otp) {
    // Include the AWS SDK
    require 'vendor/autoload.php';
    
    $ses = new Aws\Ses\SesClient([
        'region'  => 'us-west-2', // Adjust to your AWS region
        'version' => 'latest'
    ]);

    try {
        $result = $ses->sendEmail([
            'Source' => 'tejas@trustshipping.org', // Verified SES email
            'Destination' => [
                'ToAddresses' => [$email],
            ],
            'Message' => [
                'Subject' => [
                    'Data' => 'Password Reset OTP',
                    'Charset' => 'UTF-8',
                ],
                'Body' => [
                    'Text' => [
                        'Data' => "Your OTP for resetting your password is: $otp",
                        'Charset' => 'UTF-8',
                    ],
                ],
            ],
        ]);
        return true;
    } catch (AwsException $e) {
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Check if email exists in the database
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($con, $query);
    
    if (mysqli_num_rows($result) > 0) {
        // Generate OTP
        $otp = generateOTP();
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;
        
        // Send OTP to user's email
        if (sendOTP($email, $otp)) {
            header('Location: verify_otp.php');
            exit();
        } else {
            $error = "Error sending OTP. Please try again.";
        }
    } else {
        $error = "Email address is not registered.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Password</title>
</head>
<body>
    <h2>Enter your Email Address</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <input type="email" name="email" required placeholder="Enter your email">
        <button type="submit">Send OTP</button>
    </form>
</body>
</html>
