<?php
session_start();
require_once "../../config/database.php";

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Buku berhasil dihapus!";
    } else {
        $_SESSION['error'] = "Gagal menghapus buku: " . $conn->error;
    }

    $stmt->close();
} else {
    $_SESSION['error'] = "ID buku tidak valid!";
}

header("Location: ../../pages/books/index.php");
exit();
?>