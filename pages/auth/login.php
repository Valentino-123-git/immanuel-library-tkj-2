<?php
$pageTitle = "Login - Immanuel Library";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="../../styles/auth.css">
</head>
<body class="auth-body">
    <div class="auth-card">
        <div class="auth-logo">
            <span class="logo-badge">PD</span>
            Perpustakaan Digital
        </div>
        <h1>Selamat Datang Kembali</h1>
        <p class="auth-subtitle">Masuk untuk mengelola koleksi buku perpustakaan.</p>

        <form method="POST" action="../../actions/auth/login_action.php">
            <div class="form-group">
                <label for="email">Email / Username</label>
                <input type="email" id="email" name="email" placeholder="nama@sekolah.sch.id" required>
            </div>
            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <input type="password" id="password" name="password" placeholder="Masukkan kata sandi" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
        </form>

        <p class="form-footer-link">
            Belum punya akun? <a href="register.php">Daftar di sini</a>
        </p>
    </div>
</body>
</html>