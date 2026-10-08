<?php
require_once __DIR__ . '/category-repository.php';
require_once __DIR__ . '/author-repository.php';

// Data mentah buku (relasi disimpan sebagai id).
function getRawBooks() {
    return [
        ["id" => 1, "title" => "Laskar Pelangi",               "isbn" => "978-979-1227-78-0", "year" => 2005, "stock" => 12, "category_id" => 1, "description" => "Kisah persahabatan sepuluh anak Belitung yang berjuang mengejar pendidikan.", "author_ids" => [1]],
        ["id" => 2, "title" => "Bumi",                         "isbn" => "978-602-03-3295-6", "year" => 2014, "stock" => 8,  "category_id" => 1, "description" => "Petualangan Raib, gadis biasa yang ternyata bisa menghilang.",                 "author_ids" => [2]],
        ["id" => 3, "title" => "Harry Potter dan Batu Bertuah", "isbn" => "978-979-22-5984-6", "year" => 1997, "stock" => 5,  "category_id" => 1, "description" => "Awal petualangan Harry Potter di Sekolah Sihir Hogwarts.",                    "author_ids" => [3]],
        ["id" => 4, "title" => "Bumi Manusia",                 "isbn" => "978-979-97312-3-2", "year" => 1980, "stock" => 6,  "category_id" => 3, "description" => "Novel sejarah tentang Minke pada masa kolonial Hindia Belanda.",               "author_ids" => [4]],
        ["id" => 5, "title" => "Antologi Rasa Nusantara",      "isbn" => "978-602-1234-56-7", "year" => 2021, "stock" => 4,  "category_id" => 1, "description" => "Kumpulan puisi dan cerita pendek dari berbagai penulis Nusantara.",         "author_ids" => [4, 5]],
    ];
}

// Menambahkan nama kategori dan nama penulis ke data buku.
function formatBook($book) {
    $category = getCategory($book['category_id']);
    $book['category'] = $category ? $category['name'] : '-';

    $book['authors'] = [];
    foreach ($book['author_ids'] as $authorId) {
        $author = getAuthor($authorId);
        if ($author) {
            $book['authors'][] = $author['name'];
        }
    }
    return $book;
}

function getBooks() {
    return array_map('formatBook', getRawBooks());
}

function getBook($id) {
    foreach (getRawBooks() as $book) {
        if ($book['id'] == $id) {
            return formatBook($book);
        }
    }
    return null;
}