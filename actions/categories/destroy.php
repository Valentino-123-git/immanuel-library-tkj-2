<?php
session_start();
require_once "../../config/database.php";

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Kategori berhasil dihapus!";
    } else {
        $_SESSION['error'] = "Gagal menghapus kategori: " . $conn->error;
    }

    $stmt->close();
} else {
    $_SESSION['error'] = "ID kategori tidak valid!";
}

header("Location: ../../pages/categories/index.php");
exit();
?>