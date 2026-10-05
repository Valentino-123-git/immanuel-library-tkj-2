<?php
session_start();
require_once "../../config/database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id     = $_POST['user_id'] ?? null;
    $book_id     = $_POST['book_id'] ?? null;
    $borrow_date = date('Y-m-d');
    $due_date    = date('Y-m-d', strtotime('+7 days')); // Jatuh tempo 7 hari

    if (!$user_id || !$book_id) {
        $_SESSION['error'] = "Pilih pengguna dan buku terlebih dahulu!";
        header("Location: ../../pages/loans/create.php");
        exit();
    }

    // Mulai Database Transaction agar data konsisten
    $conn->begin_transaction();

    try {
        // 1. Cek stok buku
        $stmt_check = $conn->prepare("SELECT stock FROM books WHERE id = ? FOR UPDATE");
        $stmt_check->bind_param("i", $book_id);
        $stmt_check->execute();
        $book = $stmt_check->get_result()->fetch_assoc();

        if (!$book || $book['stock'] < 1) {
            throw new Exception("Stok buku tidak mencukupi!");
        }

        // 2. Catat peminjaman
        $stmt_loan = $conn->prepare("INSERT INTO loans (user_id, book_id, borrow_date, due_date, status) VALUES (?, ?, ?, ?, 'borrowed')");
        $stmt_loan->bind_param("iiss", $user_id, $book_id, $borrow_date, $due_date);
        $stmt_loan->execute();

        // 3. Kurangi stok buku
        $stmt_stock = $conn->prepare("UPDATE books SET stock = stock - 1 WHERE id = ?");
        $stmt_stock->bind_param("i", $book_id);
        $stmt_stock->execute();

        // Commit transaksi
        $conn->commit();
        $_SESSION['success'] = "Peminjaman berhasil dicatat! Batas pengembalian: " . $due_date;

    } catch (Exception $e) {
        // Batalkan semua perubahan jika terjadi error
        $conn->rollback();
        $_SESSION['error'] = "Gagal memproses peminjaman: " . $e->getMessage();
    }
}

header("Location: ../../pages/loans/index.php");
exit();
?>