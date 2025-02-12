<?php 

    $conn = mysqli_connect("localhost", "root", "", "WebBlog");

    if(mysqli_connect_errno()){
        echo "Gagal koneksi ke database" . mysqli_connect_error();
        exit();
    }
?>