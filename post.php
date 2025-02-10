<?php
session_start();

// Periksa apakah 'id' ada di URL
if (isset($_GET['id']) && isset($_SESSION['articles'][$_GET['id']])) {
    // Ambil artikel berdasarkan ID yang dipilih
    $article = $_SESSION['articles'][$_GET['id']];
} else {
    // Jika ID tidak ditemukan, arahkan ke halaman utama atau tampilkan pesan error
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($article['title']) ?></title>
    <link rel="stylesheet" href="css/post.css">
</head>

<body>
    <header>
        <div class="top-menu">
            <a href="#">Become a Member</a>
        </div>
        <div class="logo-container">
            <a href="index.php">
                <div class="logo">
                    <h1>DUAAARRR</h1>
                </div>
            </a>
            <div class="icons">
                <span class="search-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
                <span class="menu-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 6H20M4 12H20M4 18H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
            </div>
        </div>

        <nav>
            <ul>
                <li><a href="#">ART</a></li>
                <li><a href="#">PHOTO</a></li>
                <li><a href="#">SHOP</a></li>
                <li><a href="#">OPEN CALLS</a></li>
                <li><a href="#">MEMBERSHIP</a></li>
                <li><a href="#">SUBMISSIONS</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="article-detail">
            <img src="uploads/<?= htmlspecialchars($article['image']) ?>" alt="<?= htmlspecialchars($article['title']) ?>">
            <h2><?= htmlspecialchars($article['title']) ?></h2>
            <p class="meta">
                <time datetime="<?= date('Y-m-d\TH:i:s', strtotime($article['published_at'])) ?>">
                    <?= date("d.m.y – H:i", strtotime($article['published_at'])) ?>
                </time>
                – <span><?= htmlspecialchars($article['author']) ?></span>
            </p>
            <div class="article-content">
                <p><?= nl2br(htmlspecialchars($article['content'])) ?></p>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-content">
            <p>&copy; 2025 BOOOOOOOM. All rights reserved.</p>
            <ul>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="#">Privacy Policy</a></li>
            </ul>
        </div>
    </footer>

    <script src="scripts.js"></script>
</body>

</html>
