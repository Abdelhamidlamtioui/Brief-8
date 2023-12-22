
<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="signupModalLabel">Sign Up</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <?php if (isset($_SESSION['errors'])): ?>
              <div class="alert alert-danger" role="alert">
                    <?php echo $_SESSION['errors']; ?>
              </div>
          <?php endif; ?>
          <!-- Signup form -->
          <form action="../app/controller/UserController.php" method="post">
            <!-- Form content -->
            <div class="mb-3">
              <label for="fullname" class="form-label">Full name</label>
              <input type="text" name="fullname" class="form-control" id="fullname" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" name="email" class="form-control" id="email" required>
            </div>
            <div class="mb-3">
              <label for="Number" class="form-label">Number</label>
              <input type="number" name="number" class="form-control" id="Number" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" name="password" class="form-control" id="password" required>
            </div>
            <!-- Other signup fields -->
            <button type="submit" name="sign-up" class="btn btn-primary">Sign Up</button>
          </form>
        </div>
      </div>
    </div>
  </div>