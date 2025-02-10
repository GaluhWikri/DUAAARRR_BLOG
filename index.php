<?php
session_start();

// Inisialisasi $_SESSION['articles'] jika belum ada
if (!isset($_SESSION['articles'])) {
    $_SESSION['articles'] = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DUAAARRR</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <header>
        <div class="top-menu">
            <a href="#">Become a Member</a>
        </div>
        <div class="logo-container">
            <div class="logo">
                <h1>DUAAARRR</h1>
            </div>
            <div class="icons">
                <span class="search-icon">
                    <!-- Add SVG icon for search -->
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
                <span class="menu-icon">
                    <!-- Add SVG icon for menu -->
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
    <div class="articles-container">
        <?php if (!empty($_SESSION['articles'])): ?>
            <?php foreach ($_SESSION['articles'] as $index => $article): ?>
                <?php if ($article['status'] === 'published'): ?>
                    <div class="article">
                        <!-- Layer overlay yang akan muncul saat hover -->
                        <div class="overlay"></div>
                        
                        <!-- Konten artikel -->
                        <a href="post.php?id=<?= $index ?>">
                            <img src="uploads/<?= htmlspecialchars($article['image']) ?>" alt="<?= htmlspecialchars($article['title']) ?>">
                            <h2><?= htmlspecialchars($article['title']) ?></h2>
                            <p>
                                <time datetime="<?= date('Y-m-d\TH:i:s', strtotime($article['published_at'])) ?>">
                                    <?= date("d.m.y – H:i", strtotime($article['published_at'])) ?>
                                </time>
                                – <span><?= htmlspecialchars($article['author']) ?></span>
                            </p>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No articles found.</p>
        <?php endif; ?>
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
