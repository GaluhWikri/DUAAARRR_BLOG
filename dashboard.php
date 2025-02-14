<?php
session_start();
require_once 'database.php';
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
            <a href="daftar_artikel.php">LIST ARTICLES</a>
        </nav>
    </header>
</head>

    <!-- Konten Dashboard -->
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Tambah Artikel Baru</h2>

        <!-- Form untuk Menambahkan Artikel -->
        <form id="articleForm" action="admin/save_article.php" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
            <!-- Judul Artikel -->
            <div class="mb-4">
                <label for="judul" class="block text-sm font-medium text-gray-700">Judul Artikel</label>
                <input type="text" id="judul" name="judul" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-black focus:border-black sm:text-sm" required>
            </div>

            <!-- Gambar Artikel -->
            <div class="mb-4">
                <label for="gambar" class="block text-sm font-medium text-gray-700">URL Gambar</label>
                <input type="file" id="gambar" name="gambar" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-black focus:border-black sm:text-sm" required>
                <p class="text-sm text-gray-500 mt-1">Ukuran maksimal gambar: 2MB.</p>
            </div>

            <!-- Penulis -->
            <div class="mb-4">
                <label for="penulis" class="block text-sm font-medium text-gray-700">Penulis</label>
                <input type="text" id="penulis" name="penulis" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-black focus:border-black sm:text-sm" required>
            </div>

            <!-- Kategori -->
            <div class="mb-4">
                <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select id="kategori" name="kategori" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-black focus:border-black sm:text-sm" required>
                    <option value="Art">Art</option>
                    <option value="Design">Design</option>
                    <option value="Illustration">Illustration</option>
                    <option value="Photography">Photography</option>
                </select>
            </div>

            <!-- Isi Artikel -->
            <div class="mb-4">
                <label for="isi" class="block text-sm font-medium text-gray-700">Isi Artikel</label>
                <textarea id="isi" name="isi" rows="6" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-black focus:border-black sm:text-sm" required></textarea>
            </div>

            <!-- Tombol Submit -->
            <button type="submit" class="bg-black text-white px-4 py-2 rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">Tambah Artikel</button>
        </form>

</body>
</html>

