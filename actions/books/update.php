<?php
session_start();
require_once "../../config/database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $id          = $_POST['id'] ?? null;
    $title       = trim($_POST['title'] ?? '');
    $author_ids  = $_POST['author_ids'] ?? [];   // form mengirim array (author_ids[])
    $category_id = $_POST['category_id'] ?? null;
    $stock       = (int) ($_POST['stock'] ?? 0);

    if (!$id || empty($title) || empty($author_ids)) {
        $_SESSION['error'] = "Data tidak valid, judul atau penulis kosong!";
        header("Location: ../../pages/books/edit.php?id=" . $id);
        exit();
    }

    // Kolom books.author_id hanya menyimpan satu penulis, jadi ambil penulis pertama
    $author_id = (int) $author_ids[0];

    $stmt = $conn->prepare("UPDATE books SET title = ?, author_id = ?, category_id = ?, stock = ? WHERE id = ?");
    $stmt->bind_param("siiii", $title, $author_id, $category_id, $stock, $id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Data buku berhasil diperbarui!";
    } else {
        $_SESSION['error'] = "Gagal memperbarui data buku: " . $conn->error;
    }

    $stmt->close();
}

header("Location: ../../pages/books/index.php");
exit();
?>