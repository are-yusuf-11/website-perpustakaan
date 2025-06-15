<?php

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
        $result = $userController->registerUser($username, $password);

        if ($result === true) {
            $message = 'Registration successful! You can now <a href="login.php" class="text-blue-600 hover:underline">login</a>.';
        } elseif ($result === "Username already taken.") {
            $message = 'Username already exists. Please choose a different one.';
        } else {
            $message = 'Registration failed. Please try again.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>
<body class="bg-[#f6f0ea] flex items-center justify-center min-h-screen">
    <img src="../src/img/bg.jpg" alt="" class="absolute z-0 h-screen ">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md z-10">
        <h1 class="text-3xl font-bold text-center mb-6 text-gray-800">Register Account</h1>
        <?php if ($message): ?>
            <div class="mb-4 p-3 rounded-md <?= strpos($message, 'successful') !== false ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form action="register.php" method="POST" class="space-y-4" autocomplete="off">
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
            <button type="submit" class="w-full bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Register</button>
        </form>
        <p class="text-center text-sm text-gray-600 mt-4">Already have an account? <a href="login.php" class="text-blue-600 hover:underline">Login here</a>.</p>
    </div>
</body>
</html>