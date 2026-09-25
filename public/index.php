<?php

session_start();

require_once __DIR__ . '/../config/database.php';

require_once __DIR__ . '/../core/Model.php';
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Router.php';

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Photo.php';
require_once __DIR__ . '/../models/Comment.php';

require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/PhotoController.php';
require_once __DIR__ . '/../controllers/CommentController.php';

$router = new Router();

$authController = new AuthController($pdo);
$photoController = new PhotoController($pdo);
$commentController = new CommentController($pdo);

$photoModel = new Photo($pdo);
$commentModel = new Comment($pdo);

$router->get('/', function () use ($photoModel) {
    $photos = $photoModel->getAll();
    require __DIR__ . '/../views/home.php';
});

$router->get('/login', function () {
    require __DIR__ . '/../views/auth/login.php';
});

$router->post('/login', function () use ($authController) {
    $authController->login();
});

$router->get('/register', function () {
    require __DIR__ . '/../views/auth/register.php';
});

$router->post('/register', function () use ($authController) {
    $authController->register();
});

$router->get('/logout', function () use ($authController) {
    $authController->logout();
});

$router->get('/photos', function () use ($photoModel) {
    $photos = $photoModel->getAll();
    require __DIR__ . '/../views/photos/index.php';
});

$router->get('/upload', function () {
    require __DIR__ . '/../views/photos/upload.php';
});

$router->post('/upload', function () use ($photoController) {
    $photoController->upload();
});

$router->get('/photo/{id}', function ($params) use ($photoModel, $commentModel) {
    $id = (int) (isset($params['id']) ? $params['id'] : 0);

    $photo = $photoModel->getById($id);

    if (!$photo) {
        http_response_code(404);
        echo 'Photo not found';
        return;
    }

    $comments = $commentModel->getByPhoto($id);

    require __DIR__ . '/../views/photos/show.php';
});

$router->post('/comments', function () use ($commentController) {
    $commentController->add();
});

$router->post('/comment/delete', function () use ($commentController) {
    $commentController->delete();
});

$router->post('/delete', function () use ($photoController) {
    $photoController->delete();
});

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (!$path) {
    $path = '/';
}

$path = preg_replace('#^/index\.php#', '', $path);

$path = rtrim($path, '/');

if ($path === '') {
    $path = '/';
}

$router->dispatch($_SERVER['REQUEST_METHOD'], $path);
