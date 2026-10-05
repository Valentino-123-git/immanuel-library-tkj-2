<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah user sudah login
if (!isset($_SESSION['is_login']) || $_SESSION['is_login'] !== true) {
    $_SESSION['error'] = "Anda harus login terlebih dahulu untuk mengakses halaman ini!";
    header("Location: ../../pages/auth/login.php");
    exit();
}
?>