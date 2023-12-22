
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="loginModalLabel">Login</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <?php if (isset($_SESSION['success'])): ?>
              <div class="alert alert-success" role="alert">
                  <?php echo htmlspecialchars($_SESSION['success']); ?>
              </div>
          <?php endif; ?>
          <form action="../app/controller/UserController.php" method="post">
            <div class="mb-3">
              <label for="email" class="form-label">Email address</label>
              <input type="email" name="login-email" class="form-control" id="login-email" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" name="login-password" class="form-control" id="login-password" required>
            </div>
            <button type="submit" name="log-in" class="btn btn-primary">Login</button>
          </form>
        </div>
      </div>
    </div>
  </div>