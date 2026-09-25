<?php
$title = 'Upload Photo';
require __DIR__ . '/../layout/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-7">
        <h2 class="mb-4">Upload Photo</h2>

        <?php if (!isset($_SESSION['user_id'])): ?>
            <div class="alert alert-warning">
                Please login before uploading a photo.
            </div>
        <?php else: ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="/index.php/upload" method="POST" enctype="multipart/form-data"
              class="needs-validation" novalidate>

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" required maxlength="150">
                <div class="invalid-feedback">Title is required.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Photo</label>
                <input type="file" name="photo" class="form-control"
                       accept="image/jpeg,image/png,image/gif,image/webp" required>
                <div class="invalid-feedback">Please select an image.</div>
            </div>

            <button type="submit" class="btn btn-success">Upload</button>
        </form>

        <?php endif; ?>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
