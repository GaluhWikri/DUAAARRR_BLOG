<?php
session_start();
require_once __DIR__ . '/../database.php';

// Set timezone Indonesia (WIB)
date_default_timezone_set('Asia/Jakarta');

// token csrf
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Cek apakah user sudah login
    if (!isset($_SESSION['user_id'])) {
        die("Akses ditolak. Anda harus login terlebih dahulu.");
    }

    // validasi token csrf
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid CSRF token.");
    }

    //hapus token
    unset($_SESSION['csrf_token']);

    // Buat token baru setelah request selesai (agar tetap aman)
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    // Ambil data dari form dan sanitasi input
    $penulis_id = $_SESSION['user_id'];
    $judul = trim($_POST['judul']);
    $penulis = trim($_POST['penulis']);
    $kategori = trim($_POST['kategori']);
    $isi = trim($_POST['isi']);
    $tanggal = date('Y-m-d H:i:s'); // Menggunakan waktu Indonesia (WIB)

    // Validasi panjang input
    if (strlen($judul) < 5 || strlen($judul) > 100) {
        die("Judul harus antara 5-100 karakter.");
    }
    if (strlen($penulis) < 3 || strlen($penulis) > 50) {
        die("Nama penulis harus antara 3-50 karakter.");
    }
    if (strlen($isi) < 50) {
        die("Isi artikel minimal 50 karakter.");
    }

    // Handle file upload
    if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] !== UPLOAD_ERR_OK) {
        die("Gagal mengupload gambar.");
    }

    // Validasi ukuran gambar (maksimal 2MB)
    if ($_FILES['gambar']['size'] > 2 * 1024 * 1024) { // 2MB
        die("Ukuran gambar terlalu besar. Maksimal 2MB.");
    }

    // Validasi tipe MIME gambar
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $mime_type = mime_content_type($_FILES['gambar']['tmp_name']);
    if (!in_array($mime_type, $allowed_types)) {
        die("Format gambar tidak didukung. Hanya JPG, PNG, dan GIF yang diperbolehkan.");
    }

    // Simpan gambar sebagai data biner
    $gambar_data = file_get_contents($_FILES['gambar']['tmp_name']);

    // **Gunakan Named Parameter untuk SQL Query**
    $stmt = $pdo->prepare("INSERT INTO articles (judul, gambar, tanggal, penulis, kategori, isi, penulis_id) 
                           VALUES (:judul, :gambar, :tanggal, :penulis, :kategori, :isi, :penulis_id)");
    $stmt->execute([
        'judul' => $judul,
        'gambar' => $gambar_data,
        'tanggal' => $tanggal,
        'penulis' => $penulis,
        'kategori' => $kategori,
        'isi' => $isi,
        'penulis_id' => $penulis_id
    ]);

    // Redirect ke halaman daftar artikel
    header('Location: /DUAAARRR_BLOG-MAIN/index.php');
    exit;
}
?>
