<?php
session_start();
require 'database.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Password tidak cocok!";
    } else {
        $stmt = $pdo->prepare('SELECT * FROM authors WHERE username = ? OR email = ?');
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            $error = "Username atau email sudah digunakan!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare('INSERT INTO authors (fullname, username, email, password) VALUES (?, ?, ?, ?)');
            if ($stmt->execute([$fullname, $username, $email, $hashed_password])) {
                header('Location: login.php');
                exit();
            } else {
                $error = "Terjadi kesalahan saat mendaftar.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <header>
        <a href="index.php" class="logo">BOOOOOOOM</a>
        <nav>
            <a href="#">ART</a>
            <a href="#">PHOTO</a>
            <a href="#">ILLUSTRATION</a>
        </nav>
    </header>

    <div class="register-container">
        <h2>Sign Up</h2>
        <?php if ($error): ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST">
            <label for="fullname">Full Name</label>
            <input type="text" name="fullname" required>

            <label for="username">Username</label>
            <input type="text" name="username" required>

            <label for="email">Email Address</label>
            <input type="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" name="password" required>

            <label for="confirm-password">Confirm Password</label>
            <input type="password" name="confirm_password" required>

            <div class="actions">
                <button type="submit">Sign Up</button>
            </div>
            <div class="login-link">
                Already have an account? <a href="login.php">Log In</a>
            </div>
        </form>
    </div>
</body>
</html>
