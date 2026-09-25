<?php
$title = isset($photo['title']) ? $photo['title'] : 'Photo';
require __DIR__ . '/../layout/header.php';
if (!isset($comments)) { $comments = array(); }
?>

<?php if (!$photo): ?>
    <div class="alert alert-danger">Photo not found.</div>
<?php else: ?>

<div class="row">
    <div class="col-lg-8">
        <img
            src="/images/uploads/<?= htmlspecialchars($photo['file_name']) ?>"
            class="img-fluid rounded shadow"
            alt="<?= htmlspecialchars($photo['title']) ?>"
        >
    </div>

    <div class="col-lg-4">
        <h2><?= htmlspecialchars($photo['title']) ?></h2>

        <p>
            <strong>Author:</strong>
            <?= htmlspecialchars($photo['first_name'] . ' ' . $photo['last_name']) ?>
        </p>

        <p>
            <strong>Date:</strong>
            <?= htmlspecialchars($photo['date_time']) ?>
        </p>

        <?php if (!empty($photo['description'])): ?>
            <p><?= nl2br(htmlspecialchars($photo['description'])) ?></p>
        <?php endif; ?>

        <?php if (isset($_SESSION['user_id'])): ?>
            <form action="/index.php/delete" method="POST" class="mt-3">
                <input type="hidden" name="id" value="<?= (int) $photo['id'] ?>">
                <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this photo?')">Delete Photo</button>
            </form>
        <?php endif; ?>
    </div>
</div>

<hr class="my-4">

<h3>Comments</h3>

<?php foreach ($comments as $item): ?>
    <div class="border rounded p-3 mb-2">
        <strong>
            <?= htmlspecialchars($item['first_name'] . ' ' . $item['last_name']) ?>
        </strong>
        <small class="text-muted"><?= htmlspecialchars($item['date_time']) ?></small>
        <p class="mb-0 mt-2"><?= nl2br(htmlspecialchars($item['comment'])) ?></p>

        <?php if (isset($_SESSION['user_id']) && (int) $_SESSION['user_id'] === (int) $item['user_id']): ?>
            <form action="/index.php/comment/delete" method="POST" class="mt-2">
                        <input type="hidden" name="comment_id" value="<?= (int) $item['id'] ?>">
                <input type="hidden" name="photo_id" value="<?= (int) $photo['id'] ?>">
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this comment?')">Delete</button>
            </form>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

<?php if (isset($_SESSION['user_id'])): ?>
    <form action="/index.php/comments" method="POST" class="mt-4">
        <input type="hidden" name="photo_id" value="<?= (int) $photo['id'] ?>">

        <div class="mb-3">
            <label class="form-label">Write a comment</label>
            <textarea name="comment" class="form-control" rows="3" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Add Comment</button>
    </form>
<?php else: ?>
    <p class="text-muted">Please login to comment.</p>
<?php endif; ?>

<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>
