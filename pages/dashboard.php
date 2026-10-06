<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/database.php';

// 1. Hitung Total Buku
$res_books = $conn->query("SELECT COUNT(*) AS total FROM books");
$total_books = ($res_books) ? $res_books->fetch_assoc()['total'] : 0;

// 2. Hitung Total Anggota/User
$res_users = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role = 'user' OR role = 'member'");
$total_users = ($res_users) ? $res_users->fetch_assoc()['total'] : 0;

// 3. Hitung Peminjaman Aktif (Belum Kembali)
$res_loans = $conn->query("SELECT COUNT(*) AS total FROM loans WHERE status = 'borrowed'");
$active_loans = ($res_loans) ? $res_loans->fetch_assoc()['total'] : 0;

// 4. Hitung Total Denda Terkumpul
$res_fines = $conn->query("SELECT SUM(fine) AS total FROM loans WHERE status = 'returned'");
$row_fines = ($res_fines) ? $res_fines->fetch_assoc() : null;
$total_fines = $row_fines['total'] ?? 0;
?>

<head>
    <meta charset="UTF-8">
    <title>Dashboard - Immanuel Library</title>
    <!-- Gunakan Bootstrap 5 CDN untuk tampilan cepat & keren -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Selamat Datang, <?= htmlspecialchars($_SESSION['user_name']); ?>! 👋</h2>
        <a href="../../actions/auth/logout.php" class="btn btn-danger">Logout</a>
    </div>

    <!-- Alert Notifikasi Session -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Kartu Statistik -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Total Buku</h6>
                    <h3 class="card-text"><?= $total_books; ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Total Anggota</h6>
                    <h3 class="card-text"><?= $total_users; ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Peminjaman Aktif</h6>
                    <h3 class="card-text"><?= $active_loans; ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Total Denda Terkumpul</h6>
                    <h3 class="card-text">Rp <?= number_format($total_fines, 0, ',', '.'); ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>