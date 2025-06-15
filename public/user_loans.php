<?php
// public/user_loans.php

session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/BookController.php';
require_once __DIR__ . '/../src/LoanController.php';
require_once __DIR__ . '/../src/UserController.php';

$bookController = new BookController($pdo);
$loanController = new LoanController($pdo, $bookController);

// Pastikan user sudah login
if (!UserController::isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$currentUserId = $_SESSION['user_id'] ?? null;
$currentUsername = $_SESSION['username'] ?? 'User';

// Jika user ID tidak ada di sesi, arahkan ke login
if (!$currentUserId) {
    header('Location: login.php');
    exit();
}

$message = '';
if (isset($_GET['msg'])) {
    $message = htmlspecialchars($_GET['msg']);
}

// Ambil semua peminjaman untuk user ini
$userLoans = $loanController->getUserLoans($currentUserId);

// Pisahkan antara buku yang sedang dipinjam (borrowed) dan riwayat (returned/cancelled)
$currentLoans = array_filter($userLoans, function($loan) {
    return $loan['status'] === 'borrowed';
});

$loanHistory = array_filter($userLoans, function($loan) {
    return $loan['status'] !== 'borrowed';
});

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Peminjaman Anda</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .book-cover-small {
            width: 50px;
            height: 75px;
            object-fit: cover;
            border-radius: 4px;
        }
        .no-cover-placeholder-small {
            width: 50px;
            height: 75px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #e0e0e0;
            color: #a0a0a0;
            font-size: 0.6rem;
            border-radius: 4px;
            text-align: center;
        }
    </style>
</head>
<body class="bg-[#f6f0ea] text-gray-800">
    <div class="flex min-h-screen">
        <aside class="w-16 h-screen bg-[#EFE5DA] border-r flex flex-col items-center py-6 space-y-6 sticky top-0 left-0">
            <a href="index.php" class="text-xl">📚</a>
            <button>⭐</button>
            <a href="user_loans.php" class="bg-indigo-500 text-white px-3 py-1 rounded-full text-xs hover:bg-indigo-600 transition-colors duration-200">Pinjaman Anda</a>
            <button>🔖</button>

            <?php if (UserController::isLoggedIn()): ?>
                <span class="text-xs text-gray-600 mt-auto mb-2 text-center break-words w-full px-1">Hello, <?= htmlspecialchars($currentUsername) ?>!</span>
                <?php if (UserController::isAdmin()): ?>
                    <a href="manage_books.php" class="bg-indigo-500 text-white px-3 py-1 rounded-full text-xs hover:bg-indigo-600 transition-colors duration-200">Manage Books</a>
                    <a href="manage_loans.php" class="bg-purple-500 text-white px-3 py-1 rounded-full text-xs hover:bg-purple-600 transition-colors duration-200">Manage Loans</a>
                <?php endif; ?>
                <a href="logout.php" class="bg-red-500 text-white px-3 py-1 rounded-full text-xs hover:bg-red-600 transition-colors duration-200">Logout</a>
            <?php else: ?>
                <a href="login.php" class="mt-auto bg-green-500 text-white px-3 py-1 rounded-full text-xs hover:bg-green-600 transition-colors duration-200">Login</a>
                <a href="register.php" class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs hover:bg-blue-600 transition-colors duration-200">Register</a>
            <?php endif; ?>
        </aside>

        <main class="flex-1 p-6">
            <h1 class="text-3xl font-bold mb-6 text-gray-900">Dashboard Peminjaman Anda</h1>

            <?php if ($message): ?>
                <div class="mb-4 p-3 rounded-md <?= strpos($message, 'berhasil') !== false ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <section class="mb-8">
                <h2 class="text-2xl font-bold mb-4 text-gray-900">Buku yang Sedang Anda Pinjam</h2>
                <?php if (empty($currentLoans)): ?>
                    <p class="text-gray-600">Anda tidak sedang meminjam buku apa pun saat ini.</p>
                <?php else: ?>
                    <div class="bg-white shadow-lg rounded-xl p-4">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cover</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Buku</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jatuh Tempo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($currentLoans as $loan): ?>
                                    <?php
                                    // Ambil detail buku untuk peminjaman ini
                                    $book = $bookController->getBookById($loan['book_id']);
                                    ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <?php if ($book && $book['cover_image']): ?>
                                                <img src="<?= 'uploads/book_covers/' . htmlspecialchars($book['cover_image']) ?>" alt="Cover" class="book-cover-small">
                                            <?php else: ?>
                                                <div class="no-cover-placeholder-small">No Cover</div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <?= $book ? htmlspecialchars($book['title']) : 'Buku Tidak Ditemukan' ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($loan['borrow_date']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?= htmlspecialchars($loan['due_date'] ?? 'N/A') ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form action="handle_loan_action.php" method="POST" class="inline-block">
                                                <input type="hidden" name="action" value="return_book_user">
                                                <input type="hidden" name="loan_id" value="<?= htmlspecialchars($loan['id']) ?>">
                                                <button type="submit" class="text-green-600 hover:text-green-900 ml-2">Kembalikan</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </section>

            <section>
                <h2 class="text-2xl font-bold mb-4 text-gray-900">Riwayat Peminjaman</h2>
                <?php if (empty($loanHistory)): ?>
                    <p class="text-gray-600">Anda belum memiliki riwayat peminjaman.</p>
                <?php else: ?>
                    <div class="bg-white shadow-lg rounded-xl p-4">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cover</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Buku</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kembali</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($loanHistory as $loan): ?>
                                    <?php
                                    $book = $bookController->getBookById($loan['book_id']);
                                    ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <?php if ($book && $book['cover_image']): ?>
                                                <img src="<?= 'uploads/book_covers/' . htmlspecialchars($book['cover_image']) ?>" alt="Cover" class="book-cover-small">
                                            <?php else: ?>
                                                <div class="no-cover-placeholder-small">No Cover</div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <?= $book ? htmlspecialchars($book['title']) : 'Buku Tidak Ditemukan' ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($loan['borrow_date']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?= htmlspecialchars($loan['return_date'] ?? 'Belum Kembali') ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                <?php
                                                if ($loan['status'] === 'returned') echo 'bg-green-100 text-green-800';
                                                elseif ($loan['status'] === 'overdue') echo 'bg-red-100 text-red-800';
                                                elseif ($loan['status'] === 'cancelled') echo 'bg-gray-100 text-gray-800';
                                                else echo 'bg-blue-100 text-blue-800'; // Should not happen for history
                                                ?>">
                                                <?= ucfirst(htmlspecialchars($loan['status'])) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </section>
        </main>
    </div>
</body>
</html>