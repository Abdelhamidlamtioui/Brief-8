<?php $isLoggedIn = isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'];
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <!-- Replace with your logo image -->
        <img src="../src/AlNU3WTK_400x400.jpg" alt="Logo" width="30" height="24">
        BookReserve
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <?php if (!$isLoggedIn): ?>
            <li class="nav-item">
              <a class="nav-link" href="#loginModal" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#signupModal" data-bs-toggle="modal" data-bs-target="#signupModal">Sign Up</a>
            </li>
          <?php else : ?>
            <li class="nav-item">
              <form action="../app/controller/UserController.php" method="post" style="display: inline-block;">
                <button type="submit" name="logout" class="btn btn-warning">Logout</button>
              </form>
            </li>
          <?php endif ; ?>
        </ul>
      </div>
    </div>
  </nav>