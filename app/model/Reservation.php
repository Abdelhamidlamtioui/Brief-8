<?php
namespace App\Model;
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Database\Database;
use PDO;
use Exception;

class Reservation {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function createReservation($userId, $bookId, $reservationDate, $returnDate) {
        $this->db->beginTransaction();

        try {
            $reservationStmt = $this->db->prepare("INSERT INTO Reservation (user_id, book_id, reservation_date, return_date) VALUES (?, ?, ?, ?)");
            $reservationStmt->execute([$userId, $bookId, $reservationDate, $returnDate]);
    
            $updateStmt = $this->db->prepare("UPDATE Book SET available_copies = available_copies - 1 WHERE id = ?");
            $updateStmt->execute([$bookId]);
    
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            return false;
        }
    }

    public function checkAvailability($bookId) {
        $stmt = $this->db->prepare("SELECT available_copies FROM Book WHERE id = :bookId");
        $stmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $result['available_copies'] > 0;
    }

    public function updateAvailableCopies($bookId, $change) {
        $stmt = $this->db->prepare("
            UPDATE book
            SET available_copies = available_copies + (:change)
            WHERE id = :id
        ");
        $stmt->bindParam(':id', $bookId, PDO::PARAM_INT);
        $stmt->bindValue(':change', $change, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getReservationById($reservationId) {
        $stmt = $this->db->prepare("SELECT * FROM reservation WHERE id = :id");
        $stmt->bindParam(':id', $reservationId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function markAsReturned($reservationId) {
        $stmt = $this->db->prepare("UPDATE reservation SET is_returned = 1 WHERE id = :id");
        $stmt->bindParam(':id', $reservationId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function returnBook($reservationId) {
        $this->db->beginTransaction();
    
        try {
            $stmt = $this->db->prepare("UPDATE Reservation SET is_returned = 1 WHERE id = :id");
            $stmt->bindParam(':id', $reservationId, PDO::PARAM_INT);
            $stmt->execute();
    
            $stmt = $this->db->prepare("SELECT book_id FROM Reservation WHERE id = :id");
            $stmt->bindParam(':id', $reservationId, PDO::PARAM_INT);
            $stmt->execute();
            $bookId = $stmt->fetch(PDO::FETCH_ASSOC)['book_id'];
    
            $stmt = $this->db->prepare("UPDATE Book SET available_copies = available_copies + 1 WHERE id = :id");
            $stmt->bindParam(':id', $bookId, PDO::PARAM_INT);
            $stmt->execute();
    
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function getAllReservations() {
        $stmt = $this->db->query("SELECT * FROM book");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

