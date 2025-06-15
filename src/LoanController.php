<?php
// src/LoanController.php

class LoanController
{
    private $pdo;
    private $bookController; // Kita butuh BookController untuk update ketersediaan buku

    public function __construct(PDO $pdo, BookController $bookController)
    {
        $this->pdo = $pdo;
        $this->bookController = $bookController;
    }

    // Metode untuk mencatat peminjaman buku
    public function borrowBook($bookId, $userId)
    {
        // 1. Cek apakah buku tersedia
        $book = $this->bookController->getBookById($bookId);
        if (!$book || !$book['is_available']) {
            return "Buku tidak tersedia untuk dipinjam.";
        }

        // 2. Cek apakah user sudah meminjam buku ini dan belum dikembalikan (opsional, untuk mencegah double loan)
        $existingLoan = $this->getLoanByBookAndUser($bookId, $userId, 'borrowed');
        if ($existingLoan) {
            return "Anda sudah meminjam buku ini dan belum mengembalikannya.";
        }

        try {
            $this->pdo->beginTransaction(); // Mulai transaksi

            // Masukkan data peminjaman ke tabel loans
            $stmt = $this->pdo->prepare("INSERT INTO loans (book_id, user_id, status) VALUES (?, ?, 'borrowed')");
            $stmt->execute([$bookId, $userId]);

            // Update status ketersediaan buku di tabel books menjadi FALSE (tidak tersedia)
            $this->bookController->updateBookAvailability($bookId, false);

            $this->pdo->commit(); // Komit transaksi
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack(); // Rollback jika ada error
            error_log("Database error in borrowBook(): " . $e->getMessage());
            return "Gagal meminjam buku. Silakan coba lagi.";
        }
    }

    // Metode untuk mencatat pengembalian buku
    public function returnBook($loanId)
    {
        try {
            $this->pdo->beginTransaction(); // Mulai transaksi

            // Ambil detail peminjaman
            $loanStmt = $this->pdo->prepare("SELECT book_id FROM loans WHERE id = ? AND status = 'borrowed'");
            $loanStmt->execute([$loanId]);
            $loan = $loanStmt->fetch();

            if (!$loan) {
                $this->pdo->rollBack();
                return "Peminjaman tidak ditemukan atau sudah dikembalikan.";
            }

            // Update status peminjaman menjadi 'returned' dan catat return_date
            $stmt = $this->pdo->prepare("UPDATE loans SET return_date = CURRENT_TIMESTAMP, status = 'returned' WHERE id = ?");
            $stmt->execute([$loanId]);

            // Update status ketersediaan buku di tabel books menjadi TRUE (tersedia)
            $this->bookController->updateBookAvailability($loan['book_id'], true);

            $this->pdo->commit(); // Komit transaksi
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack(); // Rollback jika ada error
            error_log("Database error in returnBook(): " . $e->getMessage());
            return "Gagal mengembalikan buku. Silakan coba lagi.";
        }
    }

    // Metode untuk mendapatkan semua peminjaman (untuk admin)
    public function getAllLoans()
    {
        try {
            $stmt = $this->pdo->query("
                SELECT
                    l.id AS loan_id,
                    b.title,
                    b.author,
                    u.username,
                    l.loan_date,
                    l.return_date,
                    l.due_date,
                    l.status,
                    b.id AS book_id
                FROM loans l
                JOIN books b ON l.book_id = b.id
                JOIN users u ON l.user_id = u.id
                ORDER BY l.loan_date DESC
            ");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Database error in getAllLoans(): " . $e->getMessage());
            return [];
        }
    }

    // Metode untuk mendapatkan peminjaman berdasarkan user ID
    public function getUserLoans($userId) {
        // Log saat method dipanggil
        error_log("DEBUG: getUserLoans() dipanggil untuk user ID: " . $userId);

        $stmt = $this->pdo->prepare("SELECT id, book_id, user_id, status FROM loans WHERE user_id = ?");
        $stmt->execute([$userId]);
        $loans = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Log hasil kueri
        error_log("DEBUG: Hasil query getUserLoans untuk user ID " . $userId . ": " . print_r($loans, true));

        return $loans;
    }
    

    // Metode bantuan untuk mengecek peminjaman yang sedang berlangsung
    private function getLoanByBookAndUser($bookId, $userId, $status = 'borrowed') {
        $stmt = $this->pdo->prepare("SELECT id FROM loans WHERE book_id = ? AND user_id = ? AND status = ? LIMIT 1");
        $stmt->execute([$bookId, $userId, $status]);
        return $stmt->fetch();
    }
}