<?php
session_start();
require_once "../../config/database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = trim($_POST['title'] ?? '');
    $author_id   = $_POST['author_id'] ?? null;
    $category_id = $_POST['category_id'] ?? null;
    $stock       = $_POST['stock'] ?? 0;

    if (empty($title) || !$author_id || !$category_id) {
        $_SESSION['error'] = "Semua field wajib diisi!";
        header("Location: ../../pages/books/create.php");
        exit();
    }

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