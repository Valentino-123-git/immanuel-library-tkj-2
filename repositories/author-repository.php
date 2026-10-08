<?php

function getAuthors() {
    return [
        ["id" => 1, "name" => "Andrea Hirata",          "bio" => "Penulis asal Belitung, dikenal lewat novel Laskar Pelangi.", "total_books" => 1],
        ["id" => 2, "name" => "Tere Liye",              "bio" => "Penulis novel populer Indonesia, dikenal lewat serial Bumi.", "total_books" => 1],
        ["id" => 3, "name" => "J.K. Rowling",           "bio" => "Penulis asal Inggris, pencipta serial Harry Potter.",         "total_books" => 1],
        ["id" => 4, "name" => "Pramoedya Ananta Toer",  "bio" => "Sastrawan Indonesia, dikenal lewat Tetralogi Buru.",          "total_books" => 2],
        ["id" => 5, "name" => "Sapardi Djoko Damono",   "bio" => "Penyair dan sastrawan Indonesia, dikenal lewat puisi-puisinya.", "total_books" => 1],
    ];
}

function getAuthor($id) {
    foreach (getAuthors() as $author) {
        if ($author['id'] == $id) {
            return $author;
        }
    }
    return null;
}