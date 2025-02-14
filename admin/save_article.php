<?php
session_start();
require_once __DIR__ . '/../database.php';

// Set timezone Indonesia (WIB)
date_default_timezone_set('Asia/Jakarta');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $penulis_id = $_SESSION['user_id'];
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $kategori = $_POST['kategori'];
    $isi = $_POST['isi'];
    $tanggal = date('Y-m-d H:i:s'); // Menggunakan waktu Indonesia (WIB)

    // Handle file upload
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        // Baca file gambar sebagai data biner
        $gambar_data = file_get_contents($_FILES['gambar']['tmp_name']);
    } else {
        die("Gagal mengupload gambar.");
    }
    // Validasi ukuran gambar (maksimal 2MB)
    if ($_FILES['gambar']['size'] > 2 * 1024 * 1024) { // 2MB
        die("Ukuran gambar terlalu besar. Maksimal 2MB.");
    }

    // Simpan data ke database
    $stmt = $pdo->prepare("INSERT INTO articles (judul, gambar, tanggal, penulis, kategori, isi, penulis_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$judul, $gambar_data, $tanggal, $penulis, $kategori, $isi, $penulis_id]);

    // Redirect ke halaman daftar artikel
    header('Location: /DUAAARRR_BLOG/index.php');
    exit;
}
