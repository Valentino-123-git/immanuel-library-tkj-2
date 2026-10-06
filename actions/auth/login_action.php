<?php
session_start();
require_once __DIR__ . "/../../config/database.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Email dan password wajib diisi!";
        header("Location: ../../pages/auth/login.php");
        exit();
    }

    $stmt = $conn->prepare("SELECT id, name, email, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verifikasi password hash
        if (password_verify($password, $user['password'])) {
            // Simpan data login ke session
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['is_login']   = true;

            $_SESSION['success'] = "Selamat datang kembali, " . $user['name'] . "!";
            header("Location: ../../index.php"); // Atau ke pages/dashboard.php
            exit();
        }
    }

    $_SESSION['error'] = "Email atau password salah!";
    header("Location: ../../pages/auth/login.php");
    exit();
}
?>