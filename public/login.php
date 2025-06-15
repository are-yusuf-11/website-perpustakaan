<?php
// public/login.php

// PENTING: session_start() harus selalu menjadi baris kode pertama setelah <?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/UserController.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $message = 'Username and password cannot be empty.';
    } else {
        $userController = new UserController($pdo);
        if ($userController->loginUser($username, $password)) {
            // Redirect ke halaman utama setelah login berhasil
            header('Location: index.php');
            exit();
        } else {
            $message = 'Invalid username or password.';
        }
    }
}

// Jika pengguna sudah login, redirect ke halaman utama
if (UserController::isLoggedIn()) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>
<body class=" flex items-center justify-center min-h-screen">
    <img src="../src/img/bg.jpg" alt="" class="absolute z-0 h-screen ">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md z-10">
        <h1 class="text-3xl font-bold text-center mb-6 text-gray-800">Login to Your Account</h1>

        <?php if ($message): ?>
            <div class="mb-4 p-3 rounded-md bg-red-100 text-red-700">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST" class="space-y-4" autocomplete="off">
            <div>
                <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username:</label>
                <input type="text" id="username" name="username" required
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-indigo-500">
            </div>
            <div>
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password:</label>
                <input type="password" id="password" name="password" required
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-indigo-500">
            </div>
            <button type="submit" class="w-full bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Login</button>
        </form>
        <p class="text-center text-sm text-gray-600 mt-4">Don't have an account? <a href="register.php" class="text-blue-600 hover:underline">Register here</a>.</p>
    </div>
</body>
</html>