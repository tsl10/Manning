<?php
// AWS Configuration
define('AWS_ACCESS_KEY_ID', getenv('AWS_ACCESS_KEY_ID'));
define('AWS_SECRET_ACCESS_KEY', getenv('AWS_SECRET_ACCESS_KEY'));
define('AWS_REGION', getenv('AWS_REGION'));
define('AWS_SES_SENDER_EMAIL', getenv('AWS_SES_SENDER_EMAIL'));

// Application Configuration
define('OTP_EXPIRY_MINUTES', 10);
define('MAX_OTP_ATTEMPTS', 3);
?> 