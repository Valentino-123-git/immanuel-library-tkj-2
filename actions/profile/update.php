<?php
session_start();
require_once "../../config/database.php";

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../pages/auth/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $user_id  = $_SESSION['user_id'];
    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($name) || empty($email)) {
        $_SESSION['error'] = "Nama dan email tidak boleh kosong!";
        header("Location: ../../pages/profile/index.php");
        exit();
    }

    // Jika pengguna ingin mengubah password
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $email, $hashed_password, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $email, $user_id);
    }

    if ($stmt->execute()) {
        $_SESSION['user_name'] = $name; // Update session nama
        $_SESSION['success']   = "Profil berhasil diperbarui!";
    } else {
        $_SESSION['error']     = "Gagal memperbarui profil: " . $conn->error;
    }

    $stmt->close();
}

header("Location: ../../pages/profile/index.php");
exit();
?>