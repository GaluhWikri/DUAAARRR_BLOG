<?php
session_start();
include_once("database.php");

// Ambil data artikel dari database
$stmt = $pdo->query("SELECT * FROM articles");
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'navbar.php'; ?>
<nav class="flex justify-center mb-4">
    <ul class="nav-menu flex space-x-8">
        <li><a href="#" class="filter-btn text-center text-gray-800 hover:text-blue-500 hover:scale-110 transition-all duration-300" data-filter="all">All</a></li>
        <li><a href="#" class="filter-btn text-center text-gray-800 hover:text-blue-500 hover:scale-110 transition-all duration-300" data-filter="design">DESIGN</a></li>
        <li><a href="#" class="filter-btn text-center text-gray-800 hover:text-blue-500 hover:scale-110 transition-all duration-300" data-filter="art">ART</a></li>
        <li><a href="#" class="filter-btn text-center text-gray-800 hover:text-blue-500 hover:scale-110 transition-all duration-300" data-filter="photography">PHOTOGRAPHY</a></li>
        <li><a href="#" class="filter-btn text-center text-gray-800 hover:text-blue-500 hover:scale-110 transition-all duration-300" data-filter="illustration">ILLUSTRATION</a></li>
    </ul>
</nav>

<body>
    <main>
        <div class="articles-container flex flex-wrap justify-center gap-4">
            <?php
            if ($articles) {
                foreach ($articles as $article) {
                    ?>
                    <div class="article p-4 opacity-100 scale-100 transition-opacity transition-transform duration-300 ease-in-out" data-category="<?= strtolower($article['kategori']); ?>">
                        <div class="overlay"></div>
                        <a href="post.php?id=<?= $article['id']; ?>">
                            <img src="data:image/jpeg;base64,<?= base64_encode($article['gambar']); ?>" alt="<?= htmlspecialchars($article['judul']); ?>" class="w-full h-auto">
                            <h2 class="mt-2"><?= htmlspecialchars($article['judul']); ?></h2>
                            <p class="text-sm">
                                <time datetime="<?= date('c', strtotime($article['tanggal'])); ?>"><?= date('d.m.y – H:i', strtotime($article['tanggal'])); ?></time>
                                – <span><?= htmlspecialchars($article['penulis']); ?></span>
                                – <span class="category"><?= htmlspecialchars($article['kategori']); ?></span>
                            </p>
                        </a>
                    </div>
                    <?php
                }
            } else {
                echo "Tidak ada artikel ditemukan.";
            }
            ?>
        </div>
    </main>
    <script src="js/main.js"></script>
    
    <style>
        .article {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
    </style>

<footer>
    <div class="footer-content">
        <p>&copy; 2025 DUAAARRR. All rights reserved.</p>
        <ul>
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="#">Privacy Policy</a></li>
        </ul>
    </div>
</footer>
</body>

