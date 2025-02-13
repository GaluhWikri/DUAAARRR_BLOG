<?php
session_start();
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email tidak valid.";
    } else {
        // Cek apakah email sudah terdaftar
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $existingUser = $stmt->fetch();

        if ($existingUser) {
            $error = "Email sudah terdaftar. Silakan gunakan email lain.";
        } else {
            // Hash password
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Simpan data pengguna baru
            $stmt = $pdo->prepare('INSERT INTO users (email, password) VALUES (?, ?)');
            $stmt->execute([$email, $passwordHash]);

            // Redirect ke halaman login setelah berhasil
            header('Location: login.php');
            exit();
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="css/register.css">
</head>

<body>
    <header>
        <a href="index.php" style="text-decoration: none; color: inherit;">
            <div class="logo">BOOOOOOOM</div>
        </a>
        <nav>
            <a href="#">ART</a>
            <a href="#">PHOTO</a>
            <a href="#">ILLUSTRATION</a>
        </nav>
    </header>

    <div class="register-container">
        <h2>Register</h2>
        <form method="POST" action="register.php">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required>

            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name" required> <!-- Input untuk full name -->

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <div class="terms">
                <label for="agree">I agree to the Terms & Conditions</label>
            </div>

            <div class="actions">
                <a href="login.php" class="login-link">Already have an account?</a>
                <button type="submit">Register</button>
            </div>
        </form>

    </div>

    <footer>
        <a href="#">ABOUT</a>
        <a href="#">PRIVACY POLICY</a>
        <a href="#">TERMS & CONDITIONS</a>
        <a href="#">CONTACT</a>
        <a href="#">ADVERTISE!</a>
    </footer>
</body>

</html>