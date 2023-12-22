<?php
namespace App\Controller;
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Model\Book;
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class BookController {
    private $bookModel;

    public function __construct() {
        $this->bookModel = new Book();
    }

    public function addNewBook($formData) {

        $title = $formData['title'];
        $author = $formData['author'];
        $genre = $formData['genre'];
        $description = $formData['description'];
        $publication_year = $formData['publication_year'];
        $total_copies = $formData['total_copies'];
        $available_copies = $formData['available_copies'];


        if ($this->bookModel->addBook($title, $author, $genre, $description, $publication_year, $total_copies, $available_copies)) {
            $_SESSION['success'] = "New book added successfully";
            header('Location: ../../view/dashboard.php');
        } else {
            $_SESSION['error'] = "There was a problem adding the book";
            header('Location: ../../view/addBook.php');
        }
        
    }

    public function displayBooks() {
        $users = $this->bookModel->getAllBooks();
        return $users;
    }

    public function updateBookDetails($formData) {
        $id = $formData['book_id'];
        $title = $formData['title'];
        $author = $formData['author'];
        $genre = $formData['genre'];
        $description = $formData['description'];
        $publication_year = $formData['publication_year'];
        $total_copies = $formData['total_copies'];
        $available_copies = $formData['available_copies'];
        

        if ($this->bookModel->updateBook($id, $title, $author, $genre, $description, $publication_year, $total_copies, $available_copies)) {
            $_SESSION['success'] = "Book updated successfully";
            echo '<pre>';
            var_dump($formData);
            echo '</pre>';
            header('Location: ../../view/dashboard.php');
        } else {
            echo "There was a problem updating the book";
        }
        exit;
    }

    public function getBookDetails($userId) {
        return $this->bookModel->getBookById($userId);
    }

    public function deleteBook($id) {
        if ($this->bookModel->deleteBook($id)) {
            $_SESSION['success'] = "Book deleted successfully";
            header('Location: ../../view/dashboard.php');
        } else {
            echo "There was a problem deleting the book";
        }
        exit;
    }


}


$bookController = new BookController();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_book'])) {
    $bookController->addNewBook($_POST);
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_book'])) {
    $bookController->updateBookDetails($_POST);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_book'])) {
    $bookController->deleteBook($_POST['user_id']);
}




