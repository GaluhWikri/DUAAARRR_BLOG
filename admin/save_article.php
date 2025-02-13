<?php
session_start();
require_once __DIR__ . '/../database.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $kategori = $_POST['kategori'];
    $isi = $_POST['isi'];
    $tanggal = $_POST['tanggal'] . ' ' . date('H:i:s'); // Gabungkan tanggal dan jam

    // Handle file upload
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        // Baca file gambar sebagai data biner
        $gambar_data = file_get_contents($_FILES['gambar']['tmp_name']);
    } else {
        die("Gagal mengupload gambar.");
    }
    
    if ($_FILES['gambar']['size'] > 2 * 1024 * 1024) { // 2MB
        die("Ukuran gambar terlalu besar. Maksimal 2MB.");
    }

    // Simpan data ke database
    $stmt = $pdo->prepare("INSERT INTO articles (judul, gambar, tanggal, penulis, kategori, isi) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$judul, $gambar_data, $tanggal, $penulis, $kategori, $isi]);

    // Redirect ke halaman daftar artikel
    header('Location: /Keamanan%20Perangkat%20Lunak/daftar_artikel.php');
    exit;
}
?>