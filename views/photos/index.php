<?php
$title = 'Photos';
require __DIR__ . '/../layout/header.php';
if (!isset($photos)) { $photos = array(); }
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
?>

<h2 class="mb-4">All Photos</h2>

<?php if (empty($photos)): ?>
    <div class="alert alert-info">No photos available yet.</div>
<?php else: ?>
    <div class="row g-4">
        <?php foreach ($photos as $photo): ?>
            <div class="col-sm-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <img
                        src="/images/uploads/<?= htmlspecialchars($photo['file_name']) ?>"
                        class="card-img-top"
                        style="height:240px;object-fit:cover"
                        alt="<?= htmlspecialchars($photo['title']) ?>"
                    >

                    <div class="card-body">
                        <h5><?= htmlspecialchars($photo['title']) ?></h5>
                        <p class="text-muted">
                            By <?= htmlspecialchars($photo['first_name'] . ' ' . $photo['last_name']) ?>
                        </p>

                        <a href="/index.php/photo/<?= (int) $photo['id'] ?>" class="btn btn-primary">
                            Details
                        </a>

                        <?php if ($userId && (int) $photo['user_id'] === (int) $userId): ?>
                            <form action="/index.php/delete" method="POST" class="d-inline">
                                <input type="hidden" name="id" value="<?= (int) $photo['id'] ?>">
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Delete this photo?')">
                                    Delete
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>
