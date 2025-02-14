<?php
session_start();
require_once __DIR__ . '/../database.php';
date_default_timezone_set('Asia/Jakarta');


// Ambil ID artikel dari URL
$id = $_GET['id'];

// Query untuk mengambil data artikel berdasarkan ID
$sql = "SELECT * FROM articles WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$article = $result->fetch_assoc();

// Proses pengeditan artikel
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $isi = $_POST['isi'];
    $kategori = $_POST['kategori'];
    $updated_at = date('Y-m-d H:i:s'); // Sekarang sesuai zona waktu Indonesia


    // Periksa apakah ada gambar baru yang diunggah
    if (!empty($_FILES['gambar']['tmp_name'])) {
        $gambar = file_get_contents($_FILES['gambar']['tmp_name']); // Konversi gambar ke format BLOB
    } else {
        // Ambil gambar lama jika tidak ada yang diunggah
        $gambar = $article['gambar'];
    }

    // Query untuk memperbarui artikel
    $update_sql = "UPDATE articles SET gambar = ?, judul = ?, penulis = ?, isi = ?, kategori = ?, updated_at = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssssi", $gambar, $judul, $penulis, $isi, $kategori, $updated_at, $id);

    if ($update_stmt->execute()) {
        header('Location: /DUAAARRR_BLOG/daftar_artikel.php');
        exit();
    } else {
        echo "Error: " . $update_stmt->error;
    }
}
?>

<script src="https://cdn.tailwindcss.com"></script>

<form action="edit_article.php?id=<?= $article['id']; ?>" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto">
    <h2 class="text-lg font-bold mb-4">Edit Artikel</h2>




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