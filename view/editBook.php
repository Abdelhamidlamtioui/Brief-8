<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\BookController;

    $bookController = new BookController();
    $userId = $_POST['user_id'];
    $bookDetails = $bookController->getBookDetails($userId);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Book Details</h2>
        <form action="../app/controller/BookController.php" method="post">
            <input type="hidden" name="book_id" value="<?php echo $bookDetails['id']; ?>">

            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $bookDetails['title']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="author" class="form-label">Author:</label>
                <input type="text" class="form-control" id="author" name="author" value="<?php echo $bookDetails['author']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="genre" class="form-label">Genre:</label>
                <input type="text" class="form-control" id="genre" name="genre" value="<?php echo $bookDetails['genre']; ?>">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <input type="text" class="form-control" id="description" name="description" value="<?php echo $bookDetails['description']; ?>">
            </div>

            <div class="mb-3">
                <label for="publicationYear" class="form-label">Publication Year:</label>
                <input type="number" class="form-control" id="publicationYear" name="publication_year" value="<?php echo $bookDetails['publication_year']; ?>">
            </div>

            <div class="mb-3">
                <label for="total_copies" class="form-label">Total copies:</label>
                <input type="number" class="form-control" id="total_copies" name="total_copies" value="<?php echo $bookDetails['total_copies']; ?>">
            </div>

            <div class="mb-3">
                <label for="copiesAvailable" class="form-label">Copies Available:</label>
                <input type="number" class="form-control" id="copiesAvailable" name="available_copies" value="<?php echo $bookDetails['available_copies']; ?>">
            </div>

            <button type="submit" name="update_book" class="btn btn-primary">Update Book</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
