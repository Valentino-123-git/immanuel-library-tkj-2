<?php
// Tentukan menu aktif dari nama folder halaman saat ini (books, categories, dst.)
$currentSection = basename(dirname($_SERVER['SCRIPT_NAME']));
?>
<aside class="app-sidebar">
    <div class="brand">
        <span class="logo-badge">IL</span>
        <span>Immanuel Library</span>
    </div>
    <nav>
        <a href="../../pages/books/index.php" class="<?= $currentSection === 'books' ? 'active' : '' ?>">Manajemen Buku</a>
        <a href="../../pages/categories/index.php" class="<?= $currentSection === 'categories' ? 'active' : '' ?>">Manajemen Kategori</a>
        <a href="../../pages/authors/index.php" class="<?= $currentSection === 'authors' ? 'active' : '' ?>">Manajemen Penulis</a>
        <a href="../../pages/users/index.php" class="<?= $currentSection === 'users' ? 'active' : '' ?>">Manajemen Pengguna</a>
        <a href="../../pages/profile/edit.php" class="<?= $currentSection === 'profile' ? 'active' : '' ?>">Profil Saya</a>
    </nav>
</aside>