<?php
session_start();
require_once "../../config/database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $id   = $_POST['id'] ?? null;
    $name = trim($_POST['name'] ?? '');

    if (!$id || empty($name)) {
        $_SESSION['error'] = "Data tidak valid atau nama kategori kosong!";
        header("Location: ../../pages/categories/edit.php?id=" . $id);
        exit();
    }

    $stmt = $conn->prepare("UPDATE categories SET name = ? WHERE id = ?");
    $stmt->bind_param("si", $name, $id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Kategori berhasil diperbarui!";
    } else {
        $_SESSION['error'] = "Gagal memperbarui kategori: " . $conn->error;
    }

    $stmt->close();
}

header("Location: ../../pages/categories/index.php");
exit();
?>