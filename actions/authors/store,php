<?php
session_start();
require_once "../../config/database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $name = trim($_POST['name'] ?? '');
    $bio  = trim($_POST['bio'] ?? '');

    // Validasi input
    if (empty($name)) {
        $_SESSION['error'] = "Nama penulis tidak boleh kosong!";
        header("Location: ../../pages/authors/create.php");
        exit();
    }

    // Query simpan data aman dari SQL Injection
    $stmt = $conn->prepare("INSERT INTO authors (name, bio) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $bio);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Penulis berhasil ditambahkan!";
    } else {
        $_SESSION['error'] = "Gagal menyimpan data: " . $conn->error;
    }

    $stmt->close();
}

header("Location: ../../pages/authors/index.php");
exit();
?>