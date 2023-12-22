<section class="container mt-5">
    <h2 class="mb-4">Featured Books</h2>
    <div class="row">
      <?php 
      foreach ($books as $book):
        $userLoggedIn = isset($_SESSION['user_id']); 
      ?>
      <div class="col-md-4">
        <div class="card">
          <img src="../src/AlNU3WTK_400x400.jpg" class="card-img-top" alt="Book Cover">
            <div class="card-body">
                <h3 class="card-title"><?= htmlspecialchars($book['title']) ?></h3>
                <p class="card-text">Author: <?= htmlspecialchars($book['author']) ?></p>
                <p class="card-text">Year: <?= htmlspecialchars($book['publication_year']) ?></p>
                <p class="card-text">Genre: <?= htmlspecialchars($book['genre']) ?></p>
                <?php if ($userLoggedIn): ?>
                    <a href="addReservation.php?book_id=<?= $book['id'] ?>" class="btn btn-primary">Reserve</a>
                <?php else: ?>
                    <button class="btn btn-secondary" onclick="alert('Please login to reserve books');">Reserve</button>
                <?php endif; ?>
            </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </section>