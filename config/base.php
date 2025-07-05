<?php
// config/base.php

ini_set("display_errors", 1);

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Load .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Get access token from environment
define('accessToken', $_ENV['ACCESS_TOKEN'] ?? 'default_token');

// API Headers
$headers = [
    'Content-Type: application/json',
    'Accept: application/json',
    'Authorization: ' . accessToken
];

// Constants
define('HEADERS', $headers);
define('HOST_API', $_ENV['HOST_API']);
