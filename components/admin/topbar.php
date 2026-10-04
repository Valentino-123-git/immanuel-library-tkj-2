<?php
$title = isset($pageTitle) ? $pageTitle : 'Panel Admin';
$subtitle = isset($pageSubtitle) ? $pageSubtitle : 'Sistem Informasi Perpustakaan Immanuel';
?>
<header class="topbar">
    <div class="topbar-left">
        <button id="sidebar-toggle" class="btn-toggle">
            <i class="fas fa-bars"></i>
        </button>
        <div class="page-header-info">
            <h1 class="page-title"><?php echo htmlspecialchars($title); ?></h1>
            <p class="page-subtitle"><?php echo htmlspecialchars($subtitle); ?></p>
        </div>
    </div>
    <div class="topbar-right">
        <div class="user-profile">
            <span class="user-name">
                <?php echo isset($_SESSION['user']['name']) ? htmlspecialchars($_SESSION['user']['name']) : 'Admin Immanuel'; ?>
            </span>
        </div>
        <a href="../../logout.php" class="btn-logout" onclick="return confirm('Apakah Anda yakin ingin keluar?');">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </div>
</header>