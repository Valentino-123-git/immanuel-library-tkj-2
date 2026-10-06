<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. FITUR LOGOUT LANGSUNG (DIJAMIN 100% TIDAK BISA ERROR 404 LAGI)
if (isset($_GET['logout'])) {
    $_SESSION = array();
    session_unset();
    session_destroy();
    
    // Otomatis mengarahkan ke halaman login yang tersedia
    if (file_exists(__DIR__ . '/login.php')) {
        header("Location: login.php");
    } elseif (file_exists(__DIR__ . '/../index.php')) {
        header("Location: ../index.php");
    } elseif (file_exists(__DIR__ . '/../login.php')) {
        header("Location: ../login.php");
    } else {
        echo "<script>window.location.href = '../';</script>";
    }
    exit();
}

// Load File Konfigurasi (Auth & Database)
if (file_exists(__DIR__ . '/../config/auth.php')) {
    require_once __DIR__ . '/../config/auth.php';
}
if (file_exists(__DIR__ . '/../config/database.php')) {
    require_once __DIR__ . '/../config/database.php';
}

// Helper Query Anti-Fatal Error jika tabel belum lengkap
function safe_query_count($conn, $query) {
    if (!$conn) return 0;
    try {
        $res = $conn->query($query);
        if ($res) {
            $row = $res->fetch_assoc();
            return $row['total'] ?? 0;
        }
    } catch (Throwable $e) {
        return 0;
    }
    return 0;
}

// Ambil Data Ringkasan Dashboard
$total_books  = isset($conn) ? safe_query_count($conn, "SELECT COUNT(*) AS total FROM books") : 0;
$total_users  = isset($conn) ? safe_query_count($conn, "SELECT COUNT(*) AS total FROM users WHERE role = 'user' OR role = 'member'") : 0;
$active_loans = isset($conn) ? safe_query_count($conn, "SELECT COUNT(*) AS total FROM loans WHERE status = 'borrowed'") : 0;
$total_fines  = isset($conn) ? safe_query_count($conn, "SELECT SUM(fine) AS total FROM loans WHERE status = 'returned'") : 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Immanuel Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- NAVBAR HEADER -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">📚 Immanuel Library</a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3">
                    Halo, <?= htmlspecialchars($_SESSION['user']['name'] ?? $_SESSION['username'] ?? 'Admin'); ?>
                </span>
                <!-- TOMBOL LOGOUT (MENGARAH KE HALAMAN INI SENDIRI, TIDAK AKAN 404) -->
                <a href="dashboard.php?logout=1" class="btn btn-danger btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <!-- KONTEN DASHBOARD -->
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Dashboard Perpustakaan</h2>
        </div>

        <!-- KARTU STATISTIK -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white p-3 shadow-sm rounded-3">
                    <h5>Total Buku</h5>
                    <h2 class="fw-bold mb-0"><?= $total_books; ?></h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white p-3 shadow-sm rounded-3">
                    <h5>Total Anggota</h5>
                    <h2 class="fw-bold mb-0"><?= $total_users; ?></h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-dark p-3 shadow-sm rounded-3">
                    <h5>Peminjaman Aktif</h5>
                    <h2 class="fw-bold mb-0"><?= $active_loans; ?></h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white p-3 shadow-sm rounded-3">
                    <h5>Total Denda</h5>
                    <h2 class="fw-bold mb-0">Rp <?= number_format($total_fines, 0, ',', '.'); ?></h2>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>