<?php
ob_start();
require_once('../helpers/session_config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionHub - Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../styles/logreg.css"> <!-- Updated CSS link -->
    <link rel="stylesheet" href="../styles/register.css"> <!-- Updated CSS link -->

</head>

<body>
    <nav class="navbar">
        <div class="nav-buttons">
            <a href="../index.php" class="nav-button">Home</a>
            <a href="../public/register.php" class="nav-button">Register</a>
            <a href="../public/login.php" class="nav-button">Login</a>
        </div>
    </nav>

    <div class="shapes">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>

    <div class="login-container">
        <h2>Welcome Back</h2>
        <form method="POST" action="" autocomplete="off">
            <div class="form-group input-icon">
                <i class="fas fa-user"></i>
                <input type="text" id="username-email" name="username-email" placeholder="Username or Email" required>
            </div>
            <div class="form-group input-icon">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn-login" name="submit">Login</button>
        </form>
        <div class="register-link">
            <p>Don't have an account? <a href="register.php">Register</a></p>
        </div>
        <?php
        if (isset($_POST['submit'])) {
            $userOrEmail = $_POST['username-email'];
            $password = $_POST['password'];

            $usernameRegex = '/^[a-zA-Z0-9_]{3,20}$/';
            $emailRegex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

            if (!preg_match($usernameRegex, $userOrEmail) && !preg_match($emailRegex, $userOrEmail)) {
                echo '<div class="alert alert-danger">Invalid username or email format</div>';
            } else {
                require_once('../server/loginProcess.php');
                processLogin($userOrEmail, $password);
            }
        }
        ?>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function (e) {
            const usernameEmail = document.getElementById('username-email').value;
            const password = document.getElementById('password').value;

            if (!usernameEmail || !password) {
                e.preventDefault();
                alert('Please fill in all fields');
            }
        });
        document.querySelectorAll('.input-icon input').forEach(function (input) {
            input.addEventListener('input', function () {
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