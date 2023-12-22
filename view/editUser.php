<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\UserController;

$userController = new UserController();

if (isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];
    $userDetails = $userController->getUserDetails($userId);
}

?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <title>Edit User</title>
</head>
<body>
<div class="container mt-5">
    <h2>Edit User</h2>
    <?php if (isset($userDetails)): ?>
    <form action="../app/controller/UserController.php" method="post">
        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($userDetails['id']); ?>">
        
        <div class="mb-3">
            <label for="fullname" class="form-label">Full Name:</label>
            <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlspecialchars($userDetails['fullname']); ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($userDetails['email']); ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="phone" class="form-label">Phone:</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($userDetails['phone']); ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="role" class="form-label">Role:</label>
            <select class="form-select" id="role" name="role">
                <option value="2">User</option>
                <option value="1">Admin</option>
            </select>
        </div>
        
        <button type="submit" name="update_user" class="btn btn-primary">Update User</button>
    </form>
    <?php else: ?>
    <p>User details not found.</p>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
