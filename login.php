<?php
session_start();
require 'database.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT * FROM authors WHERE username = ?');
    $stmt->execute([$username]);
    $author = $stmt->fetch();

    if ($author && password_verify($password, $author['password'])) {
        $_SESSION['user_id'] = $author['id'];
        $_SESSION['username'] = $author['username'];
        header('Location: dashboard.php');
        exit();
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
        <a href="index.php" class="logo">BOOOOOOOM</a>
        <nav>
            <a href="#">ART</a>
            <a href="#">PHOTO</a>
            <a href="#">ILLUSTRATION</a>
        </nav>
    </header>

    <div class="login-container">
        <h2>Log In</h2>
        <?php if ($error): ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" required>

            <label for="password">Password</label>
            <input type="password" name="password" required>

            <div class="actions">
                <a href="#" class="forgot-password">Forgot Password?</a>
                <button type="submit">Log In</button>
            </div>
        </form>
    </div>
</body>
</html>
