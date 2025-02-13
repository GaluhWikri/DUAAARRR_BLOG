<?php
// Koneksi database
require_once __DIR__ . '/../database.php';


// Periksa apakah ada id yang dikirim
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Query untuk menghapus artikel berdasarkan ID
    $sql = "DELETE FROM articles WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header('Location: /Keamanan%20Perangkat%20Lunak/daftar_artikel.php');
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}
?>
