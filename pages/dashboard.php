<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/database.php';

// Fungsi penanganan query agar web TIDAK AKAN PERNAH Fatal Error jika data/tabel kosong
function safe_query_count($conn, $query) {
    try {
        $res = $conn->query($query);
        if ($res) {
            $row = $res->fetch_assoc();
            return $row['total'] ?? 0;
        }
    } catch (Throwable $e) {
        return 0; // Jika tabel belum ada / error, otomatis mengembalikan angka 0
    }
    return 0;
}

// 1. Hitung Total Buku
$total_books = safe_query_count($conn, "SELECT COUNT(*) AS total FROM books");

// 2. Hitung Total Anggota/User
$total_users = safe_query_count($conn, "SELECT COUNT(*) AS total FROM users WHERE role = 'user' OR role = 'member'");

// 3. Hitung Peminjaman Aktif (Belum Kembali)
$active_loans = safe_query_count($conn, "SELECT COUNT(*) AS total FROM loans WHERE status = 'borrowed'");

// 4. Hitung Total Denda Terkumpul
$total_fines = safe_query_count($conn, "SELECT SUM(fine) AS total FROM loans WHERE status = 'returned'");
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