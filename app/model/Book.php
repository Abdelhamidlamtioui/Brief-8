<?php
namespace App\Model;
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Database\Database;
use PDO;

class Book {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getAllBooks() {
        $stmt = $this->db->query("SELECT * FROM book");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addBook($title, $author, $genre, $description, $publication_year, $total_copies, $available_copies) {
        $stmt = $this->db->prepare("INSERT INTO book (title, author, genre, description, publication_year, total_copies,available_copies) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$title, $author, $genre, $description, $publication_year, $total_copies, $available_copies]);
    }

    public function getBookById($id) {
        $stmt = $this->db->prepare("SELECT * FROM book WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateBook($id, $title, $author, $genre, $description, $publication_year, $total_copies, $available_copies) {
        echo $id; 
        echo $title;
        echo $author; 
        echo $genre;
        echo $description;
        echo $publication_year;
        echo $total_copies;
        echo $available_copies;
        $stmt = $this->db->prepare("
            UPDATE book
            SET title = :title, author = :author, genre = :genre, description = :description, publication_year = :publicationYear, total_copies = :totalCopies, available_copies= :available_copies
            WHERE id = :id
        ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':author', $author, PDO::PARAM_STR);
        $stmt->bindParam(':genre', $genre, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':publicationYear', $publication_year, PDO::PARAM_INT);
        $stmt->bindParam(':totalCopies', $total_copies, PDO::PARAM_INT);
        $stmt->bindParam(':available_copies', $available_copies, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteBook($id) {
        $stmt = $this->db->prepare("DELETE FROM book WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
