<?php
// Koneksi database
require_once __DIR__ . '/../database.php';

// Periksa apakah ada id yang dikirim
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Mulai transaksi untuk memastikan konsistensi data
    $conn->begin_transaction();

    try {
        // Hapus komentar yang terkait dengan artikel
        $sql_delete_comments = "DELETE FROM comments WHERE article_id = ?";
        $stmt_comments = $conn->prepare($sql_delete_comments);
        $stmt_comments->bind_param("i", $id);
        $stmt_comments->execute();

        // Hapus artikel
        $sql_delete_article = "DELETE FROM articles WHERE id = ?";
        $stmt_article = $conn->prepare($sql_delete_article);
        $stmt_article->bind_param("i", $id);
        $stmt_article->execute();

        // Commit transaksi jika semuanya berhasil
        $conn->commit();

        header('Location: /DUAAARRR_BLOG/daftar_artikel.php');
    } catch (Exception $e) {
        // Rollback jika ada error
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
}
?>
