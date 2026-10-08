<?php
session_start();
require_once "../../config/database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $name = trim($_POST['name'] ?? '');

    if (empty($name)) {
        $_SESSION['error'] = "Nama kategori wajib diisi!";
        header("Location: ../../pages/categories/create.php");
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
    $stmt->bind_param("s", $name);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Kategori berhasil ditambahkan!";
    } else {
        $_SESSION['error'] = "Gagal menambahkan kategori: " . $conn->error;
    }

    $stmt->close();
}

header("Location: ../../pages/categories/index.php");
exit();
?>