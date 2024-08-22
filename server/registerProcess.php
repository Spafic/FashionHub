<?php
require_once '../helpers/session_config.php';

function processRegistration($username, $email, $hashed_password) {
    // Specify the directory and file path
    $directory = '../data/users';
    $file = $directory . '/accounts.json';

    // Ensure the directory exists
    if (!is_dir($directory)) {
        mkdir($directory, 0777, true);
    }

    // Read existing data from accounts.json
    if (file_exists($file)) {
        $json_data = file_get_contents($file);
        $accounts = json_decode($json_data, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $accounts = [];
        }
    } else {
        $accounts = [];
    }

    // Append new user data
    $accounts[] = [
        'username' => $username,
        'email' => $email,
        'password' => $hashed_password,
    ];

    // Save updated data back to accounts.json
    $result = file_put_contents($file, json_encode($accounts, JSON_PRETTY_PRINT));

    // Check if data was saved successfully
    if ($result === false) {
        // Handle error (optional: log the error)
    } else {
        // Redirect to login page
        header('Location: ../public/login.php');
        exit;
    }
        // Redirect to the same page to prevent form resubmission
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit();
}

?>