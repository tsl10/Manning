<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['reset_otp']) || !isset($_SESSION['reset_email'])) {
    header("Location: update_password.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = $_POST['otp'];
    $stored_otp = $_SESSION['reset_otp'];
    $otp_timestamp = $_SESSION['otp_timestamp'];
    
    // Check if OTP is expired (10 minutes validity)
    if (time() - $otp_timestamp > 600) {
        $error = "OTP has expired. Please request a new one.";
        unset($_SESSION['reset_otp']);
        unset($_SESSION['otp_timestamp']);
    }
    // Verify OTP
    else if ($entered_otp == $stored_otp) {
        $_SESSION['otp_verified'] = true;
        header("Location: reset_password.php");
        exit();
    } else {
        $error = "Invalid OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <style>
        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Verify OTP</h2>
        
        <?php if (isset($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['email'])): ?>
            <p>An OTP has been sent to: <?php echo htmlspecialchars($_SESSION['email']); ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label>Enter OTP:</label>
                <input type="number" name="otp" required>
            </div>
            <button type="submit" class="btn">Verify OTP</button>
        </form>

        <div style="margin-top: 15px;">
            <a href="update_password.php">Resend OTP</a>
        </div>
    </div>

    <script>
        // Optional: Add client-side validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const otp = document.getElementById('otp').value;
            if (!/^\d{6}$/.test(otp)) {
                e.preventDefault();
                alert('Please enter a valid 6-digit OTP');
            }
        });
    </script>
</body>
</html>
