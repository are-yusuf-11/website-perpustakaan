<?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/BookController.php';
require_once __DIR__ . '/../src/UserController.php';

$bookController = new BookController($pdo);

$book = null; // Inisialisasi variabel buku
$message = '';

// Pastikan ada parameter 'id' di URL
if (isset($_GET['id'])) {
    $bookId = $_GET['id'];

    // Ambil detail buku dari database
    $book = $bookController->getBookById($bookId);

    if (!$book) {
        $message = 'Buku tidak ditemukan.';
    }
} else {
    $message = 'ID buku tidak diberikan.';
}

// Cek status login dan peran pengguna (opsional, jika Anda ingin menampilkan info berbeda untuk user/admin)
$isLoggedIn = UserController::isLoggedIn();
$isAdmin = UserController::isAdmin();
$currentUsername = $_SESSION['username'] ?? '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $book ? htmlspecialchars($book['title']) : 'Detail Buku' ?> - Perpustakaan</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .book-detail-cover-container {
            width: 250px; /* Lebar lebih besar untuk detail */
            height: 375px; /* Tinggi lebih besar */
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            margin: 20px auto;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .actual-book-cover-detail {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
            display: block;
        }
        .no-cover-placeholder-detail {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #e0e0e0;
            color: #a0a0a0;
            font-size: 1rem;
            border-radius: 12px;
            text-align: center;
        }
    </style>
</head>
<body class="bg-[#f6f0ea] text-gray-800">
    <div class="container mx-auto p-8">
        <a href="index.php" class="text-blue-600 hover:underline mb-6 block">&larr; Kembali ke Daftar Buku</a>

        <?php if ($message): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded-md mb-6">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <?php if ($book): ?>
            <div class="bg-white rounded-xl shadow-lg p-8 grid grid-cols-2 gap-y-8">
                <div class="book-detail-cover-container flex-shrink-0">
                    <?php if ($book['cover_image']): ?>
                        <img src="<?= 'uploads/book_covers/' . htmlspecialchars($book['cover_image']) ?>" alt="<?= htmlspecialchars($book['title']) ?> Cover" class="actual-book-cover-detail">
                    <?php else: ?>
                        <div class="no-cover-placeholder-detail">
                            <span class="text-gray-400 text-lg">No Cover Available</span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class=" flex flex-col pt-8">
                    <h1 class="text-5xl font-bold text-gray-900 mb-2"><?= htmlspecialchars($book['title']) ?></h1>
                    <p class="text-xl text-gray-600 mb-4">Oleh: <?= htmlspecialchars($book['author']) ?></p>
                    
                    <div class="grid grid-cols-1 gap-4 mb-6 text-gray-700">
                        <div><strong class="text-gray-800">Tahun Terbit:</strong> <?= htmlspecialchars($book['publication_year']) ?></div>
                        <div><strong class="text-gray-800">ISBN:</strong> <?= htmlspecialchars($book['isbn']) ?></div>
                        <div><strong class="text-gray-800">Penerbit:</strong> <?= htmlspecialchars($book['publisher']) ?></div>
                        <div><strong class="text-gray-800">Kategori:</strong> <?= htmlspecialchars($book['category']) ?></div>
                    </div>
                </div>
                <?php if (!empty($book['description'])): ?>
                <div class="col-span-2 px-10">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Deskripsi:</h3>
                    <p class="text-gray-700 leading-relaxed mb-6">
                        <?= nl2br(htmlspecialchars($book['description'])) ?>
                    </p>
                </div>
                <?php endif; ?>
                    <div class="mt-4 px-8">
                        <?php if ($book['is_available']): ?>
                            <span class="bg-green-100 text-green-800 px-4 py-2 rounded-full font-semibold text-sm">Tersedia</span>
                        <?php else: ?>
                            <span class="bg-red-100 text-red-800 px-4 py-2 rounded-full font-semibold text-sm">Tidak Tersedia</span>
                        <?php endif; ?>
                    </div>
                    <?php if ($isLoggedIn && !$isAdmin): ?>
                        <div class="flex justify-center mt-6 col-span-2">
                            <?php 
                                // Anda perlu mengambil status peminjaman pengguna di sini jika ingin menampilkan tombol pinjam/kembali
                                // Ini bisa dilakukan dengan memanggil LoanController::getUserLoanStatusForBook($currentUserId, $book['id']);
                                // Untuk sederhana, saya akan menampilkan tombol jika tersedia dan user login
                            ?>
                            <?php if ($book['is_available']): ?>
                                <form action="index.php" method="POST">
                                    <input type="hidden" name="action" value="borrow_book">
                                    <input type="hidden" name="book_id" value="<?= htmlspecialchars($book['id']) ?>">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-full text-lg transition-colors duration-200">Pinjam Buku Ini</button>
                                </form>
                            <?php else: ?>
                                <button class="bg-gray-400 text-white px-6 py-3 rounded-full text-lg cursor-not-allowed opacity-75">Buku Sedang Dipinjam</button>
                            <?php endif; ?>
                        </div>
                    <?php elseif (!$isLoggedIn): ?>
                        <p class="text-sm text-gray-500 mt-4">Login untuk meminjam buku ini.</p>
                    <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>