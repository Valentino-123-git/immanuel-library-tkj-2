<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$title = isset($pageTitle) ? $pageTitle : 'Panel Admin';
$subtitle = isset($pageSubtitle) ? $pageSubtitle : 'Sistem Informasi Perpustakaan Immanuel';
$userName = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Admin Immanuel';
?>
<header class="app-topbar">
    <div class="page-title">
        <h1><?php echo htmlspecialchars($title); ?></h1>
        <p><?php echo htmlspecialchars($subtitle); ?></p>
    </div>
    <div class="topbar-user">
        <span class="avatar"><?php echo htmlspecialchars(strtoupper(substr($userName, 0, 1))); ?></span>
        <span><?php echo htmlspecialchars($userName); ?></span>
        <a href="../../actions/auth/logout_action.php" class="btn btn-outline btn-sm" onclick="return confirm('Apakah Anda yakin ingin keluar?');">Logout</a>
    </div>
</header>