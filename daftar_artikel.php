<?php

require_once 'database.php';

// Ambil data artikel dari database
$stmt = $pdo->query("SELECT * FROM articles");
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Tambah Artikel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/login.css">
    <header>
        <a href="index.php" style="text-decoration: none; color: inherit;">
            <div class="logo">BOOOOOOOM</div>
        </a>
        <nav>
            <a href="dashboard.php">BACK</a>
        </nav>
    </header>
</head>

<body>
    <!-- Daftar Artikel yang Sudah Ditambahkan -->
    <div class="mt-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">DAFTAR ARTIKEL</h2>
        <div id="articleList" class="space-y-6">
            <!-- Artikel akan ditampilkan di sini secara dinamis -->

    <section class="bg-white">
    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
        <div class="grid gap-8 mb-6 lg:mb-16 md:grid-cols-2">
            <?php foreach ($articles as $article): ?>
                <div class="text-left bg-gray-50 shadow sm:flex">
                    <a href="#">
                        <!-- Tampilkan gambar artikel dengan ukuran yang konsisten -->
                        <img class="w-80 h-60 object-cover sm:rounded-none" src="data:image/jpeg;base64,<?= base64_encode($article['gambar']); ?>" alt="<?= htmlspecialchars($article['judul']); ?>">
                    </a>
                    <div class="p-5">
                        <!-- Tampilkan judul dan penulis -->
                        <h3 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                            <a href="#"><?= htmlspecialchars($article['judul']); ?></a>
                        </h3>
                        <span class="text-black dark:text-gray-900"><?= htmlspecialchars($article['penulis']); ?></span>
                        <p class="mt-3 mb-4 font-light text-black dark:text-gray-900">
                            <?= htmlspecialchars(substr($article['isi'], 0, 100)) . (strlen($article['isi']) > 100 ? '...' : ''); ?>
                        </p>

                        <!-- Informasi tambahan -->
                        <div class="mt-4">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Judul Gambar</h4>
                            <div class="flex justify-between items-center mt-2">
                                <span class="text-sm text-black dark:text-gray-900"><?= date("d F Y", strtotime($article['tanggal'])); ?></span>
                                <span class="text-sm text-black dark:text-gray-900"><?= date("H:i A", strtotime($article['tanggal'])); ?></span>
                            </div>
                            <div class="mt-2">
                                <span class="text-sm text-black dark:text-gray-900">Kategori: <?= htmlspecialchars($article['kategori']); ?></span>
                            </div>
                        </div>

                        <!-- Tombol Edit dan Hapus -->
                        <div class="mt-4 flex space-x-4">
                            <a href="admin/edit_article.php?id=<?= $article['id']; ?>" class="text-white bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded">Edit</a>
                            <form action="admin/delete_article.php" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');">
                                <input type="hidden" name="id" value="<?= $article['id']; ?>">
                                <button type="submit" class="text-white bg-red-500 hover:bg-red-600 px-4 py-2 rounded">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

        </div>
    </div>
    </div>





</body>