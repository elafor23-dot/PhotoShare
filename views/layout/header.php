<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(isset($title) ? $title : 'PhotoShare') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="/">PhotoShare</a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="/">Home</a>
            <a class="nav-link" href="/index.php/photos">Photos</a>

            <?php if (isset($_SESSION['user_id'])): ?>
                <a class="nav-link" href="/index.php/upload">Upload</a>
                <a class="nav-link" href="/index.php/logout">Logout</a>
            <?php else: ?>
                <a class="nav-link" href="/index.php/login">Login</a>
                <a class="nav-link" href="/index.php/register">Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<main class="container py-4">
