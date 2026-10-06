<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Mengunci jalur folder secara absolut dari lokasi file ini
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Email dan password wajib diisi!";
        header("Location: ../../pages/auth/login.php");
        exit();
    }

    // Cari pengguna berdasarkan email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Cek password (mendukung hash password_verify maupun plain text)
        if (password_verify($password, $user['password']) || $password === $user['password']) {
            $_SESSION['is_login']  = true;
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role']      = $user['role'] ?? 'user';

            header("Location: ../../pages/dashboard.php");
            exit();
        }
    }

    $_SESSION['error'] = "Email atau password salah!";
    header("Location: ../../pages/auth/login.php");
    exit();
} else {
    header("Location: ../../pages/auth/login.php");
    exit();
}