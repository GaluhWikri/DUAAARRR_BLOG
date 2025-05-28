<?php
session_start();
require 'log_helper.php'; // Tambahkan ini setelah require database.php
require 'database.php';

// Generate CSRF token jika belum ada
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validasi CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid CSRF token");
    }

    // Validasi CAPTCHA (pindahkan ke sini)
    $recaptcha_secret = '6LcNOkwrAAAAAMMXO0TKWSA_uwRoGvM0S2v4s2Sf';
    $recaptcha_response = $_POST['g-recaptcha-response'] ?? '';
    $verify_response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret}&response={$recaptcha_response}");
    $response_data = json_decode($verify_response);

    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL); // <- Pastikan variabel ini dibuat sebelum log_error()

    if (!$response_data->success) {
        log_error("CAPTCHA failed for email: {$email}");
        $_SESSION['error'] = "Verifikasi CAPTCHA gagal. Silakan coba lagi.";
        header('Location: login.php');
        exit();
    }

    // Validasi input
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = trim($_POST['password']);

    if (!$email || empty($password)) {
        $_SESSION['error'] = "Email atau password tidak boleh kosong.";
        header('Location: login.php');
        exit();
    }

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        log_activity("User {$user['email']} logged in successfully.");
        header('Location: index.php');
        exit();
    } else {
        $_SESSION['error'] = "Email atau password salah.";
        log_error("Login failed for email: {$email}");
        header('Location: login.php');
        exit();
    }
}

// Validasi GET
if (!empty($_GET)) {
    foreach ($_GET as $key => $value) {
        $_GET[$key] = htmlspecialchars(strip_tags($value));
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="css/login.css">
    <script>
        window.onload = function() {
            <?php if (isset($_SESSION['error'])) { ?>
                alert("<?php echo $_SESSION['error']; ?>");
                <?php unset($_SESSION['error']); ?>
            <?php } ?>
        }
    </script>
</head>
<body>
    <header>
        <a href="index.php" style="text-decoration: none; color: inherit;">
            <div class="logo">DUAAARRR</div>
        </a>
        <nav>
            <a href="#">ART</a>
            <a href="#">PHOTO</a>
            <a href="#">ILLUSTRATION</a>
        </nav>
    </header>

    <div class="login-container">
        <h2>Log In</h2>
        <form method="POST" action="login.php">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <!-- CAPTCHA HERE -->
            <div class="g-recaptcha" data-sitekey="6LcNOkwrAAAAADrddp8fwtYI0hJf0BC1igvICqSR"></div>

            <div class="actions black">
                <a href="register.php" class="forgot-password">Don't Have an Account?</a>
                <button type="submit">Log In</button>
            </div>
        </form>

        <!-- Tambahkan script reCAPTCHA dari Google -->
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    </div>

    <footer>
        <div class="footer-content">
            <p>&copy; 2025 DUAAARRR. All rights reserved.</p>
            <ul>
                <a href="#">About</a>
                <a href="#">Contact</a>
                <a href="#">Privacy Policy</a>
            </ul>
        </div>
    </footer>
</body>
</html>  