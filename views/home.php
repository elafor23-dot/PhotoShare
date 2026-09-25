<?php
$title = 'Home';
require __DIR__ . '/layout/header.php';
if (!isset($photos)) { $photos = array(); }
?>

<div class="p-5 mb-4 bg-light rounded-3">
    <div class="container-fluid py-4">
        <h1 class="display-5 fw-bold">Welcome to PhotoShare</h1>
        <p class="lead">Share your photos and discover photos from other users.</p>
        <a href="/index.php/photos" class="btn btn-primary">View Photos</a>
    </div>
</div>

<section class="mb-5">
    <h2>About Us</h2>
    <p>
        PhotoShare is a simple photo sharing application where users can
        upload, view, and comment on photos.
    </p>
</section>

<section>
    <h2 class="mb-3">Latest Photos</h2>

    <?php if (empty($photos)): ?>
        <div class="alert alert-info">No photos available yet.</div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($photos as $photo): ?>
                <div class="col-md-4">
                    <div class="card h-100">
                        <img
                            src="/images/uploads/<?= htmlspecialchars($photo['file_name']) ?>"
                            class="card-img-top"
                            style="height:220px;object-fit:cover"
                            alt="<?= htmlspecialchars($photo['title']) ?>"
                        >
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($photo['title']) ?></h5>
                            <p class="card-text">
                                By <?= htmlspecialchars($photo['first_name'] . ' ' . $photo['last_name']) ?>
                            </p>
                            <a href="/index.php/photo/<?= (int) $photo['id'] ?>" class="btn btn-outline-primary">
                                View
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php require __DIR__ . '/layout/footer.php'; ?>
