<?php
// src/BookController.php

class BookController
{
    private $pdo;
    private $uploadDir; // Direktori tempat menyimpan sampul buku
    public $publicUploadPathForWeb; // Path yang digunakan di HTML (misal: 'uploads/book_covers/')

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        // Tentukan direktori upload absolut dari root proyek
        // Asumsi struktur: project_root/public/uploads/book_covers/
        $this->uploadDir = __DIR__ . '/../public/uploads/book_covers/';
        // Tentukan path relatif untuk digunakan di HTML
        $this->publicUploadPathForWeb = 'uploads/book_covers/'; // Sesuai dengan bagaimana browser mengaksesnya
    }

    // --- Metode Bantuan untuk Upload File Sampul ---
    // Mengembalikan nama file yang disimpan, atau string error, atau null jika tidak ada upload
    private function handleCoverUpload($fileInput)
    {
        // Periksa apakah ada file yang diupload dan tidak ada error
        if (!isset($fileInput) || $fileInput['error'] === UPLOAD_ERR_NO_FILE) {
            return null; // Tidak ada file diupload
        }

        // Tangani error upload PHP yang spesifik
        if ($fileInput['error'] !== UPLOAD_ERR_OK) {
            switch ($fileInput['error']) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    return "Ukuran file terlalu besar. Maksimal 5MB.";
                case UPLOAD_ERR_PARTIAL:
                    return "File hanya terupload sebagian.";
                case UPLOAD_ERR_NO_TMP_DIR:
                    return "Direktori temporary tidak ada.";
                case UPLOAD_ERR_CANT_WRITE:
                    return "Gagal menulis file ke disk.";
                case UPLOAD_ERR_EXTENSION:
                    return "Ekstensi PHP menghentikan upload file.";
                default:
                    return "Terjadi error tidak dikenal saat upload file.";
            }
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxFileSize = 5 * 1024 * 1024; // 5 MB

        // Validasi tipe file (berdasarkan MIME type)
        if (!in_array($fileInput['type'], $allowedTypes)) {
            return "Tipe file tidak diizinkan. Hanya JPG, PNG, GIF.";
        }
        // Validasi ukuran file
        if ($fileInput['size'] > $maxFileSize) {
            return "Ukuran file terlalu besar. Maksimal 5MB.";
        }

        // Buat nama file unik untuk menghindari tabrakan nama
        $fileExtension = pathinfo($fileInput['name'], PATHINFO_EXTENSION);
        $fileName = uniqid('cover_') . '.' . $fileExtension;
        $targetFilePath = $this->uploadDir . $fileName;

        // Pastikan direktori upload ada
        if (!is_dir($this->uploadDir)) {
            if (!mkdir($this->uploadDir, 0755, true)) { // PERBAIKAN: Gunakan 0755
                return "Gagal membuat direktori upload: " . $this->uploadDir . ". Periksa izin server.";
            }
        }

        // Pindahkan file yang diupload ke direktori tujuan
        if (move_uploaded_file($fileInput['tmp_name'], $targetFilePath)) {
            return $fileName; // Kembalikan nama file yang disimpan
        } else {
            return "Gagal memindahkan file upload. Periksa izin direktori " . $this->uploadDir;
        }
    }

    // Metode untuk menghapus file sampul
    private function deleteBookCover($fileName)
    {
        if ($fileName && file_exists($this->uploadDir . $fileName) && !is_dir($this->uploadDir . $fileName)) {
            unlink($this->uploadDir . $fileName); // Hapus file dari server
        }
    }
    // --- Akhir Metode Bantuan ---


    // Metode untuk menambah buku baru
    public function createBook(array $data, $fileInput = null)
    {
        try {
            $coverImageName = null;
            if ($fileInput) { // Hanya panggil handleCoverUpload jika ada file input
                $uploadResult = $this->handleCoverUpload($fileInput);
                if (is_string($uploadResult) && strpos($uploadResult, 'Gagal') === 0 || strpos($uploadResult, 'Ukuran') === 0 || strpos($uploadResult, 'Tipe') === 0) {
                    return $uploadResult; // Mengembalikan pesan error dari upload
                }
                $coverImageName = $uploadResult;
            }

            $stmt = $this->pdo->prepare("INSERT INTO books (title, author, publisher, publication_year, category, description, isbn, cover_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $data['title'],
                $data['author'],
                $data['publisher'],
                $data['publication_year'],
                $data['category'],
                $data['description'],
                $data['isbn'] ?? null,
                $coverImageName // Simpan nama file sampul ke database
            ]);
            return true; // Berhasil
        } catch (PDOException $e) {
            // Hapus file yang mungkin sudah terupload jika insert ke DB gagal
            if ($coverImageName) {
                $this->deleteBookCover($coverImageName);
            }
            return "Database Error: " . $e->getMessage();
        }
    }

    // Metode untuk mendapatkan semua buku (untuk halaman admin)
    public function getBooks()
    {
        try {
            $stmt = $this->pdo->query("SELECT * FROM books ORDER BY id DESC");
            return $stmt->fetchAll(); // Mengembalikan semua buku
        } catch (PDOException $e) {
            error_log("Database error in getBooks(): " . $e->getMessage());
            return []; // Kembalikan array kosong jika ada error
        }
    }

    // Metode untuk mendapatkan buku dengan filter (untuk halaman utama)
    public function getFilteredBooks($searchTerm = '', $category = '')
    {
        $sql = "SELECT * FROM books WHERE 1=1";
        $params = [];

        if (!empty($searchTerm)) {
            $sql .= " AND (title LIKE ? OR author LIKE ? OR description LIKE ?)";
            $params[] = '%' . $searchTerm . '%';
            $params[] = '%' . $searchTerm . '%';
            $params[] = '%' . $searchTerm . '%';
        }

        if (!empty($category) && $category !== 'All') {
            $sql .= " AND category = ?";
            $params[] = $category;
        }

        $sql .= " ORDER BY id DESC";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Database error in getFilteredBooks(): " . $e->getMessage() . " - SQL: " . $sql . " - Params: " . implode(", ", $params));
            return [];
        }
    }

    // Metode untuk mendapatkan satu buku berdasarkan ID
    public function getBookById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM books WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Metode untuk memperbarui data buku
    public function updateBook(int $id, array $data, $fileInput = null) // PERBAIKAN: Tambah $fileInput
    {
        try {
            $currentBook = $this->getBookById($id); // Ambil data buku saat ini
            if (!$currentBook) {
                return "Buku dengan ID " . $id . " tidak ditemukan.";
            }

            $finalCoverImageName = $currentBook['cover_image']; // Default: pertahankan gambar lama

            // 1. Cek apakah ada file baru yang diupload
            $uploadNewFileResult = null;
            if ($fileInput && $fileInput['error'] !== UPLOAD_ERR_NO_FILE) {
                $uploadNewFileResult = $this->handleCoverUpload($fileInput);
                if (is_string($uploadNewFileResult) && (strpos($uploadNewFileResult, 'Gagal') === 0 || strpos($uploadNewFileResult, 'Ukuran') === 0 || strpos($uploadNewFileResult, 'Tipe') === 0)) {
                    return $uploadNewFileResult; // Mengembalikan pesan error dari upload
                }
            }

            // 2. Tentukan apa yang harus dilakukan dengan sampul
            if ($uploadNewFileResult) { // Ada file baru berhasil diupload
                // Hapus gambar lama jika ada dan berbeda dengan yang baru
                if ($currentBook['cover_image'] && $currentBook['cover_image'] !== $uploadNewFileResult) {
                    $this->deleteBookCover($currentBook['cover_image']);
                }
                $finalCoverImageName = $uploadNewFileResult; // Gunakan nama file baru
            } elseif (isset($data['remove_cover']) && $data['remove_cover'] === true) { // PERBAIKAN: cek boolean true
                // Ada permintaan untuk menghapus sampul dan tidak ada upload baru
                if ($currentBook['cover_image']) {
                    $this->deleteBookCover($currentBook['cover_image']);
                }
                $finalCoverImageName = null; // Set ke null di database
            }
            // Jika tidak ada upload baru DAN tidak ada permintaan hapus, maka $finalCoverImageName tetap $currentBook['cover_image']

            $stmt = $this->pdo->prepare("UPDATE books SET title = ?, author = ?, publisher = ?, publication_year = ?, category = ?, description = ?, isbn = ?, cover_image = ? WHERE id = ?");
            $stmt->execute([
                $data['title'],
                $data['author'],
                $data['publisher'],
                $data['publication_year'],
                $data['category'],
                $data['description'],
                $data['isbn'] ?? null,
                $finalCoverImageName, // Update nama file sampul
                $id
            ]);
            return true; // Berhasil
        } catch (PDOException $e) {
            // Jika terjadi error DB setelah upload, hapus file yang baru diupload
            if (isset($uploadNewFileResult) && is_string($uploadNewFileResult) && $uploadNewFileResult !== $currentBook['cover_image']) {
                $this->deleteBookCover($uploadNewFileResult);
            }
            return "Database Error: " . $e->getMessage();
        }
    }


    // Metode untuk menghapus buku
    public function deleteBook($id)
    {
        try {
            $book = $this->getBookById($id); // Ambil data buku untuk mendapatkan nama sampul
            if ($book && $book['cover_image']) {
                $this->deleteBookCover($book['cover_image']); // Hapus file sampul
            }

            $stmt = $this->pdo->prepare("DELETE FROM books WHERE id = ?");
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            return "Database Error: " . $e->getMessage();
        }
    }

    // Metode untuk mendapatkan buku secara acak
    public function getRandomBooks($limit = 10)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM books ORDER BY RAND() LIMIT ?");
            $stmt->execute([$limit]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Database error in getRandomBooks(): " . $e->getMessage());
            return [];
        }
    }

    // Metode untuk mendapatkan buku secara acak
    public function getBestTenBooks($limit = 10)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM books WHERE ten_best = 'T' LIMIT 3");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Database error in getRandomBooks(): " . $e->getMessage());
            return [];
        }
    }

    // Metode untuk mendapatkan semua kategori unik dari buku yang ada
    public function getAllCategories()
    {
        $stmt = $this->pdo->query("SELECT DISTINCT category FROM books WHERE category IS NOT NULL AND category != '' ORDER BY category ASC");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }


    // Metode untuk memperbarui ketersediaan buku
    public function updateBookAvailability($bookId, $isAvailable)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE books SET is_available = ? WHERE id = ?");
            return $stmt->execute([$isAvailable, $bookId]);
        } catch (PDOException $e) {
            error_log("Database error in updateBookAvailability(): " . $e->getMessage());
            return false;
        }
    }
}