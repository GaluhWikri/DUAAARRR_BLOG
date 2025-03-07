<?php
session_start();
require 'database.php';

// DITAMBAHKAN: Generate CSRF token jika belum ada
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // DITAMBAHKAN: Validasi CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid CSRF token");
    }
    
    // Validasi input
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = trim($_POST['password']);
    
    if (!$email || empty($password)) {
        $_SESSION['error'] = "Email atau password tidak boleh kosong.";
        header('Location: login.php');
        exit();
    }
    
    // DIUBAH: Menggunakan named parameter untuk SQL query
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]); // DIUBAH: Gunakan array asosiatif
    $user = $stmt->fetch(); // Ambil data user

    // Cek jika user ada dan password cocok
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: index.php');
        exit();
    } else {
        $_SESSION['error'] = "Email atau password salah.";
        header('Location: login.php');
        exit();
    }
}

// DITAMBAHKAN: Validasi parameter GET jika ada
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

            <div class="actions black">
                <a href="register.php" class="forgot-password">Don't Have an Account?</a>
                <button type="submit">Log In</button>
            </div>
        </form>
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