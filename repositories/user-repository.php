<?php

function getUsers() {
    return [
        ["id" => 1, "name" => "Admin Utama",     "email" => "admin@ski.sch.id",              "role" => "admin"],
        ["id" => 2, "name" => "Budi Santoso",    "email" => "budi.santoso@siswa.ski.sch.id", "role" => "member"],
        ["id" => 3, "name" => "Siti Aminah",     "email" => "siti.aminah@siswa.ski.sch.id",  "role" => "member"],
        ["id" => 4, "name" => "Richard Marcell", "email" => "richard.m@ski.sch.id",          "role" => "admin"],
    ];
}

function getUser($id) {
    foreach (getUsers() as $user) {
        if ($user['id'] == $id) {
            return $user;
        }
    }
    return null;
}

function getProfiles() {
    return [
        ["user_id" => 1, "phone" => "0811-1111-1111", "address" => "Jl. Sudirman No. 1, Pontianak, Kalimantan Barat", "bio" => "Administrator utama perpustakaan Immanuel."],
        ["user_id" => 2, "phone" => "0812-3456-7890", "address" => "Jl. Merdeka No. 21, Pontianak, Kalimantan Barat", "bio" => "Murid kelas XI TKJ yang gemar membaca novel fiksi dan buku pengembangan diri."],
        ["user_id" => 3, "phone" => "0813-2222-3333", "address" => "Jl. Gajah Mada No. 8, Pontianak, Kalimantan Barat", "bio" => "Murid yang suka membaca buku sains dan sejarah."],
        ["user_id" => 4, "phone" => "0857-4444-5555", "address" => "Jl. Ahmad Yani No. 15, Pontianak, Kalimantan Barat", "bio" => "Admin dan pengelola koleksi buku."],
    ];
}

function getProfile($userId) {
    foreach (getProfiles() as $profile) {
        if ($profile['user_id'] == $userId) {
            return $profile;
        }
    }
    return ["user_id" => $userId, "phone" => "", "address" => "", "bio" => ""];
}