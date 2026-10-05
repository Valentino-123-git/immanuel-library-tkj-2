<?php
session_start();
require_once "../../config/database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id       = $_POST['id'] ?? null;
    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role     = $_POST['role'] ?? 'member';

    if (!$id || empty($name) || empty($email)) {
        $_SESSION['error'] = "Data tidak valid atau nama/email kosong!";
        header("Location: ../../pages/users/edit.php?id=" . $id);
        exit();
    }

    // Jika password diisi, update password baru. Jika kosong, pertahankan password lama
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, password = ?, role = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $name, $email, $hashed_password, $role, $id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $email, $role, $id);
    }

    if ($stmt->execute()) {
        $_SESSION['success'] = "Data pengguna berhasil diperbarui!";
    } else {
        $_SESSION['error'] = "Gagal memperbarui data pengguna: " . $conn->error;
    }

    $stmt->close();
}

header("Location: ../../pages/users/index.php");
exit();
?>