<?php
// public/manage_books.php

session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/BookController.php';
require_once __DIR__ . '/../src/UserController.php';

// --- Proteksi Halaman Admin ---
if (!UserController::isLoggedIn() || !UserController::isAdmin()) {
    header('Location: login.php');
    exit();
}
// --- Akhir Proteksi Halaman Admin ---

$bookController = new BookController($pdo);

$books = [];
$editBook = null;
$message = '';
$messageType = '';

// Tangani pesan dari redirect sebelumnya
if (isset($_GET['msg'])) {
    $message = htmlspecialchars(urldecode($_GET['msg']));
    $messageType = strpos($message, 'berhasil') !== false ? 'success' : 'error';
    if (strpos($message, 'Gagal') !== false || strpos($message, 'Error') !== false || strpos($message, 'Ukuran') !== false || strpos($message, 'Tipe') !== false) {
        $messageType = 'error';
    }
}

// --- Tangani Pengiriman Formulir (Tambah, Edit, Hapus) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $book_id = $_POST['book_id'] ?? null;

    // Ambil file upload jika ada
    $fileInput = $_FILES['cover_image'] ?? null;

    $formData = [
        'title'            => $_POST['judul'] ?? '',
        'author'           => $_POST['penulis'] ?? '',
        'publisher'        => $_POST['penerbit'] ?? '',
        'publication_year' => $_POST['tahun_terbit'] ?? null,
        'category'         => $_POST['kategori'] ?? '',
        'description'      => $_POST['deskripsi'] ?? '',
        'isbn'             => empty($_POST['isbn']) ? null : $_POST['isbn'],
        // PERBAIKAN: remove_cover harus jadi boolean di sini untuk consistency dengan controller
        'remove_cover'     => (isset($_POST['remove_cover']) && $_POST['remove_cover'] === 'true')
    ];

    $responseMessage = '';

    if ($action === 'add') {
        $result = $bookController->createBook($formData, $fileInput); // PERBAIKAN: Teruskan $fileInput
        if ($result === true) {
            $responseMessage = 'Buku berhasil ditambahkan!';
        } else {
            $responseMessage = 'Gagal menambahkan buku: ' . htmlspecialchars($result);
        }
    } elseif ($action === 'edit') {
        if ($book_id) {
            $result = $bookController->updateBook($book_id, $formData, $fileInput); // PERBAIKAN: Teruskan $fileInput
            if ($result === true) {
                $responseMessage = 'Buku berhasil diperbarui!';
            } else {
                $responseMessage = 'Gagal memperbarui buku: ' . htmlspecialchars($result);
            }
        } else {
            $responseMessage = 'Gagal memperbarui buku: ID buku tidak valid.';
        }
    } elseif ($action === 'delete') {
        if ($book_id) {
            $result = $bookController->deleteBook($book_id);
            if ($result === true) {
                $responseMessage = 'Buku berhasil dihapus!';
            } else {
                $responseMessage = 'Gagal menghapus buku: ' . htmlspecialchars($result);
            }
        } else {
            $responseMessage = 'Gagal menghapus buku: ID buku tidak valid.';
        }
    } else {
        $responseMessage = 'Aksi tidak dikenal.';
    }

    header('Location: manage_books.php?msg=' . urlencode($responseMessage));
    exit();
}
// --- Akhir Tangani Pengiriman Formulir ---


// --- Ambil data buku untuk ditampilkan (Ini harus selalu dieksekusi untuk GET request) ---
$books = $bookController->getBooks();
// --- Akhir Ambil data buku ---


// --- Tangani mode edit (Ini juga harus selalu dieksekusi untuk GET request) ---
if (isset($_GET['edit_id'])) {
    $editBook = $bookController->getBookById($_GET['edit_id']);
    if (!$editBook) {
        header('Location: manage_books.php?msg=' . urlencode('Buku tidak ditemukan untuk diedit.'));
        exit();
    }
}
// --- Akhir Tangani mode edit ---
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Books - Perpustakaan</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal p-4">
    <div class="container mx-auto p-4 bg-white shadow-lg rounded-lg">
        <h1 class="text-3xl font-bold text-center mb-6 text-gray-800">Manajemen Buku Perpustakaan</h1>
        <p class="text-center text-sm text-gray-500 mb-4">Logged in as: <span class="font-semibold"><?= htmlspecialchars($_SESSION['username'] ?? 'Guest') ?> (<?= htmlspecialchars($_SESSION['role'] ?? 'N/A') ?>)</span></p>

        <div id="message-container" class="my-4 p-3 rounded-md text-white text-center <?= $messageType === 'success' ? 'bg-green-500' : ($messageType === 'error' ? 'bg-red-500' : 'hidden') ?>">
            <p id="message-text" class="font-semibold"><?= $message ?></p>
        </div>


        <div class="mb-4">
            <a href="index.php" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                &larr; Kembali ke Tampilan Utama
            </a>
            <a href="logout.php" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-2">Logout</a>
        </div>

        <div class="mb-8 p-6 bg-blue-50 rounded-lg shadow-sm">
            <h2 class="text-2xl font-semibold mb-4 text-blue-800"><?= $editBook ? 'Edit Buku' : 'Tambah Buku Baru' ?></h2>
            <form action="manage_books.php" method="POST" class="space-y-4" enctype="multipart/form-data">
                <?php if ($editBook): ?>
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="book_id" value="<?= htmlspecialchars($editBook['id']) ?>">
                <?php else: ?>
                    <input type="hidden" name="action" value="add">
                <?php endif; ?>

                <div>
                    <label for="judul" class="block text-gray-700 text-sm font-bold mb-2">Judul Buku:</label>
                    <input type="text" id="judul" name="judul" value="<?= htmlspecialchars($editBook['title'] ?? '') ?>" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500">
                </div>

                <div>
                    <label for="penulis" class="block text-gray-700 text-sm font-bold mb-2">Penulis:</label>
                    <input type="text" id="penulis" name="penulis" value="<?= htmlspecialchars($editBook['author'] ?? '') ?>" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500">
                </div>

                <div>
                    <label for="penerbit" class="block text-gray-700 text-sm font-bold mb-2">Penerbit:</label>
                    <input type="text" id="penerbit" name="penerbit" value="<?= htmlspecialchars($editBook['publisher'] ?? '') ?>" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500">
                </div>

                <div>
                    <label for="tahun_terbit" class="block text-gray-700 text-sm font-bold mb-2">Tahun Terbit:</label>
                    <input type="number" id="tahun_terbit" name="tahun_terbit" value="<?= htmlspecialchars($editBook['publication_year'] ?? '') ?>"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500">
                </div>

                <div>
                    <label for="kategori" class="block text-gray-700 text-sm font-bold mb-2">Kategori:</label>
                    <input type="text" id="kategori" name="kategori" value="<?= htmlspecialchars($editBook['category'] ?? '') ?>"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500">
                </div>

                <div>
                    <label for="deskripsi" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi:</label>
                    <textarea id="deskripsi" name="deskripsi"
                              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500 h-24"><?= htmlspecialchars($editBook['description'] ?? '') ?></textarea>
                </div>

                <div>
                    <label for="isbn" class="block text-gray-700 text-sm font-bold mb-2">ISBN (Opsional):</label>
                    <input type="text" id="isbn" name="isbn" value="<?= htmlspecialchars($editBook['isbn'] ?? '') ?>"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500">
                </div>

                <div>
                    <label for="cover_image" class="block text-gray-700 text-sm font-bold mb-2">Sampul Buku (Gambar JPG/PNG/GIF, maks 5MB):</label>
                    <input type="file" id="cover_image" name="cover_image" accept="image/jpeg,image/png,image/gif"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500">
                    <?php if ($editBook && $editBook['cover_image']): ?>
                        <div class="mt-2 flex items-center space-x-2">
                            <img src="<?= htmlspecialchars($bookController->publicUploadPathForWeb . $editBook['cover_image']) ?>" alt="Current Cover" class="h-20 w-auto object-contain rounded border">
                            <label class="inline-flex items-center text-gray-700 text-sm">
                                <input type="checkbox" name="remove_cover" value="true" class="form-checkbox h-4 w-4 text-red-600">
                                <span class="ml-2">Hapus sampul yang ada</span>
                            </label>
                        </div>
                    <?php endif; ?>
                </div>

                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    <?= $editBook ? 'Update Buku' : 'Tambah Buku' ?>
                </button>
                <?php if ($editBook): ?>
                    <a href="manage_books.php" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-2">Batal</a>
                <?php endif; ?>
            </form>
        </div>

        <h2 class="text-2xl font-semibold mb-4 text-gray-800">Daftar Buku</h2>
        <?php if (empty($books)): ?>
            <p class="text-gray-600">Belum ada buku yang ditambahkan.</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">ID</th>
                            <th class="py-3 px-6 text-left">Judul</th>
                            <th class="py-3 px-6 text-left">Penulis</th>
                            <th class="py-3 px-6 text-left">Penerbit</th>
                            <th class="py-3 px-6 text-left">Tahun</th>
                            <th class="py-3 px-6 text-left">Kategori</th>
                            <th class="py-3 px-6 text-left">ISBN</th>
                            <th class="py-3 px-6 text-left">Sampul</th>
                            <th class="py-3 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        <?php foreach ($books as $book): ?>
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap"><?= htmlspecialchars($book['id']) ?></td>
                                <td class="py-3 px-6 text-left"><?= htmlspecialchars($book['title']) ?></td>
                                <td class="py-3 px-6 text-left"><?= htmlspecialchars($book['author']) ?></td>
                                <td class="py-3 px-6 text-left"><?= htmlspecialchars($book['publisher']) ?></td>
                                <td class="py-3 px-6 text-left"><?= htmlspecialchars($book['publication_year']) ?></td>
                                <td class="py-3 px-6 text-left"><?= htmlspecialchars($book['category']) ?></td>
                                <td class="py-3 px-6 text-left"><?= htmlspecialchars($book['isbn'] ?? '-') ?></td>
                                <td class="py-3 px-6 text-left">
                                    <?php if ($book['cover_image']): ?>
                                        <img src="<?= htmlspecialchars($bookController->publicUploadPathForWeb . $book['cover_image']) ?>" alt="Cover" class="h-16 w-auto object-contain rounded">
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center space-x-2">
                                        <a href="manage_books.php?edit_id=<?= htmlspecialchars($book['id']) ?>"
                                           class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-xs">Edit</a>
                                        <form action="manage_books.php" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="book_id" value="<?= htmlspecialchars($book['id']) ?>">
                                            <button type="submit"
                                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-xs">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const message = urlParams.get('msg');
            const messageContainer = document.getElementById('message-container');
            const messageText = document.getElementById('message-text');

            if (message && messageContainer && messageText) {
                messageText.textContent = decodeURIComponent(message);

                // Tentukan warna background berdasarkan pesan
                if (message.includes('berhasil')) {
                    messageContainer.classList.add('bg-green-500');
                } else {
                    messageContainer.classList.add('bg-red-500');
                }

                messageContainer.classList.remove('hidden');
                messageContainer.classList.add('opacity-100');

                // Sembunyikan pesan setelah 5 detik
                setTimeout(() => {
                    messageContainer.classList.remove('opacity-100');
                    messageContainer.classList.add('opacity-0'); // Start fade out

                    setTimeout(() => {
                        messageContainer.classList.add('hidden');
                        history.replaceState({}, document.title, window.location.pathname);
                    }, 500); // Match this with your CSS transition duration

                }, 5000); // Display for 5 seconds
            }
        });
    </script>
</body>
</html>