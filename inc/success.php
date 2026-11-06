 <?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <ul class="mb-0">
            <?php foreach ($_SESSION['success'] as $success): ?>
                <li><?= htmlspecialchars($success) ?></li>
            <?php endforeach; 
            unset($_SESSION['success']);
            ?>


        </ul>
    </div>
<?php endif; ?>