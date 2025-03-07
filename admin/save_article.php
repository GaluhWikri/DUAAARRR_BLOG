<?php
session_start();
require_once __DIR__ . '/../database.php';

// Set timezone Indonesia (WIB)
date_default_timezone_set('Asia/Jakarta');

// Generate CSRF token jika belum ada
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi CSRF Token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error'] = "Invalid CSRF token.";
        header('Location: /DUAAARRR_BLOG-MAIN/tambah_artikel.php');
        exit;
    }

    // Jangan hapus token setelah request
    // $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    // Ambil data dari form
    $penulis_id = $_SESSION['user_id'] ?? null;
    $judul = trim($_POST['judul'] ?? '');
    $penulis = trim($_POST['penulis'] ?? '');
    $kategori = trim($_POST['kategori'] ?? '');
    $isi = trim($_POST['isi'] ?? '');
    $tanggal = date('Y-m-d H:i:s');

    // Validasi input
    if (strlen($judul) < 5 || strlen($judul) > 100) {
        $_SESSION['error'] = "Judul harus antara 5-100 karakter.";
        header('Location: /DUAAARRR_BLOG-MAIN/tambah_artikel.php');
        exit;
    }
    if (strlen($penulis) < 3 || strlen($penulis) > 50) {
        $_SESSION['error'] = "Nama penulis harus antara 3-50 karakter.";
        header('Location: /DUAAARRR_BLOG-MAIN/tambah_artikel.php');
        exit;
    }
    if (strlen($isi) < 50) {
        $_SESSION['error'] = "Isi artikel minimal 50 karakter.";
        header('Location: /DUAAARRR_BLOG-MAIN/tambah_artikel.php');
        exit;
    }

    // Validasi file gambar
    $gambar_data = null;
    if (!empty($_FILES['gambar']['tmp_name']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $fileType = mime_content_type($_FILES['gambar']['tmp_name']);
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

        if (!in_array($fileType, $allowedTypes)) {
            $_SESSION['error'] = "Format gambar tidak didukung. Hanya JPG, PNG, dan GIF yang diperbolehkan.";
            header('Location: /DUAAARRR_BLOG-MAIN/tambah_artikel.php');
            exit;
        }

        if ($_FILES['gambar']['size'] > 2 * 1024 * 1024) {
            $_SESSION['error'] = "Ukuran gambar terlalu besar. Maksimal 2MB.";
            header('Location: /DUAAARRR_BLOG-MAIN/tambah_artikel.php');
            exit;
        }

        $gambar_data = file_get_contents($_FILES['gambar']['tmp_name']);
    } else {
        $_SESSION['error'] = "Gagal mengupload gambar.";
        header('Location: /DUAAARRR_BLOG-MAIN/tambah_artikel.php');
        exit;
    }

    // Simpan ke database
    try {
        $stmt = $pdo->prepare("INSERT INTO articles (judul, gambar, tanggal, penulis, kategori, isi, penulis_id) 
                               VALUES (:judul, :gambar, :tanggal, :penulis, :kategori, :isi, :penulis_id)");
        $stmt->bindParam(':judul', $judul, PDO::PARAM_STR);
        $stmt->bindParam(':gambar', $gambar_data, PDO::PARAM_LOB);
        $stmt->bindParam(':tanggal', $tanggal, PDO::PARAM_STR);
        $stmt->bindParam(':penulis', $penulis, PDO::PARAM_STR);
        $stmt->bindParam(':kategori', $kategori, PDO::PARAM_STR);
        $stmt->bindParam(':isi', $isi, PDO::PARAM_STR);
        $stmt->bindParam(':penulis_id', $penulis_id, PDO::PARAM_INT);
        $stmt->execute();

        $_SESSION['success'] = "Artikel berhasil ditambahkan.";
        header('Location: /DUAAARRR_BLOG-MAIN/index.php');
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Gagal menyimpan artikel: " . $e->getMessage();
        header('Location: /DUAAARRR_BLOG-MAIN/tambah_artikel.php');
        exit;
    }
}
?>
