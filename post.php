<?php
session_start();
include_once("database.php");

// Ambil data artikel dari database
$stmt = $pdo->query("SELECT * FROM articles");
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
// Pastikan ada id di URL
if (isset($_GET['id'])) {
    $article_id = $_GET['id'];

    // Query untuk mengambil artikel berdasarkan id
    $query = "SELECT * FROM articles WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $article_id, PDO::PARAM_INT);
    $stmt->execute();
    $article = $stmt->fetch();
}
?>
<?php include 'navbar.php'; ?>



<script src="https://cdn.tailwindcss.com"></script>
<style>
    .custom-prose p {
        margin-bottom: 1.5em;
    }
</style>
</head>
<body class="bg-white" style="font-family: Arial, sans-serif; font-weight: bold;">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <?php if ($article): ?>
            <!-- Grid untuk Gambar dan Teks -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <!-- Gambar Pelengkap -->
                <div class="md:col-span-1.3">
                    <?php
                    // Konversi data BLOB ke Base64 untuk ditampilkan sebagai gambar
                    $gambar_base64 = base64_encode($article['gambar']);
                    $gambar_src = 'data:image/jpeg;base64,' . $gambar_base64;
                    ?>
                    <img src="<?= $gambar_src ?>" alt="<?= htmlspecialchars($article['judul']) ?>" class="w-full h-auto rounded-lg">
                </div>

                <!-- Judul, Tanggal, Penulis, dan Kategori -->
                <div class="md:col-span-2">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4 text-left"><?= htmlspecialchars($article['judul']) ?></h1>
                    <p class="text-sm font-bold text-gray-500 mb-2 text-left">
                        Published on <?= date('F j, Y \a\t H:i', strtotime($article['tanggal'])) ?>
                    </p>
                    <p class="text-sm font-bold text-gray-500 mb-4 text-left">
                        By <?= htmlspecialchars($article['penulis']) ?>
                    </p>
                    <div class="text-sm text-gray-700 text-left">
                        <span class="font-medium">Categories:</span>
                        <a href="#" class="text-black-600 text-left hover:text-black-800">
                            <?= htmlspecialchars($article['kategori']) ?>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Isi Artikel -->
            <div class="custom-prose text-gray-700">
                <p><?= nl2br(htmlspecialchars($article['isi'])) ?></p>
            </div>
            <hr class="my-8 border-t border-gray-300"> <!-- Garis pemisah antar artikel -->
        <?php else: ?>
            <p>Artikel tidak ditemukan.</p>
        <?php endif; ?>
    </div>
</body>



<!-- List of Comments -->
<div id="commentsList" class="space-y-6">
    <!-- Example Comment (You can dynamically generate these with JavaScript) -->
    <div class="bg-gray-50 p-4 rounded-lg text-center">
        <div class="flex flex-col items-center mb-2">
            <span class="font-bold text-gray-900">John Doe</span>
            <span class="text-sm text-gray-500">• February 14, 2025 at 10:30</span>
        </div>
        <p class="text-gray-700">This is an example comment. Mark Krespis's work is truly inspiring!</p>
    </div>

    <!-- Another Example Comment -->
    <div class="bg-gray-50 p-4 rounded-lg text-center">
        <div class="flex flex-col items-center mb-2">
            <span class="font-bold text-gray-900">Jane Smith</span>
            <span class="text-sm text-gray-500">• February 15, 2025 at 08:15</span>
        </div>
        <p class="text-gray-700">I love how he blends fine art and lowbrow illustration. Great article!</p>
    </div>
</div>



<!-- Section for User Comments -->
<div class="mt-12">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Comments</h2>

    <!-- Form to Add a Comment -->
    <div class="mb-8">
        <form id="commentForm">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-black focus:border-black sm:text-sm" required>
            </div>
            <div class="mb-4">
                <label for="comment" class="block text-sm font-medium text-gray-700">Your Comment</label>
                <textarea id="comment" name="comment" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-black focus:border-black sm:text-sm" required></textarea>
            </div>
            <button type="submit" class="bg-black text-white px-4 py-2 rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">Submit Comment</button>
        </form>
    </div>


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

<script src="scripts.js"></script>
</body>

</html>