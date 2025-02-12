<?php
session_start();

// Include koneksi ke database
require_once 'database.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Tambah Artikel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .custom-prose p {
            margin-bottom: 1.5em;
        }
    </style>
</head>
<body class="bg-gray-100" style="font-family: Arial, sans-serif;">
    <!-- Navbar -->
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-900">DUAAARRR DASHBOARD</h1>
            <a href="index.php" class="text-gray-700 hover:text-gray-900">Keluar</a>
        </div>
    </nav>

    <!-- Konten Dashboard -->
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Tambah Artikel Baru</h2>

        <!-- Form untuk Menambahkan Artikel -->
        <form id="articleForm" class="bg-white p-6 rounded-lg shadow-md">
            <!-- Judul Artikel -->
            <div class="mb-4">
                <label for="judul" class="block text-sm font-medium text-gray-700">Judul Artikel</label>
                <input type="text" id="judul" name="judul" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-black focus:border-black sm:text-sm" required>
            </div>

            <!-- Gambar Artikel -->
            <div class="mb-4">
                <label for="gambar" class="block text-sm font-medium text-gray-700">URL Gambar</label>
                <input type="file" id="gambar" name="gambar" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-black focus:border-black sm:text-sm" required>
            </div>

            <!-- Tanggal Publikasi -->
            <div class="mb-4">
                <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal Publikasi</label>
                <input type="date" id="tanggal" name="tanggal" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-black focus:border-black sm:text-sm" required>
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

        <!-- Daftar Artikel yang Sudah Ditambahkan -->
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Daftar Artikel</h2>
            <div id="articleList" class="space-y-6">
                <!-- Artikel akan ditampilkan di sini secara dinamis -->
            </div>
        </div>
    </div>

    <!-- JavaScript untuk Menangani Artikel -->
    <script>
        let articles = []; // Array untuk menyimpan artikel

        // Fungsi untuk menambahkan artikel
        document.getElementById('articleForm').addEventListener('submit', function (e) {
            e.preventDefault();

            // Ambil nilai dari form
            const judul = document.getElementById('judul').value;
            const gambar = document.getElementById('gambar').value;
            const tanggal = document.getElementById('tanggal').value;
            const penulis = document.getElementById('penulis').value;
            const kategori = document.getElementById('kategori').value;
            const isi = document.getElementById('isi').value;

            // Tambahkan artikel ke array
            articles.push({ judul, gambar, tanggal, penulis, kategori, isi });

            // Reset form
            document.getElementById('articleForm').reset();

            // Perbarui daftar artikel
            updateArticleList();
        });

        // Fungsi untuk memperbarui daftar artikel
        function updateArticleList() {
            const articleList = document.getElementById('articleList');
            articleList.innerHTML = ''; // Kosongkan daftar sebelum memperbarui

            articles.forEach((article, index) => {
                const articleHTML = `
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                            <div class="md:col-span-1">
                                <img src="${article.gambar}" alt="${article.judul}" class="w-full h-auto rounded-lg">
                            </div>
                            <div class="md:col-span-2">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">${article.judul}</h3>
                                <p class="text-sm text-gray-500 mb-2">Published on ${article.tanggal}</p>
                                <p class="text-sm text-gray-500 mb-4">By ${article.penulis}</p>
                                <div class="text-sm text-gray-700">
                                    <span class="font-medium">Categories:</span>
                                    <span>${article.kategori}</span>
                                </div>
                            </div>
                        </div>
                        <div class="custom-prose text-gray-700">
                            <p>${article.isi}</p>
                        </div>
                        <div class="mt-4">
                            <button onclick="editArticle(${index})" class="text-blue-600 hover:text-blue-800">Edit</button>
                            <button onclick="deleteArticle(${index})" class="text-red-600 hover:text-red-800 ml-2">Hapus</button>
                        </div>
                    </div>
                `;
                articleList.insertAdjacentHTML('beforeend', articleHTML);
            });
        }

        // Fungsi untuk mengedit artikel
        function editArticle(index) {
            const article = articles[index];
            document.getElementById('judul').value = article.judul;
            document.getElementById('gambar').value = article.gambar;
            document.getElementById('tanggal').value = article.tanggal;
            document.getElementById('penulis').value = article.penulis;
            document.getElementById('kategori').value = article.kategori;
            document.getElementById('isi').value = article.isi;

            // Hapus artikel lama dari array
            articles.splice(index, 1);

            // Perbarui daftar artikel
            updateArticleList();
        }

        // Fungsi untuk menghapus artikel
        function deleteArticle(index) {
            articles.splice(index, 1); // Hapus artikel dari array
            updateArticleList(); // Perbarui daftar artikel
        }
    </script>
</body>
</html>
>
