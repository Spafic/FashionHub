<?php
require_once('../helpers/session_config.php');

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function processLogin($userOrEmail, $password)
{
    $fileContent = file_get_contents('../data/users/accounts.json');
    $users = json_decode($fileContent, true);

    // Check for admin login
    if (strcasecmp($userOrEmail, 'admin') == 0 && password_verify($password, '$2y$12$QZmkzVktXZLJp/qm54qsouN4hO7wnH3.VKto06Q9qcilDJ7dH5OT6')) {
        $_SESSION['username'] = "admin";
        $_SESSION['email'] = "adminPage@gmail.com";
        header('Location: ../public/home.php');
        exit;
    } else {
        // Check for regular user login
        foreach ($users as $user) {
            if ((strcasecmp($user['username'], $userOrEmail) == 0 || $user['email'] == $userOrEmail) && password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];

                // Redirect to user home page
                header('Location: ../public/home.php');
                exit;
            }
        }

        // Display an error message if login fails
        echo '<div class="alert alert-danger text-center" role="alert">Invalid username/email or password</div>';
    }
        // Redirect to the same page to prevent form resubmission
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit();
}
?>
