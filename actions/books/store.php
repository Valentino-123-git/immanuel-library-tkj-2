<?php
session_start();
require_once "../../config/database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $title       = trim($_POST['title'] ?? '');
    $author_ids  = $_POST['author_ids'] ?? [];   // form mengirim array (author_ids[])
    $category_id = $_POST['category_id'] ?? null;
    $stock       = (int) ($_POST['stock'] ?? 0);

    if (empty($title) || empty($author_ids) || !$category_id) {
        $_SESSION['error'] = "Judul, penulis, dan kategori wajib diisi!";
        header("Location: ../../pages/books/create.php");
        exit();
    }

    // Kolom books.author_id hanya menyimpan satu penulis, jadi ambil penulis pertama
    $author_id = (int) $author_ids[0];

    $stmt = $conn->prepare("INSERT INTO books (title, author_id, category_id, stock) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siii", $title, $author_id, $category_id, $stock);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Buku berhasil ditambahkan!";
    } else {
        $_SESSION['error'] = "Gagal menyimpan buku: " . $conn->error;
    }

    $stmt->close();
}

header("Location: ../../pages/books/index.php");
exit();
?>