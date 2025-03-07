<?php
session_start();
include_once("database.php");

// token csrf
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Ambil data artikel dari database
$stmt = $pdo->query("SELECT * FROM articles");
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Pastikan ada ID artikel di URL
if (isset($_GET['id'])) {
    $article_id = $_GET['id'];

    // Query untuk mengambil artikel berdasarkan id
    $query = "SELECT * FROM articles WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $article_id, PDO::PARAM_INT);
    $stmt->execute();
    $article = $stmt->fetch();
}

// Proses form komentar
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name'], $_POST['comment'], $_POST['csrf_token'])) {
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token tidak valid.");
    }

    $name = $_POST['name'];
    $comment = $_POST['comment'];

    // Simpan komentar ke database
    $insert_query = "INSERT INTO comments (article_id, name, comment) VALUES (:article_id, :name, :comment)";
    $stmt = $pdo->prepare($insert_query);
    $stmt->bindParam(':article_id', $article_id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->execute();

    // Redirect kembali ke halaman artikel
    header("Location: post.php?id=$article_id");
    exit();
}

// Ambil komentar yang terkait dengan artikel berdasarkan article_id
$comments_query = "SELECT * FROM comments WHERE article_id = :article_id ORDER BY created_at DESC";
$comments_stmt = $pdo->prepare($comments_query);
$comments_stmt->bindParam(':article_id', $article_id, PDO::PARAM_INT);
$comments_stmt->execute();
$comments = $comments_stmt->fetchAll();
?>

<?php include 'navbar.php'; ?>

<script src="https://cdn.tailwindcss.com"></script>

<body class="bg-white" style="font-family: Arial, sans-serif; font-weight: bold;">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <?php if ($article): ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div class="md:col-span-1.3">
                    <?php
                    $gambar_base64 = base64_encode($article['gambar']);
                    $gambar_src = 'data:image/jpeg;base64,' . $gambar_base64;
                    ?>
                    <img src="<?= $gambar_src ?>" alt="<?= htmlspecialchars($article['judul']) ?>" class="w-full h-auto rounded-lg">
                </div>

                <div class="md:col-span-2">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4"><?= htmlspecialchars($article['judul']) ?></h1>
                    <p class="text-sm font-bold text-gray-500 mb-2">
                        <?php
                        $published_date = $article['updated_at'] ? $article['updated_at'] : $article['tanggal'];
                        echo "Published on " . date('F j, Y \a\t H:i', strtotime($published_date));
                        ?>
                    </p>
                    <p class="text-sm font-bold text-gray-500 mb-4">By <?= htmlspecialchars($article['penulis']) ?></p>
                    <div class="text-sm text-gray-700">
                        <span class="font-medium">Categories:</span>
                        <a href="#" class="text-black-600 hover:text-black-800">
                            <?= htmlspecialchars($article['kategori']) ?>
                        </a>
                    </div>
                </div>
            </div>

            <div class="custom-prose text-gray-700">
                <p><?= nl2br(htmlspecialchars($article['isi'])) ?></p>
            </div>
            <hr class="my-8 border-t border-gray-300">
        <?php else: ?>
            <p>Artikel tidak ditemukan.</p>
        <?php endif; ?>
    </div>
</body>

<!-- List of Comments -->
<div id="commentsList" class="space-y-6">
    <?php foreach ($comments as $comment): ?>
        <div class="bg-gray-50 p-4 rounded-lg text-center">
            <div class="flex flex-col items-center mb-2">
                <span class="font-bold text-gray-900"><?= htmlspecialchars($comment['name']); ?></span>
                <span class="text-sm text-gray-500">• <?= date('F j, Y \a\t g:i A', strtotime($comment['created_at'])); ?></span>
            </div>
            <p class="text-gray-700"><?= nl2br(htmlspecialchars($comment['comment'])); ?></p>
        </div>
    <?php endforeach; ?>
</div>

<!-- Section for User Comments -->
<div class="mt-12">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Leave a Comment</h2>

    <!-- Form to Add a Comment -->
    <div class="mb-8">
        <form action="post.php?id=<?= $article_id ?>" method="POST" id="commentForm">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
            
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Your Name</label>
                <input type="text" id="name" name="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-black focus:border-black sm:text-sm" required>
            </div>
            <div class="mb-4">
                <label for="comment" class="block text-sm font-medium text-gray-700">Your Comment</label>
                <textarea id="comment" name="comment" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-black focus:border-black sm:text-sm" required></textarea>
            </div>
            <button type="submit" class="bg-black text-white px-4 py-2 rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">Submit Comment</button>
        </form>
    </div>
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
