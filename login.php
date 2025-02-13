<?php
session_start();
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Mengambil data user berdasarkan email dari tabel 'users'
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch(); // Ambil data user

    // Cek jika user ada dan password cocok
    if ($user && password_verify($password, $user['password'])) {
        // Menyimpan informasi pengguna di session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username']; // Username tetap digunakan setelah login

        // Redirect ke halaman index.php setelah login berhasil
        header('Location: index.php');
        exit();
    } else {
        // Menyimpan error untuk ditampilkan di form login
        $_SESSION['error'] = "Email atau password salah.";
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
        // Menampilkan alert jika ada pesan error
        window.onload = function() {
            <?php if (isset($_SESSION['error'])) { ?>
                alert("<?php echo $_SESSION['error']; ?>");
                <?php unset($_SESSION['error']); // Hapus error setelah ditampilkan 
                ?>
            <?php } ?>
        }
    </script>
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
        <form method="POST" action="login.php">
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
        <a href="#">ABOUT</a>
        <a href="#">PRIVACY POLICY</a>
        <a href="#">TERMS & CONDITIONS</a>
        <a href="#">CONTACT</a>
        <a href="#">ADVERTISE!</a>
    </footer>
</body>

</html>

