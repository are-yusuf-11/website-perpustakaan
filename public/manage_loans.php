<?php
// public/manage_loans.php

session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/BookController.php'; // Perlu BookController
require_once __DIR__ . '/../src/LoanController.php'; // Perlu LoanController
require_once __DIR__ . '/../src/UserController.php';

// Proteksi Halaman Admin
if (!UserController::isLoggedIn() || !UserController::isAdmin()) {
    header('Location: login.php');
    exit();
}

$bookController = new BookController($pdo);
$loanController = new LoanController($pdo, $bookController); // Buat LoanController

$message = '';

// Tangani aksi pengembalian
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'return_book') {
    $loanId = $_POST['loan_id'] ?? null;
    if ($loanId) {
        $result = $loanController->returnBook($loanId);
        if ($result === true) {
            $message = 'Buku berhasil dikembalikan.';
        } else {
            $message = 'Gagal mengembalikan buku: ' . htmlspecialchars($result);
        }
    }
    // Redirect untuk mencegah resubmission form
    header('Location: manage_loans.php?msg=' . urlencode($message));
    exit();
}

// Ambil pesan dari redirect (jika ada)
if (isset($_GET['msg'])) {
    $message = htmlspecialchars($_GET['msg']);
}

$loans = $loanController->getAllLoans(); // Ambil semua data peminjaman
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Loans - Perpustakaan</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal p-4">
    <div class="container mx-auto p-4 bg-white shadow-lg rounded-lg">
        <h1 class="text-3xl font-bold text-center mb-6 text-gray-800">Manajemen Peminjaman Buku</h1>
        <p class="text-center text-sm text-gray-500 mb-4">Logged in as: <span class="font-semibold"><?= htmlspecialchars($_SESSION['username'] ?? 'Guest') ?> (<?= htmlspecialchars($_SESSION['role'] ?? 'N/A') ?>)</span></p>

        <div class="mb-4">
            <a href="index.php" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                &larr; Kembali ke Tampilan Utama
            </a>
            <a href="manage_books.php" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-2">
                Manajemen Buku
            </a>
            <a href="logout.php" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-2">Logout</a>
        </div>

        <?php if ($message): ?>
            <div class="mb-4 p-3 rounded-md <?= strpos($message, 'berhasil') !== false ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <h2 class="text-2xl font-semibold mb-4 text-gray-800">Daftar Peminjaman Aktif & Riwayat</h2>
        <?php if (empty($loans)): ?>
            <p class="text-gray-600">Belum ada peminjaman buku.</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">ID Peminjaman</th>
                            <th class="py-3 px-6 text-left">Judul Buku</th>
                            <th class="py-3 px-6 text-left">Penulis</th>
                            <th class="py-3 px-6 text-left">Peminjam</th>
                            <th class="py-3 px-6 text-left">Tanggal Pinjam</th>
                            <th class="py-3 px-6 text-left">Tanggal Kembali</th>
                            <th class="py-3 px-6 text-left">Status</th>
                            <th class="py-3 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        <?php foreach ($loans as $loan): ?>
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap"><?= htmlspecialchars($loan['loan_id']) ?></td>
                                <td class="py-3 px-6 text-left"><?= htmlspecialchars($loan['title']) ?></td>
                                <td class="py-3 px-6 text-left"><?= htmlspecialchars($loan['author']) ?></td>
                                <td class="py-3 px-6 text-left"><?= htmlspecialchars($loan['username']) ?></td>
                                <td class="py-3 px-6 text-left"><?= htmlspecialchars($loan['loan_date']) ?></td>
                                <td class="py-3 px-6 text-left">
                                    <?= $loan['return_date'] ? htmlspecialchars($loan['return_date']) : '-' ?>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <span class="py-1 px-3 rounded-full text-xs
                                        <?php
                                            if ($loan['status'] === 'borrowed') echo 'bg-blue-200 text-blue-800';
                                            elseif ($loan['status'] === 'returned') echo 'bg-green-200 text-green-800';
                                            elseif ($loan['status'] === 'overdue') echo 'bg-red-200 text-red-800';
                                        ?>">
                                        <?= ucfirst(htmlspecialchars($loan['status'])) ?>
                                    </span>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <?php if ($loan['status'] === 'borrowed'): ?>
                                        <form action="manage_loans.php" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengembalikan buku ini?');">
                                            <input type="hidden" name="action" value="return_book">
                                            <input type="hidden" name="loan_id" value="<?= htmlspecialchars($loan['loan_id']) ?>">
                                            <button type="submit"
                                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-xs">Kembalikan</button>
                                        </form>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>