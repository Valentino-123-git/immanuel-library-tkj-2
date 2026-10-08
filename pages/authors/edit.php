<?php
require_once '../../repositories/author-repository.php';

$pageTitle = "Edit Penulis";
$pageSubtitle = "Kelola data sistem perpustakaan";

$author = getAuthor($_GET['id'] ?? 0);
if (!$author) {
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
  <link rel="stylesheet" href="../../styles/authors/edit.css">
</head>

<body>
  <div class="app-shell">
    <?php require_once '../../components/admin/sidebar.php'; ?>
    
    <main class="app-main">
      <?php require_once '../../components/admin/topbar.php'; ?>


      <div class="app-content">
        <form method="POST" action="../../actions/authors/update.php">
          <input type="hidden" name="id" value="<?= $author['id'] ?>">
          <div class="form-card">
            <div class="form-section-title">Data Penulis</div>
            <div class="form-group">
              <label for="name">Nama Penulis</label>
              <input type="text" id="name" name="name" value="<?= htmlspecialchars($author['name']) ?>">
            </div>
            <div class="form-group">
              <label for="bio">Biografi Singkat</label>
              <textarea id="bio" name="bio" rows="3"><?= htmlspecialchars($author['bio']) ?></textarea>
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