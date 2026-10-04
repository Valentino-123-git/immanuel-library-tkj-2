<?php
$pageTitle = "Edit Kategori";
$pageSubtitle = "Kelola data sistem perpustakaan";
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pageTitle; ?> - Perpustakaan Digital</title>
  <link rel="stylesheet" href="../../styles/categories/edit.css">
</head>
<body>
  <?php
  $category = [
      "id"          => 1,
      "name"        => "Fiksi",
      "description" => "Novel dan cerita rekaan",
  ];
  ?>
  <div class="app-shell">
   <?php require_once '../../components/admin/sidebar.php'; ?>
   <?php require_once '../../components/admin/topbar.php'; ?>

    <main class="app-main">

      <div class="app-content">
        <form method="" action="">
          <input type="hidden" name="id" value="<?= $category['id'] ?>">
          <div class="form-card">
            <div class="form-section-title">Data Kategori</div>
            <div class="form-group">
              <label for="name">Nama Kategori</label>
              <input type="text" id="name" name="name" value="<?= $category['name'] ?>">
            </div>
            <div class="form-group">
              <label for="description">Deskripsi</label>
              <textarea id="description" name="description" rows="3"><?= $category['description'] ?></textarea>
            </div>

            <div class="form-actions">
              <a href="index.php" class="btn btn-outline">Batal</a>
              <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
          </div>
        </form>
      </div>
    </main>
  </div>
</body>
</html>
