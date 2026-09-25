<?php
$title = 'Register';
require __DIR__ . '/../layout/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-7">
        <h2 class="mb-4">Create Account</h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="/index.php/register" method="POST" class="needs-validation" novalidate>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" required>
                    <div class="invalid-feedback">First name is required.</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" required>
                    <div class="invalid-feedback">Last name is required.</div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
                <div class="invalid-feedback">Enter a valid email.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" minlength="6" required>
                <div class="invalid-feedback">Password must be at least 6 characters.</div>
            </div>

            <button type="submit" class="btn btn-success">Register</button>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
