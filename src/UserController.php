<?php
// src/UserController.php

class UserController
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Metode untuk registrasi pengguna baru
    public function registerUser($username, $password)
    {
        // Hash password sebelum disimpan untuk keamanan
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $this->pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            return $stmt->execute([$username, $hashedPassword]);
        } catch (\PDOException $e) {
            // Tangani error jika username sudah ada (kode SQLSTATE 23000)
            if ($e->getCode() == '23000') {
                return "Username already taken.";
            }
            throw $e; // Lempar exception lain untuk debugging
        }
    }

    // Metode untuk login pengguna
    public function loginUser($username, $password)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // Verifikasi password yang dimasukkan dengan hash yang disimpan
        if ($user && password_verify($password, $user['password'])) {
            // Login berhasil, mulai sesi dan simpan data pengguna
            // session_start() harus dipanggil di awal file PHP yang memanggil metode ini
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            return true;
        }
        return false; // Login gagal
    }

    // Metode statis untuk memeriksa apakah pengguna sudah login
    public static function isLoggedIn()
    {
        // session_start() harus dipanggil di awal file PHP yang memanggil metode ini
        return isset($_SESSION['user_id']);
    }

    // Metode statis untuk memeriksa apakah pengguna adalah admin
    public static function isAdmin()
    {
        // session_start() harus dipanggil di awal file PHP yang memanggil metode ini
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    // Metode statis untuk logout pengguna
    public static function logout()
    {
        // session_start() harus dipanggil di file PHP yang memanggil metode ini (logout.php)
        session_unset(); // Hapus semua variabel sesi
        session_destroy(); // Hancurkan sesi
    }
}