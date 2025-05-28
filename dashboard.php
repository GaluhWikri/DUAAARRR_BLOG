<?php
session_start();
require_once 'database.php';

// Generate CSRF Token jika belum ada
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Validasi input jika form dikirimkan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo "<script>alert('Invalid CSRF Token!'); window.location.href = 'dashboard.php';</script>";
        exit;
    }

    $judul = trim($_POST['judul']);
    $penulis = trim($_POST['penulis']);
    $kategori = trim($_POST['kategori']);
    $isi = trim($_POST['isi']);

    // Cek apakah ada file gambar yang diunggah
    if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] !== UPLOAD_ERR_OK) {
        echo "<script>alert('Gagal mengunggah gambar!'); window.location.href = 'dashboard.php';</script>";
        exit;
    }

    // Baca file gambar sebagai binary
    $gambar_tmp = $_FILES['gambar']['tmp_name'];
    $gambar_data = file_get_contents($gambar_tmp);

    // Simpan ke database dengan Named Parameter
    $sql = "INSERT INTO articles (judul, penulis, kategori, isi, gambar, tanggal) 
            VALUES (:judul, :penulis, :kategori, :isi, :gambar, NOW())";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':judul', $judul);
    $stmt->bindParam(':penulis', $penulis);
    $stmt->bindParam(':kategori', $kategori);
    $stmt->bindParam(':isi', $isi);
    $stmt->bindParam(':gambar', $gambar_data, PDO::PARAM_LOB); // Simpan gambar sebagai BLOB

    if ($stmt->execute()) {
        echo "<script>alert('Artikel berhasil ditambahkan!'); window.location.href = 'daftar_artikel.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan artikel!'); window.location.href = 'dashboard.php';</script>";
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Tambah Artikel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <header>
        <a href="index.php" style="text-decoration: none; color: inherit;">
            <div class="logo">BOOOOOOOM</div>
        </a>
        <nav>
            <a href="daftar_artikel.php">LIST ARTICLES</a>
        </nav>
    </header>

    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Tambah Artikel Baru</h2>
        <form id="articleForm" action="" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            <div class="mb-4">
                <label for="judul" class="block text-sm font-medium text-gray-700">Judul Artikel</label>
                <input type="text" id="judul" name="judul" class="mt-1 block w-full" required>
            </div>

            <div class="mb-4">
                <label for="gambar" class="block text-sm font-medium text-gray-700">Upload Gambar</label>
                <input type="file" id="gambar" name="gambar" class="mt-1 block w-full" required>
            </div>

            <div class="mb-4">
                <label for="penulis" class="block text-sm font-medium text-gray-700">Penulis</label>
                <input type="text" id="penulis" name="penulis" class="mt-1 block w-full" required>
            </div>

            <div class="mb-4">
                <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select id="kategori" name="kategori" class="mt-1 block w-full" required>
                    <option value="Art">Art</option>
                    <option value="Design">Design</option>
                    <option value="Illustration">Illustration</option>
                    <option value="Photography">Photography</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="isi" class="block text-sm font-medium text-gray-700">Isi Artikel</label>
                <textarea id="isi" name="isi" rows="6" class="mt-1 block w-full" required></textarea>
            </div>

            <button type="submit" class="bg-black text-white px-4 py-2 rounded-md">Tambah Artikel</button>
        </form>
    </div>
</body>
</html>
