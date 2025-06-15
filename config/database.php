<?php
// config/database.php

$host = 'localhost';
$db   = 'perpustakaan_db';
$user = 'root'; // Ganti dengan username MySQL kamu
$pass = '';     // Ganti dengan password MySQL kamu (biasanya kosong untuk XAMPP/Laragon)
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Aktifkan mode error untuk PDOExceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,     // Ambil data sebagai array asosiatif
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Jika koneksi gagal, hentikan skrip dan tampilkan pesan error
    die("Database connection failed: " . $e->getMessage() . " (Code: " . $e->getCode() . ")");
}