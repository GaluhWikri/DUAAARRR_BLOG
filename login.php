<?php
session_start();
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT * FROM authors WHERE username = ?');
    $stmt->execute([$username]);
    $author = $stmt->fetch();

    if ($author && password_verify($password, $author['password'])) {
        $_SESSION['user_id'] = $author['id'];
        $_SESSION['username'] = $author['username'];
    } else {
        $error = "Username atau password salah.";
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

    <div class="login-container">
        <h2>Log In</h2>
        <form>
            <label for="email">Email Address</label>
            <input type="email" id="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" required>

            <div class="actions black">
                <a href="#" class="forgot-password">Forgot Password</a>
                <button type="submit">Log In</button>
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



