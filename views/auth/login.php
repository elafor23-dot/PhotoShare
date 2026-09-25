<?php
$title = 'Login';
require __DIR__ . '/../layout/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <h2 class="mb-4">Login</h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="/index.php/login" method="POST" class="needs-validation" novalidate>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
                <div class="invalid-feedback">Please enter your email.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
                <div class="invalid-feedback">Please enter your password.</div>
            </div>

            <?php if (!empty($_COOKIE['last_login'])): ?>
                <p class="text-muted">
                    Last login: <?= htmlspecialchars($_COOKIE['last_login']) ?>
                </p>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
