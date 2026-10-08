<?php
require_once '../../repositories/user-repository.php';

$pageTitle = "Edit Pengguna";
$pageSubtitle = "Kelola data sistem perpustakaan";

$user = getUser($_GET['id'] ?? 0);
if (!$user) {
  header("Location: index.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pageTitle; ?> - Perpustakaan Digital</title>
  <link rel="stylesheet" href="../../styles/users/edit.css">
</head>
<body>
  <div class="app-shell">
   <?php require_once '../../components/admin/sidebar.php'; ?>
   <?php require_once '../../components/admin/topbar.php'; ?>

    <main class="app-main">

      <div class="app-content">
        <form method="POST" action="../../actions/users/update.php">
          <input type="hidden" name="id" value="<?= $user['id'] ?>">
          <div class="form-card">
            <div class="form-section-title">Data Pengguna</div>
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
              <label for="role">Role</label>
              <select id="role" name="role">
                <option value="member" <?= $user['role'] === 'member' ? 'selected' : '' ?>>Member</option>
                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
              </select>
            </div>

            <div class="form-actions">
              <a href="index.php" class="btn btn-outline">Batal</a>
              <button type="submit" name="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
          </div>
        </form>
      </div>
    </main>
  </div>
</body>
</html>