  <?php if (!empty($_SESSION['errors'])): ?>
    <div class="alert alert-danger">
      <ul class="mb-0">
        <?php foreach ($_SESSION['errors'] as $error): ?>
          <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach;
        unset($_SESSION['errors']);
        ?>


      </ul>
    </div>
  <?php endif; ?>