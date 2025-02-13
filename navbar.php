<?php
// Cek apakah sesi sudah dimulai, jika belum maka panggil session_start()
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$is_logged_in = isset($_SESSION['user_id']); // Misalnya, user_id disimpan di session jika login berhasil

if ($is_logged_in) {
    $icon_link = "dashboard.php";
    $icon_class = "";
    $notification = "";
} else {
    $icon_link = "#";
    $icon_class = "disabled"; // Menambahkan kelas disabled untuk mengubah gaya jika belum login
    $notification = "Anda harus login terlebih dahulu."; // Pesan notifikasi
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DUAAARRR</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>


<header>
    <div class="top-menu">
        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="login.php" style="font-size: 20px;">LOGIN</a>
            <a href="register.php" style="font-size: 20px;">REGISTER</a>
        <?php else: ?>
            <!-- Jika sudah login, tampilkan menu atau tulisan lain yang diinginkan -->
            <a href="javascript:void(0);" onclick="confirmLogout()" style="font-size: 20px;">LOGOUT</a>
        <?php endif; ?>
    </div>

    <script>
        function confirmLogout() {
            // Menampilkan konfirmasi logout
            var result = confirm("Apakah Anda yakin ingin logout?");

            if (result) {
                // Jika pengguna klik OK, redirect ke logout.php
                window.location.href = "admin/logout.php";
            }
            // Jika pengguna klik Cancel, tidak ada tindakan lebih lanjut
        }
    </script>

<div class="logo-container">
    <div class="logo" style="margin-left: 15px;">
        <a href="index.php">
            <h1 id="logo-title" onclick="toggleSearchBox()">DUAAARRR</h1>
        </a>
    </div>
    <div class="icons" style="margin-left: 10px;">
        <span class="search-icon">
            <!-- Add SVG icon for search -->
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="toggleSearchBox()">
                <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </span>
        <span class="plus-icon" style="margin-right: 15px;">
            <!-- Add SVG icon for menu -->
            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- Jika sudah login, tampilkan link yang sesuai -->
                <a href="dashboard.php">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </a>
            <?php else: ?>
                <!-- Jika belum login, tampilkan alert dan arahkan ke login -->
                <a href="javascript:void(0);" onclick="checkLogin()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </a>
            <?php endif; ?>
        </span>
    </div>
</div>

<script>
    // Function to check if the user is logged in
    function checkLogin() {
        <?php if (!isset($_SESSION['user_id'])): ?>
            // If user is not logged in, show an alert and redirect to login page
            alert("You must be logged in to access this feature.");
            window.location.href = "login.php";  // Redirect to login.php
        <?php else: ?>
            // If user is logged in, proceed with the intended action
            // You can add the action here for the logged-in users
        <?php endif; ?>
    }
</script>
    <script src="js/navbar.js"></script>


    </div>
</header>