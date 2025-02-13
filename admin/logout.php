<?php
session_start();  // Mulai sesi

// Hancurkan semua session yang aktif
session_unset(); // Menghapus semua variabel sesi
session_destroy(); // Menghancurkan sesi

// Redirect ke halaman login setelah logout
header('Location: /Keamanan%20Perangkat%20Lunak/index.php');
exit();
?>
