<?php
$host = 'localhost'; // Nama host
$dbname = 'boooooom'; // Nama database
$username = 'root'; // Username
$password = ''; // Password (jika ada)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
