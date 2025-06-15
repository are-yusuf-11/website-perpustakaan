<?php
// public/index.php

// PENTING: session_start() harus selalu menjadi baris kode pertama setelah <?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/BookController.php';
require_once __DIR__ . '/../src/LoanController.php';
require_once __DIR__ . '/../src/UserController.php';

// Inisialisasi controller
$bookController = new BookController($pdo);
$loanController = new LoanController($pdo, $bookController); // LoanController butuh BookController
$userController = new UserController($pdo); // Opsional: Untuk user-specific actions jika diperlukan di masa depan

// Ambil parameter pencarian dan kategori dari URL
$searchTerm = $_GET['search'] ?? '';
$selectedCategory = $_GET['category'] ?? 'All';

// Ambil daftar buku. Sekarang selalu menggunakan getFilteredBooks()
// (Karena fungsi random sudah dihapus)
$books = $bookController->getFilteredBooks($searchTerm, $selectedCategory);
$booksBestTen = $bookController->getBestTenBooks();


// Ambil semua kategori yang tersedia untuk filter
$allCategories = $bookController->getAllCategories();
array_unshift($allCategories, 'All'); // Tambahkan opsi 'All' di awal
$allCategories = array_unique($allCategories); // Pastikan kategori unik

// Cek status login dan peran pengguna
$isLoggedIn = UserController::isLoggedIn();
$isAdmin = UserController::isAdmin();
$currentUsername = $_SESSION['username'] ?? '';
$currentUserId = $_SESSION['user_id'] ?? null; // Ambil ID user dari sesi

$message = ''; // Variabel untuk pesan sukses/error

// --- Tangani Aksi Peminjaman (POST Request) ---
// Pastikan ini adalah POST request DAN 'action' diset.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    // Hanya proses jika aksi adalah 'borrow_book'
    if ($_POST['action'] === 'borrow_book') {
        // Gunakan operator null coalescing untuk mendapatkan book_id dengan aman
        $bookId = $_POST['book_id'] ?? null;

        // Lanjutkan hanya jika $bookId memiliki nilai (bukan null atau falsey), user login, dan userId tersedia
        if ($bookId && $isLoggedIn && $currentUserId) {
            $result = $loanController->borrowBook($bookId, $currentUserId);
            if ($result === true) {
                $message = 'Buku berhasil dipinjam!';
            } else {
                $message = 'Gagal meminjam buku: ' . htmlspecialchars($result);
            }
        } else {
            // Ini akan menangani kasus jika bookId tidak valid atau user tidak memenuhi syarat
            if (!$isLoggedIn) {
                $message = 'Anda harus login untuk meminjam buku.';
            } else {
                $message = 'Gagal meminjam buku. Buku yang dipilih tidak valid.';
            }
        }
    } else {
        // Opsional: Handle action POST lain yang tidak ditangani di sini
        // $message = 'Aksi tidak dikenal.';
    }

    // Setelah memproses POST, selalu redirect untuk mencegah resubmission form
    header('Location: index.php?msg=' . urlencode($message));
    exit();
}

// Ambil pesan dari redirect (jika ada, dari $_GET)
if (isset($_GET['msg'])) {
    $message = htmlspecialchars($_GET['msg']);
}

// Untuk menampilkan status "Sudah Dipinjam Anda"
$userBorrowedBookIds = []; // Simpan hanya ID buku yang sedang dipinjam user
if ($isLoggedIn && $currentUserId) {
    $userLoans = $loanController->getUserLoans($currentUserId);
    foreach ($userLoans as $loan) {
        if ($loan['status'] === 'borrowed') {
            if (isset($loan['book_id'])) {
                $userBorrowedBookIds[] = $loan['book_id'];
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Perpustakaan</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Styling untuk container sampul buku */
        .book-cover-container {
            /* Atur dimensi kontainer ini untuk membatasi ukuran sampul */
            width: 80px; /* Lebar potret yang diinginkan */
            height: 120px; /* Tinggi potret yang diinginkan (rasio 2:3) */
            overflow: hidden; /* Penting jika gambar sampul lebih besar dari kontainer */
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin: 0 auto 10px; /* Tengahkan dan beri margin bawah */
            background-color: #f0f0f0; /* Warna latar belakang placeholder jika tidak ada gambar */
            display: flex; /* Untuk menengahkan teks placeholder */
            justify-content: center;
            align-items: center;
        }

        /* Styling untuk gambar sampul yang diunggah */
        .actual-book-cover { /* Nama class baru */
            width: 100%; /* Gambar sampul akan mengisi seluruh lebar kontainer */
            height: 100%; /* Gambar sampul akan mengisi seluruh tinggi kontainer */
            object-fit: cover; /* Penting: agar gambar mengisi area tanpa distorsi, memotong jika perlu */
            border-radius: 8px; /* Sesuaikan dengan border-radius container */
            display: block; /* Menghilangkan spasi ekstra di bawah gambar */
        }

        /* Styling untuk placeholder jika tidak ada gambar sampul */
        .no-cover-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #e0e0e0; /* Warna latar belakang placeholder */
            color: #a0a0a0; /* Warna teks placeholder */
            font-size: 0.875rem; /* Ukuran teks 'No Cover' */
            border-radius: 8px;
            text-align: center;
        }
    </style>
</head>
<body class="bg-[#f6f0ea] text-gray-800">
    <div class="flex min-h-screen">
        <aside class="w-16 h-screen bg-[#EFE5DA] border-r flex flex-col items-center py-6 space-y-6 sticky top-0 left-0">
            <a href="index.php" class="text-xl"><img class="w-8 h-auto" src="../src/img/icons8-library-100.png" alt=""></a>
        </aside>
        <main class="flex-1">
            <?php include "navbar.php" ?>
            <div id="dynamic-message" class="mb-4 p-3 rounded-md hidden"></div>
            <div class="p-5">
                <img class="w-80 h-auto" src="../src/img/hari-pancasila.png" alt="">
            </div>
            <section class="mt-12 bg-gradient-to-br from-indigo-500 to-purple-600 p-6 rounded-xl shadow-lg text-white">
                <h3 class="text-xl font-bold mb-2">10 Buku Bestseller Paling Populer Tahun 2025</h3>
                <p class="text-sm opacity-90">Daftar buku paling menarik tahun ini berdasarkan ulasan pelanggan dan kritikus</p>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6 mt-3 place-items-center">
                    <?php foreach ($booksBestTen as $book): ?>
                        <a href="book.php?id=<?= htmlspecialchars($book["id"]) ?>" class="block w-36 bg-white rounded-xl p-4 shadow-lg text-center transform hover:scale-105 transition-transform duration-200 ease-in-out">
                            <div class="book-cover-container">
                                <?php if ($book['cover_image']): ?>
                                    <img src="<?= 'uploads/book_covers/' . htmlspecialchars($book['cover_image']) ?>" alt="<?= htmlspecialchars($book['title']) ?> Cover" class="actual-book-cover">
                                <?php else: ?>
                                    <div class="no-cover-placeholder">
                                        <span class="text-gray-400 text-sm">No Cover</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <p class="font-semibold text-lg text-gray-800 truncate" title="<?= htmlspecialchars($book['title']) ?>"><?= htmlspecialchars($book['title']) ?></p>
                            <p class="text-sm text-gray-500 mt-1 truncate" title="<?= htmlspecialchars($book['author']) ?>"><?= htmlspecialchars($book['author']) ?></p>
                            <p class="text-xs text-gray-400 mt-0.5"><?= htmlspecialchars($book['publication_year']) ?></p>
                        </a>
                    <?php endforeach; ?>
                </div>
            </section>
            <section class="mt-10 px-6">
                <h2 class="text-2xl font-bold mb-4 text-gray-900">
                    <?php if (empty($searchTerm) && $selectedCategory === 'All'): ?>
                        Daftar Buku Terbaru
                    <?php else: ?>
                        Hasil Pencarian & Filter
                    <?php endif; ?>
                </h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                    <?php if (empty($books)): ?>
                        <p class="col-span-full text-center text-gray-500">Tidak ada buku yang ditemukan sesuai kriteria Anda.</p>
                    <?php else: ?>
                        <?php foreach ($books as $book): ?>
                            <a href="book.php?id=<?= htmlspecialchars($book["id"]) ?>" class="block bg-white rounded-xl p-4 shadow-lg text-center transform hover:scale-105 transition-transform duration-200 ease-in-out">
                                <div class="book-cover-container">
                                    <?php if ($book['cover_image']): ?>
                                        <img src="<?= 'uploads/book_covers/' . htmlspecialchars($book['cover_image']) ?>" alt="<?= htmlspecialchars($book['title']) ?> Cover" class="actual-book-cover">
                                    <?php else: ?>
                                        <div class="no-cover-placeholder">
                                            <span class="text-gray-400 text-sm">No Cover</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <p class="font-semibold text-lg text-gray-800 truncate" title="<?= htmlspecialchars($book['title']) ?>"><?= htmlspecialchars($book['title']) ?></p>
                                <p class="text-sm text-gray-500 mt-1 truncate" title="<?= htmlspecialchars($book['author']) ?>"><?= htmlspecialchars($book['author']) ?></p>
                                <p class="text-xs text-gray-400 mt-0.5"><?= htmlspecialchars($book['publication_year']) ?></p>

                                <div class="mt-3">
                                    <?php if ($isLoggedIn && !$isAdmin): // Hanya tampilkan untuk user biasa yang login ?>
                                        <?php
                                             // Cek apakah user sudah meminjam buku ini DAN statusnya 'borrowed'
                                            $userHasBorrowedThisBook = in_array($book['id'], $userBorrowedBookIds);
                                        ?>
                                        <?php if ($userHasBorrowedThisBook): ?>
                                            <button class="bg-yellow-400 text-white text-sm px-4 py-2 rounded-full cursor-not-allowed opacity-75">Sudah Dipinjam Anda</button>
                                        <?php elseif ($book['is_available']): ?>
                                            <form action="index.php" method="POST" class="inline-block">
                                                <input type="hidden" name="action" value="borrow_book">
                                                <input type="hidden" name="book_id" value="<?= htmlspecialchars($book['id']) ?>">
                                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-4 py-2 rounded-full transition-colors duration-200">Pinjam Buku</button>
                                            </form>
                                        <?php else: // Buku tidak tersedia ?>
                                            <button class="bg-gray-400 text-white text-sm px-4 py-2 rounded-full cursor-not-allowed opacity-75">Tidak Tersedia</button>
                                        <?php endif; ?>
                                    <?php elseif ($isAdmin): // Untuk Admin, tampilkan info ketersediaan saja (opsional) ?>
                                        <span class="text-xs text-gray-500">
                                            Status: <?= $book['is_available'] ? 'Tersedia' : 'Dipinjam' ?>
                                        </span>
                                    <?php else: // Jika belum login ?>
                                        <p class="text-xs text-gray-500">Login untuk meminjam</p>
                                    <?php endif; ?>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>
        </main>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const message = urlParams.get('msg'); // Ambil pesan dari URL
            const messageElement = document.getElementById('dynamic-message');

            if (message && messageElement) {
                // Set teks pesan
                messageElement.textContent = decodeURIComponent(message);

                // Tambahkan kelas warna berdasarkan isi pesan
                if (message.includes('berhasil')) {
                    messageElement.classList.add('bg-green-100', 'text-green-700');
                } else {
                    messageElement.classList.add('bg-red-100', 'text-red-700');
                }

                // Hapus kelas 'hidden' untuk menampilkan pesan
                messageElement.classList.remove('hidden');

                // Sembunyikan pesan setelah 5 detik
                setTimeout(() => {
                    messageElement.classList.add('hidden'); // Sembunyikan elemen
                    // Opsional: Hapus parameter 'msg' dari URL agar tidak muncul lagi saat refresh
                    history.replaceState({}, document.title, window.location.pathname);
                }, 5000); // 5000 milidetik = 5 detik
            }
        });
    </script>
</body>
</html>
</body>
</html>