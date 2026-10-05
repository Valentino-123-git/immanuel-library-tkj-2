<?php
session_start();
require_once "../../config/database.php";

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Pengguna berhasil dihapus!";
    } else {
        $_SESSION['error'] = "Gagal menghapus pengguna: " . $conn->error;
    }

    $stmt->close();
} else {
    $_SESSION['error'] = "ID pengguna tidak valid!";
}

header("Location: ../../pages/users/index.php");
exit();
?>