<?php
session_start();
require_once "../../config/database.php";

$loan_id = $_GET['id'] ?? $_POST['id'] ?? null;

if (!$loan_id) {
    $_SESSION['error'] = "ID transaksi tidak ditemukan!";
    header("Location: ../../pages/loans/index.php");
    exit();
}

$conn->begin_transaction();

try {
    // 1. Ambil data peminjaman
    $stmt_loan = $conn->prepare("SELECT book_id, due_date, status FROM loans WHERE id = ? FOR UPDATE");
    $stmt_loan->bind_param("i", $loan_id);
    $stmt_loan->execute();
    $loan = $stmt_loan->get_result()->fetch_assoc();

    if (!$loan || $loan['status'] === 'returned') {
        throw new Exception("Peminjaman tidak valid atau buku sudah dikembalikan!");
    }

    $return_date = date('Y-m-d');
    $due_date    = $loan['due_date'];
    $fine        = 0;

    // 2. Hitung Denda Keterlambatan (Misal Rp 2.000 / hari)
    if (strtotime($return_date) > strtotime($due_date)) {
        $late_days = floor((strtotime($return_date) - strtotime($due_date)) / (60 * 60 * 24));
        $fine      = $late_days * 2000;
    }

    // 3. Update status peminjaman & denda
    $stmt_update = $conn->prepare("UPDATE loans SET return_date = ?, fine = ?, status = 'returned' WHERE id = ?");
    $stmt_update->bind_param("sdi", $return_date, $fine, $loan_id);
    $stmt_update->execute();

    // 4. Tambah kembali stok buku (+1)
    $stmt_stock = $conn->prepare("UPDATE books SET stock = stock + 1 WHERE id = ?");
    $stmt_stock->bind_param("i", $loan['book_id']);
    $stmt_stock->execute();

    $conn->commit();

    $msg = "Buku berhasil dikembalikan!";
    if ($fine > 0) {
        $msg .= " Terkena denda keterlambatan: Rp " . number_format($fine, 0, ',', '.');
    }
    $_SESSION['success'] = $msg;

} catch (Exception $e) {
    $conn->rollback();
    $_SESSION['error'] = "Gagal memproses pengembalian: " . $e->getMessage();
}

header("Location: ../../pages/loans/index.php");
exit();
?>