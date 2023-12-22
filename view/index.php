<?php require_once __DIR__ . '/../vendor/autoload.php'; 
use App\Controller\BookController;
$bookController = new BookController();
$books = $bookController->displayBooks();
$userLoggedIn = isset($_SESSION['user_id']);
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <title>Book Reservation</title>
</head>
<body>


  <!-- Navigation Bar -->
  <?php include "../include/navbar.php" ?>

  <!-- Featured Books Section -->
  <?php include "../include/books_Section.php" ?>

  <!-- Reservation Form -->
  <?php include "../include/reservation_Form.php" ?>

  <!-- Login Modal -->
  <?php require "../include/login_Modal.php" ?>

  <!-- Signup Modal -->
  <?php require "../include/signup_Modal.php" ?>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <?php if (!empty($_SESSION['errors'])): ?>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Show signupModal if there are errors
        var errorModal = new bootstrap.Modal(document.getElementById('signupModal'));
        errorModal.show();
      });
    </script>
    <?php unset($_SESSION['errors']); ?>
  <?php elseif (!empty($_SESSION['success'])): ?>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Show signupModal on success - change if different behavior is needed
        var successModal = new bootstrap.Modal(document.getElementById('loginModal'));
        successModal.show();
      });
    </script>
    <?php unset($_SESSION['success']); ?>
  <?php endif; ?>
</body>
</html>
