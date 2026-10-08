<?php
require_once '../../repositories/user-repository.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$pageTitle = "Profil Saya";
$pageSubtitle = "Kelola data sistem perpustakaan";

// Ambil data user yang sedang login (fallback ke user pertama jika id sesi tidak ada di repository)
$userId  = $_SESSION['user_id'] ?? 1;
$user    = getUser($userId) ?? getUsers()[0];
$profile = getProfile($user['id']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pageTitle; ?> - Perpustakaan Digital</title>
  <link rel="stylesheet" href="../../styles/profile/edit.css">
</head>
<body>
  <div class="app-shell">
   <?php require_once '../../components/admin/sidebar.php'; ?>
   <?php require_once '../../components/admin/topbar.php'; ?>

    <main class="app-main">

      <div class="app-content">
        <form method="POST" action="../../actions/profile/update.php">
          <div class="form-card" style="margin-bottom:20px;">
            <div class="form-section-title">Data Akun</div>
            <div class="form-row">
              <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>">
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>">
              </div>
            </div>
            <div class="form-group">
              <label>Role</label>
              <input type="text" value="<?= ucfirst($user['role']) ?>" disabled>
              <p class="form-help">Role hanya dapat diubah oleh Admin melalui menu Manajemen Pengguna.</p>
            </div>
          </div>

          <div class="form-card">
            <div class="form-section-title">Data Profil</div>
            <div class="form-group">
              <label for="phone">Nomor Telepon</label>
              <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($profile['phone']) ?>">
            </div>
            <div class="form-group">
              <label for="address">Alamat</label>
              <input type="text" id="address" name="address" value="<?= htmlspecialchars($profile['address']) ?>">
            </div>
            <div class="form-group">
              <label for="bio">Bio Singkat</label>
              <textarea id="bio" name="bio" rows="3"><?= htmlspecialchars($profile['bio']) ?></textarea>
            </div>
            <div class="form-actions">
              <a href="../dashboard.php" class="btn btn-outline">Batal</a>
              <button type="submit" name="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
          </div>
        </form>
      </div>
    </main>
  </div>
</body>
</html>