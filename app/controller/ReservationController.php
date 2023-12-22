<?php
namespace App\Controller;
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Model\Reservation;
use DateInterval;
use DateTime;

class ReservationController {
    private $reservationModel;

    public function __construct() {
        $this->reservationModel = new Reservation();
    }

    public function handleReservation($userId, $bookId, $reservationDate) {
        $currentDate = date('Y-m-d');
        if ($reservationDate < $currentDate) {
            return false; 
        }

        $returnDate = date('Y-m-d', strtotime($reservationDate . ' + 15 days'));

        if ($this->reservationModel->checkAvailability($bookId)) {
            $result = $this->reservationModel->createReservation($userId, $bookId, $reservationDate, $returnDate);
            if ($result) {
                $this->reservationModel->updateAvailableCopies($bookId, -1); 
            }
            return $result;
        } else {
            return false;
        }
    }

    public function completeReservation($reservationId) {

        $reservation = $this->reservationModel->getReservationById($reservationId);
        if (!$reservation) {
            return false; 
        }


        if ($reservation['is_returned']) {
            return false;
        }
        $this->reservationModel->markAsReturned($reservationId);

        $this->reservationModel->updateAvailableCopies($reservation['book_id'], 1); =
        return true;
    }

    public function handleReturn($reservationId) {
        return $this->reservationModel->returnBook($reservationId);
    }

    public function displayReservations() {
        echo "test";
        $reservations = $this->reservationModel->getAllReservations();
        return $reservations;
    }
    
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_reservation'])) {
    $userId = $_POST['user_id']; 
    $bookId = $_POST['book_id']; 
    $reservationDate = $_POST['reservation_date']; 
    $returnDate = $_POST['return_date'];

    $reservationController = new ReservationController();
    $result = $reservationController->handleReservation($userId, $bookId, $reservationDate, $returnDate);

        if ($result) {
            $_SESSION['success_message'] = "Reservation successful.";
            echo "Reservation successful.";
        } else {
            $_SESSION['error_message'] = "Unable to reserve the book.";
            echo "Unable to reserve the book.";
        }
    } else {
        $_SESSION['error_message'] = "Please log in to make a reservation.";
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['return_book'])) {
        $reservationId = $_POST['reservation_id'];
        $result = $this->returnBook($reservationId);
    
        if ($result) {
            $_SESSION['success'] = "Book returned successfully.";
        } else {
            $_SESSION['error'] = "Failed to return the book.";
        }
        header('Location: .../../view/dashboard.php');
        exit;
    }

?>
