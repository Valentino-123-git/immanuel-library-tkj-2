<?php
session_start();
require_once "../../config/database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role     = $_POST['role'] ?? 'member'; // Default role: member

    if (empty($name) || empty($email) || empty($password)) {
        $_SESSION['error'] = "Nama, email, dan password wajib diisi!";
        header("Location: ../../pages/users/create.php");
        exit();
    }

    // Enkripsi password demi keamanan
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $hashed_password, $role);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Pengguna berhasil ditambahkan!";
    } else {
        $_SESSION['error'] = "Gagal menambahkan pengguna: " . $conn->error;
    }

    $stmt->close();
}

header("Location: ../../pages/users/index.php");
exit();
?>