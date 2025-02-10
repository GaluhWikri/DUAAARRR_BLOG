<?php
session_start();

// Inisialisasi array artikel jika belum ada
if (!isset($_SESSION['articles'])) {
    $_SESSION['articles'] = [];
}

// Proses form ketika submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $published_at = $_POST['published_at'];
    $author = $_POST['author'];
    $content = $_POST['content'];
    $keywords = $_POST['keywords'];
    $image = $_FILES['image'];

    // Validasi sederhana
    if (!empty($title) && !empty($published_at) && !empty($author) && !empty($content) && !empty($keywords) && $image['size'] > 0) {
        $upload_dir = 'uploads/';
        $image_name = time() . '-' . basename($image['name']); // Rename agar unik
        $target_path = $upload_dir . $image_name;

        // Cek apakah upload berhasil
        if (move_uploaded_file($image['tmp_name'], $target_path)) {
            $_SESSION['articles'][] = [
                "title" => $title,
                "image" => $image_name, // Simpan nama file saja
                "published_at" => $published_at,
                "author" => $author,
                "content" => $content,
                "keywords" => $keywords,
                "status" => 'published' // Status artikel (terbit)
            ];
        } else {
            echo "<p style='color:red;'>Gagal mengupload gambar!</p>";
        }
    }
}

// Hapus semua artikel
if (isset($_GET['clear'])) {
    $_SESSION['articles'] = [];
    header("Location: dashboard.php");
    exit;
}

// Fungsi untuk menarik kembali artikel
function retractArticle($index) {
    $_SESSION['articles'][$index]['status'] = 'retracted';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Dashboard Admin</h1>
        <a href="index.php" class="btn-back">← Kembali ke Halaman Utama</a>

        <h2>Tambah Artikel Baru</h2>
        <form method="POST" enctype="multipart/form-data" class="form-article">
            <input type="text" name="title" placeholder="Judul Artikel" required>
            <input type="text" name="author" placeholder="Nama Penulis" required>
            <textarea name="content" placeholder="Isi Artikel" required></textarea>
            <input type="text" name="keywords" placeholder="Kata Kunci (comma-separated)" required>
            <input type="file" name="image" required>
            <input type="date" name="published_at" required>
            <button type="submit">Tambah Artikel</button>
        </form>

        <h2>Daftar Artikel</h2>
        <a href="?clear=true" class="btn-clear">🗑 Hapus Semua Artikel</a>
        <div class="articles-container">
            <?php foreach ($_SESSION['articles'] as $index => $article): ?>
                <?php if ($article['status'] === 'published'): ?>
                    <div class="article">
                        <img src="uploads/<?= htmlspecialchars($article['image']) ?>" alt="<?= htmlspecialchars($article['title']) ?>" class="article-image">
                        <div class="article-info">
                            <h3><?= htmlspecialchars($article['title']) ?></h3>
                            <p><strong>Penulis:</strong> <?= htmlspecialchars($article['author']) ?></p>
                            <p><strong>Tanggal Terbit:</strong> <?= date("d.m.y H:i", strtotime($article['published_at'])) ?></p>
                            <p><strong>Kata Kunci:</strong> <?= htmlspecialchars($article['keywords']) ?></p>
                            <p><?= nl2br(htmlspecialchars($article['content'])) ?></p>
                            <a href="?retract=<?= $index ?>" class="btn-retract">Tarik Artikel</a>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>

    <?php
    // Proses penarikan artikel
    if (isset($_GET['retract'])) {
        retractArticle($_GET['retract']);
        header("Location: dashboard.php");
        exit;
    }
    ?>
</body>
</html>