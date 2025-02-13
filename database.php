<?php
$host = 'localhost';  // Sesuaikan dengan host Anda
$dbname = 'article_db'; // Sesuaikan dengan nama database
$username = 'root'; // Sesuaikan dengan username database
$password = ''; // Sesuaikan dengan password database (kosongkan jika default)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage() . " pada " . $e->getFile() . " baris " . $e->getLine());
}

// Membuat koneksi ke database MySQL
$conn = new mysqli($host, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>



