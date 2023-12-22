<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header('Location: login_Modal.php'); 
    exit;
}

require_once __DIR__ . '/../app/controller/BookController.php';

$bookId = $_GET['book_id'] ?? null;

$bookController = new App\Controller\BookController();
$bookDetails = $bookController->getBookDetails($bookId);

if (!$bookDetails) {
    echo "Book not found."; 
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserve a Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Reserve a Book</h2>
        <div class="card mb-3">
            <div class="card-body">
                <h3 class='card-title'><?php echo htmlspecialchars($bookDetails['title']); ?></h5>
                <p class='card-text'>Author: <?php echo htmlspecialchars($bookDetails['author']); ?></p>
                <p class='card-text'>Genre: <?php echo htmlspecialchars($bookDetails['genre']); ?></p>
                <p class='card-text'>Description: <?php echo htmlspecialchars($bookDetails['description']); ?></p>
                <p class='card-text'>Available Copies: <?php echo htmlspecialchars($bookDetails['available_copies']); ?></p>
            </div>
        </div>

        <form action="../app/controller/ReservationController.php" method="post">
            <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
            <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
            
            <div class="mb-3">
                <label for="reservationDate" class="form-label">Reservation Date:</label>
                <input type="date" class="form-control" id="reservationDate" name="reservation_date" required>
            </div>
            <div class="mb-3">
                <label for="returnDate" class="form-label">Return Date:</label>
                <input type="date" class="form-control" id="returnDate" name="return_date" required>
            </div>
            <button type="submit" name="add_reservation" class="btn btn-primary">Reserve Book</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.getElementById("reservationForm").addEventListener("submit", function(event) {
        var reservationDate = document.getElementById("reservationDate").value;
        var currentDate = new Date().toISOString().split('T')[0];

        if (reservationDate < currentDate) {
            alert("Reservation date cannot be in the past.");
            event.preventDefault();
            return false;
        }

        var maxDate = new Date(reservationDate);
        maxDate.setDate(maxDate.getDate() + 15);
        var maxDateStr = maxDate.toISOString().split('T')[0];

        if (document.getElementById("returnDate").value > maxDateStr) {
            alert("Reservation cannot exceed 15 days.");
            event.preventDefault();
            return false;
        }
    });
</script>

</body>
</html>
