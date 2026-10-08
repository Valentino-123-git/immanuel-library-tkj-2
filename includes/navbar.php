<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand fw-bold" href="../../pages/dashboard.php">
      <i class="fa-solid fa-book-open me-2"></i>Immanuel Library
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="../../pages/books/index.php">Manajemen Buku</a></li>
        <li class="nav-item"><a class="nav-link" href="../../pages/categories/index.php">Manajemen Kategori</a></li>
        <li class="nav-item"><a class="nav-link" href="../../pages/authors/index.php">Manajemen Penulis</a></li>
        <li class="nav-item"><a class="nav-link" href="../../pages/users/index.php">Manajemen Pengguna</a></li>
      </ul>
      <div class="d-flex align-items-center text-white gap-3">
        <span>Halo, <b><?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin'); ?></b></span>
        <a href="../../actions/auth/logout_action.php" class="btn btn-outline-danger btn-sm">Logout</a>
      </div>
    </div>
  </div>
</nav>