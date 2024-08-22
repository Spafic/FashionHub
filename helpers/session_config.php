<?php
// Ensure no output before this point
session_name('MY_SECURE_SESSION');

$options = [
    'httponly' => true,
    'samesite' => 'Lax',
    'lifetime' => 24*60*60,
    'path' => '/',
    'domain' => '', 
    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
];
session_set_cookie_params($options);

// Start the session and check for errors
if (session_start() === false) {
    die("Failed to start session. Please check your server configuration.");
}

// Regenerate session ID immediately after starting the session
session_regenerate_id(true);

// Check if the session has expired
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 7200)) {
    session_unset();
    session_destroy();
    session_start(); // Start a new session after destroying the old one
    session_regenerate_id(true); // Generate a new session ID for the new session
}

// Update last activity time
$_SESSION['last_activity'] = time();

// Set the initialized flag if it's not set
if (!isset($_SESSION['initialized'])) {
    $_SESSION['initialized'] = true;
}
?>