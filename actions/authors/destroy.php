<?php
session_start();
require_once "../../config/database.php";

$id = $_GET['id'] ?? null;

if ($id) {
    // Query hapus data
    $stmt = $conn->prepare("DELETE FROM authors WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Penulis berhasil dihapus!";
    } else {
        $_SESSION['error'] = "Gagal menghapus data: " . $conn->error;
    }

    $stmt->close();
} else {
    $_SESSION['error'] = "ID penulis tidak valid!";
}

header("Location: ../../pages/authors/index.php");
exit();
?>