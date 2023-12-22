<?php 
require_once __DIR__ . '/../vendor/autoload.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
use App\Controller\UserController;
use App\Controller\BookController;
use App\Controller\ReservationController;
if (!isset($_SESSION['is_logged_in']) && $_SESSION['user_role'] != 1) {
    header('Location: index.php'); 
    exit;
}
$userController = new UserController();
$userDatas=$userController->displayUsers(); 

$bookController = new BookController();
$bookDatas=$bookController->displayBooks();

$reservationModel = new ReservationController();
$reservations = $reservationModel->displayReservations();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Admin Dashboard</title>
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Admin Dashboard</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" href="#">Users</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Books</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-5">
    <!-- Users Section -->
    <div class="row mb-4">
      <div class="col-lg-12">
        <h2>Users</h2>
        <table class="table">
          <thead class="table-dark">
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Number</th>
              <th>Role</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($userDatas as $userData): ?>
                <tr>
                <?= '<td>' . htmlspecialchars($userData['id']) . '</td>';?>
                <?= '<td>' . htmlspecialchars($userData['fullname']) . '</td>';?>
                <?= '<td>' . htmlspecialchars($userData['email']) . '</td>';?>
                <?= '<td>' . htmlspecialchars($userData['phone']) . '</td>';?>
                <?= '<td>' . htmlspecialchars($userData['role_id']) . '</td>';?>
                <td>
                    <form action="editUser.php" method="post">
                        <input type="hidden" name="user_id" value="<?php echo $userData['id']; ?>">
                        <button class="btn btn-warning btn-sm" name="edit-user">Edit</button>
                    </form>
                    <form action="../app/controller/UserController.php" method="post">
                        <input type="hidden" name="user_id" value="<?php echo $userData['id']; ?>">
                        <button class="btn btn-danger btn-sm" name="delete-user">Delete</button>
                    </form>
                </td>
                </tr>
            <?php endforeach; ?>
            <!-- More rows... -->
          </tbody>
        </table>
      </div>
    </div>

    <!-- Books Section -->
    <div class="row">
      <div class="col-lg-12">
        <h2>Books</h2>
        <table class="table">
          <thead class="table-dark">
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Author</th>
              <th>Genre</th>
              <th>Description</th>
              <th>Publication Year</th>
              <th>Total Copies</th>
              <th>Available Copies</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($bookDatas as $bookData): ?>
            <tr>
                <?= '<td>' . htmlspecialchars($bookData['id']) . '</td>';?>
                <?= '<td>' . htmlspecialchars($bookData['title']) . '</td>';?>
                <?= '<td>' . htmlspecialchars($bookData['author']) . '</td>';?>
                <?= '<td>' . htmlspecialchars($bookData['genre']) . '</td>';?>
                <?= '<td>' . htmlspecialchars($bookData['description']) . '</td>';?>
                <?= '<td>' . htmlspecialchars($bookData['publication_year']) . '</td>';?>
                <?= '<td>' . htmlspecialchars($bookData['total_copies']) . '</td>';?>
                <?= '<td>' . htmlspecialchars($bookData['available_copies']) . '</td>';?>
                <td>
                    <form action="editBook.php" method="post">
                        <input type="hidden" name="user_id" value="<?php echo $bookData['id']; ?>">
                        <button class="btn btn-warning btn-sm" name="edit_book">Edit</button>
                    </form>
                    <form action="../app/controller/BookController.php" method="post">
                        <input type="hidden" name="user_id" value="<?php echo $bookData['id']; ?>">
                        <button class="btn btn-danger btn-sm" name="delete_book">Delete</button>
                    </form>
                </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
    </div>

        <!-- Book Returns Management Section -->
    <div class="container mt-5">
        <h2 class="mb-4">Manage Book Returns</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Reservation ID</th>
                    <th>User ID</th>
                    <th>Book ID</th>
                    <th>Reservation Date</th>
                    <th>Return Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation): ?>
                    <tr>
                        <td><?= htmlspecialchars($reservation['id']) ?></td>
                        <td><?= htmlspecialchars($reservation['user_id']) ?></td>
                        <td><?= htmlspecialchars($reservation['book_id']) ?></td>
                        <td><?= htmlspecialchars($reservation['reservation_date']) ?></td>
                        <td><?= htmlspecialchars($reservation['return_date']) ?></td>
                        <td>
                            <form action='ReservationController.php' method='post'>
                                <input type='hidden' name='reservation_id' value='<?= $reservation['id'] ?>'>
                                <button type='submit' name='return_book' class='btn btn-primary'>Return Book</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
