<?php
session_start();
require_once __DIR__ . '/../database.php';
date_default_timezone_set('Asia/Jakarta');

// Generate CSRF Token jika belum ada
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Validasi ID artikel pada GET request
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('ID artikel tidak valid!'); window.location.href = 'daftar_artikel.php';</script>";
    exit;
}

$id = $_GET['id'];

// Query untuk mengambil data artikel berdasarkan ID dengan named parameter
$sql = "SELECT * FROM articles WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$article) {
    echo "<script>alert('Artikel tidak ditemukan!'); window.location.href = 'daftar_artikel.php';</script>";
    exit;
}

// Proses pengeditan artikel
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo "<script>alert('Invalid CSRF Token!'); window.location.href = 'edit_article.php?id=$id';</script>";
        exit;
    }

    $judul = trim($_POST['judul']);
    $penulis = trim($_POST['penulis']);
    $isi = trim($_POST['isi']);
    $kategori = trim($_POST['kategori']);
    $updated_at = date('Y-m-d H:i:s'); // Zona waktu Indonesia

    // Validasi input tidak boleh kosong
    if (empty($judul) || empty($penulis) || empty($isi) || empty($kategori)) {
        echo "<script>alert('Semua kolom harus diisi!'); window.location.href = 'edit_article.php?id=$id';</script>";
        exit;
    }

    // Periksa apakah ada gambar baru yang diunggah
    if (!empty($_FILES['gambar']['tmp_name'])) {
        $gambar = file_get_contents($_FILES['gambar']['tmp_name']); // Konversi gambar ke format BLOB
    } else {
        $gambar = $article['gambar']; // Gunakan gambar lama jika tidak ada yang diunggah
    }

    // Query update menggunakan Named Parameter
    $update_sql = "UPDATE articles 
                SET gambar = :gambar, judul = :judul, penulis = :penulis, isi = :isi, kategori = :kategori, updated_at = :updated_at 
                WHERE id = :id";

    $update_stmt = $pdo->prepare($update_sql);
    $update_stmt->bindParam(':gambar', $gambar, PDO::PARAM_LOB);
    $update_stmt->bindParam(':judul', $judul, PDO::PARAM_STR);  
    $update_stmt->bindParam(':penulis', $penulis, PDO::PARAM_STR);
    $update_stmt->bindParam(':isi', $isi, PDO::PARAM_STR);
    $update_stmt->bindParam(':kategori', $kategori, PDO::PARAM_STR);
    $update_stmt->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
    $update_stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($update_stmt->execute()) {
        echo "<script>alert('Artikel berhasil diperbarui!'); window.location.href = '../daftar_artikel.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui artikel!'); window.location.href = 'edit_article.php?id=$id';</script>";
    }
}
?>

<script src="https://cdn.tailwindcss.com"></script>

<form action="edit_article.php?id=<?= $article['id']; ?>" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto">
    <h2 class="text-lg font-bold mb-4">Edit Artikel</h2>

    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

    <!-- Judul -->
    <div class="mb-4">
        <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
        <input type="text" id="judul" name="judul" value="<?= htmlspecialchars($article['judul']); ?>" required
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-black focus:border-black sm:text-sm">
    </div>

    <!-- Gambar -->
    <div class="mb-4">
        <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar</label>
        <input type="file" id="gambar" name="gambar" accept="image/*"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-black focus:border-black sm:text-sm">
    </div>

    <!-- Penulis -->
    <div class="mb-4">
        <label for="penulis" class="block text-sm font-medium text-gray-700">Penulis</label>
        <input type="text" id="penulis" name="penulis" value="<?= htmlspecialchars($article['penulis']); ?>" required
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-black focus:border-black sm:text-sm">
    </div>

    <!-- Isi Artikel -->
    <div class="mb-4">
        <label for="isi" class="block text-sm font-medium text-gray-700">Isi Artikel</label>
        <textarea id="isi" name="isi" rows="6" required
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-black focus:border-black sm:text-sm"><?= htmlspecialchars($article['isi']); ?></textarea>
    </div>

    <!-- Kategori -->
    <div class="mb-4">
        <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
        <select id="kategori" name="kategori" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-black focus:border-black sm:text-sm" required>
            <option value="Art" <?= $article['kategori'] == 'Art' ? 'selected' : ''; ?>>Art</option>
            <option value="Design" <?= $article['kategori'] == 'Design' ? 'selected' : ''; ?>>Design</option>
            <option value="Illustration" <?= $article['kategori'] == 'Illustration' ? 'selected' : ''; ?>>Illustration</option>
            <option value="Photography" <?= $article['kategori'] == 'Photography' ? 'selected' : ''; ?>>Photography</option>
        </select>
    </div>

    <!-- Tanggal Diedit -->
    <p class="text-sm text-gray-500">
        Terakhir diperbarui: <?= $article['updated_at'] ? date('d M Y, H:i', strtotime($article['updated_at'])) : date('d M Y, H:i', strtotime($article['tanggal'])); ?>
    </p>

    <!-- Tombol Submit -->
    <div class="flex justify-end">
        <button type="submit" class="bg-black text-white px-4 py-2 rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
            Simpan Perubahan
        </button>
    </div>
</form>