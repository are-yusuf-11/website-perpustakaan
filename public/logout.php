<?php
// public/logout.php

// PENTING: session_start() harus selalu menjadi baris kode pertama setelah <?php
session_start();

require_once __DIR__ . '/../src/UserController.php';

UserController::logout(); // Panggil fungsi logout dari controller

header('Location: login.php'); // Redirect ke halaman login setelah logout
exit();
?>