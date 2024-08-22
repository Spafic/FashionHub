<?php
ob_start();
require_once('../helpers/session_config.php');
$goodForm = true;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionHub - Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../styles/logreg.css">
    <link rel="stylesheet" href="../styles/register.css">
<style>
    
body,
html {
height: auto; /* Allow the page to grow as needed */
min-height: 100vh;
margin: 0;
padding: 0;
display: flex;
flex-direction: column;
}

.content-wrapper {
flex-grow: 1;
display: flex;
justify-content: center;
align-items: flex-start; /* Ensure content starts at the top */
padding: 2rem 0;
}

.login-container {
width: 100%;
max-width: 400px;
background-color: rgba(255, 255, 255, 0.1);
backdrop-filter: blur(10px);
border-radius: 20px;
padding: 2rem;
box-sizing: border-box; /* Ensure padding is included in the width/height */
position: relative;
}

.form-group {
margin-bottom: 1.5rem;
position: relative;
}

.alert {
margin-top: 1rem;
padding: 0.75rem;
border-radius: 5px;
color: #721c24;
background-color: rgba(248, 215, 218, 0.9);
border: 1px solid #f5c6cb;
animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
from {
opacity: 0;
transform: translateY(-10px);
}
to {
opacity: 1;
transform: translateY(0);
}
}


</style>
</head>

<body>
    <nav class="navbar">
        <div class="nav-buttons">
            <a href="login.php" class="nav-button">Login</a>
            <a href="register.php" class="nav-button">Register</a>
        </div>
    </nav>

    <div class="shapes">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>

    <div class="content-wrapper">
        <div class="login-container">
            <h2>Create Account</h2>
            <form method="POST" action="" autocomplete="off">
                <div class="form-group input-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" id="username" name="username" placeholder="Username" required>
                    
                </div>
                <div class="form-group input-icon">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="form-group input-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="form-group input-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password"
                        required>
                </div>
                <button type="submit" class="btn-login" name="register">Register</button>
            </form>
            <div class="register-link">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
            <?php
            if (isset($_POST['register'])) {
                $username = $_POST['username'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $confirmPassword = $_POST['confirm-password'];

                // Username validation
                $usernameRegex = '/^[a-zA-Z0-9._%+-]{3,}$/';
                if (!preg_match($usernameRegex, $username)) {
                    echo '<div class="alert">Invalid username format. </div>';
                    $goodForm = false;
                }

                if (strcasecmp($username, 'admin') == 0) {
                    echo '<div class="alert">Username cannot be "admin".</div>';
                    $goodForm = false;
                }

                // Email validation
                $emailRegex = '/^[a-zA-Z0-9._%+-]+@(yahoo\.com|gmail\.com|hotmail\.com|outlook\.com)$/';
                if (!preg_match($emailRegex, $email)) {
                    echo '<div class="alert">Invalid email format or domain. Please use a valid email from the following domains: Yahoo, Gmail, Hotmail, or Outlook.</div>';
                    $goodForm = false;
                }

                // Password validation
                $passwordRegex = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%^&*()_+]).{8,}$/';
                if (!preg_match($passwordRegex, $password)) {
                    echo '<div class="alert">Password must be at least 8 characters long, contain an uppercase letter, a lowercase letter, a number, and a special character (e.g., !@#$%^&*()_+).</div>';
                    $goodForm = false;
                }

                // Password confirmation
                if ($password !== $confirmPassword) {
                    echo '<div class="alert">Passwords do not match.</div>';
                    $goodForm = false;
                }

                // Check if email already exists
                $fileContent = file_get_contents('../data/users/accounts.json');
                $users = json_decode($fileContent, true);
                foreach ($users as $user) {
                    if ($user['email'] === $email) {
                        echo '<div class="alert">Email already exists. Please use a different email.</div>';
                        $goodForm = false;
                        break;
                    }
                }

                if ($goodForm) {
                    require_once('../server/registerProcess.php');
                    processRegistration($username, $email, password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]));
                }
            }
            ?>
        </div>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function (e) {
            const username = document.getElementById('username').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;

            if (!username || !email || !password || !confirmPassword) {
                e.preventDefault();
                alert('Please fill in all fields');
            }
        });

        document.querySelectorAll('.input-icon input').forEach(function(input) {
    input.addEventListener('input', function() {
        if (input.value.trim() !== "") {
            input.classList.add('filled');
        } else {
            input.classList.remove('filled');
        }
    });

    // Initialize state on page load
    if (input.value.trim() !== "") {
        input.classList.add('filled');
    }
});

        
    </script>
</body>

</html>
<?php
ob_end_flush();
?>