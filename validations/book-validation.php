<?php
require_once __DIR__ . "/../repositories/book-repository.php";
require_once __DIR__ . "/../repositories/category-repository.php";
require_once __DIR__ . "/../repositories/author-repository.php";

// Membersihkan satu nilai input: buang spasi di tepi dan escape karakter HTML.
function cleanInput($value)
{
    return trim(htmlspecialchars($value ?? ''));
}

function getBookRequest($request)
{
    return [
        'id' => cleanInput($request['id'] ?? ''),
        'title' => cleanInput($request['title'] ?? ''),
        'isbn' => cleanInput($request['isbn'] ?? ''),
        'year' => cleanInput($request['year'] ?? ''),
        'stock' => cleanInput($request['stock'] ?? ''),
        'description' => cleanInput($request['description'] ?? ''),
        'category_id' => cleanInput($request['category_id'] ?? ''),
        'author_ids' => $request['author_ids'] ?? [],
    ];
}

// Setiap fungsi validasi mengembalikan pesan error, atau null jika data valid.

function validateTitle($title)
{
    if ($title === '') {
        return "Judul buku wajib diisi";
    }
    if (mb_strlen($title) > 100) {
        return "Judul buku tidak boleh melebihi dari 100 karakter";
    }
    return null;
}

function validateIsbn($isbn, $ignoreBookId)
{
    if ($isbn === '') {
        return "ISBN wajib diisi";
    }
    if (isIsbnTaken($isbn, $ignoreBookId)) {
        return "ISBN sudah terdaftar sebelumnya";
    }
    return null;
}

function validateYear($year)
{
    if ($year === '') {
        return "Tahun terbit wajib diisi";
    }
    if (filter_var($year, FILTER_VALIDATE_INT) === false) {
        return "Tahun terbit wajib diisi dengan angka";
    }
    if ((int) $year < 1000 || (int) $year > (int) date('Y')) {
        return "Tahun terbit tidak valid";
    }
    return null;
}

function validateStock($stock)
{
    if ($stock === '') {
        return "Stok wajib diisi";
    }
    if (filter_var($stock, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]) === false) {
        return "Stok wajib diisi dengan angka 0 atau lebih";
    }
    return null;
}

function validateCategory($categoryId)
{
    if ($categoryId === '') {
        return "Kategori wajib dipilih";
    }
    if (!isCategoryExists($categoryId)) {
        return "Kategori yang dipilih tidak valid";
    }
    return null;
}

function validateDescription($description)
{
    if ($description === '') {
        return "Deskripsi buku wajib diisi";
    }
    if (mb_strlen($description) > 100) {
        return "Deskripsi buku tidak boleh melebihi dari 100 karakter";
    }
    return null;
}

function validateAuthors($authorIds)
{
    if (count($authorIds) < 1) {
        return "Penulis buku wajib dipilih";
    }

    $validAuthorIds = array_column(getAuthors(), 'id');
    foreach ($authorIds as $authorId) {
        if (!in_array($authorId, $validAuthorIds)) {
            return "Ada Penulis buku yang dipilih tidak valid";
        }
    }
    return null;
}

function validateBook($request, $ignoreBookId = 0)
{
    $checks = [
        'title' => validateTitle($request['title']),
        'isbn' => validateIsbn($request['isbn'], $ignoreBookId),
        'year' => validateYear($request['year']),
        'stock' => validateStock($request['stock']),
        'category_id' => validateCategory($request['category_id']),
        'description' => validateDescription($request['description']),
        'author_ids' => validateAuthors($request['author_ids']),
    ];

    // Simpan hanya field yang punya pesan error.
    return array_filter($checks, fn($message) => $message !== null);
}
