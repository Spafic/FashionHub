<?php

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data and sanitize it
    $subject = htmlspecialchars($_POST['subject']);
    $rating = htmlspecialchars($_POST['rating']);
    $message = htmlspecialchars($_POST['message']);
    
    // Retrieve session data
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
    $email = isset($_SESSION['email']) ? $_SESSION['email'] : 'No Email Provided';

    // Create an associative array with the form data and session information
    $formData = [
        'username' => $username,
        'email' => $email,
        'subject' => $subject,
        'rating' => $rating,
        'message' => $message,
        'timestamp' => date('Y-m-d H:i:s') // Add a timestamp for each submission
    ];

    // Define the file path for the JSON file
    $filePath = '../data/feedback.json';

    // Read existing data from the JSON file
    $jsonData = [];
    if (file_exists($filePath)) {
        $jsonData = json_decode(file_get_contents($filePath), true);
        if (!is_array($jsonData) || !isset($jsonData['submissions'])) {
            $jsonData = ['submissions' => []]; // Initialize with an empty array if the JSON is invalid
        }
    } else {
        $jsonData = ['submissions' => []]; // Initialize if the file does not exist
    }

    // Append the new submission data
    $jsonData['submissions'][] = $formData;

    // Save all data back to the JSON file
    file_put_contents($filePath, json_encode($jsonData, JSON_PRETTY_PRINT));

    // Redirect to the same page to prevent form resubmission
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit();
}
?>
