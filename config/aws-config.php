<?php
require 'vendor/autoload.php';

use Aws\Ses\SesClient;

$sesClient = new SesClient([
    'version' => 'latest',
    'region'  => 'YOUR_AWS_REGION', // e.g., us-east-1
    'credentials' => [
        'key'    => 'YOUR_AWS_ACCESS_KEY_ID',
        'secret' => 'YOUR_AWS_SECRET_ACCESS_KEY',
    ]
]);
?> 