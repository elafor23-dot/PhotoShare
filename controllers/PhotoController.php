<?php

class PhotoController
{
    private $photo;

    public function __construct($db)
    {
        $this->photo = new Photo($db);
    }

    public function upload() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /index.php/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $title = trim(isset($_POST['title']) ? $_POST['title'] : '');
        $description = trim(isset($_POST['description']) ? $_POST['description'] : '');

        if ($title === '' || !isset($_FILES['photo'])) {
            $error = 'Title and photo are required.';
            require __DIR__ . '/../views/photos/upload.php';
            return;
        }

        $file = $_FILES['photo'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $error = 'Photo upload failed.';
            require __DIR__ . '/../views/photos/upload.php';
            return;
        }

        if ($file['size'] > 5 * 1024 * 1024) {
            $error = 'Maximum file size is 5 MB.';
            require __DIR__ . '/../views/photos/upload.php';
            return;
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);

        $allowedTypes = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp'
        ];

        if (!isset($allowedTypes[$mimeType])) {
            $error = 'Only JPG, PNG, GIF and WEBP images are allowed.';
            require __DIR__ . '/../views/photos/upload.php';
            return;
        }

        $uploadDir = __DIR__ . '/../public/images/uploads/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = md5(uniqid(mt_rand(), true)) . '.' . $allowedTypes[$mimeType];
        $destination = $uploadDir . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            $error = 'Could not save the uploaded photo.';
            require __DIR__ . '/../views/photos/upload.php';
            return;
        }

        $this->photo->create(
            (int) $_SESSION['user_id'],
            $fileName,
            $title,
            $description,
            date('Y-m-d H:i:s')
        );

        header('Location: /index.php/photos');
        exit;
    }

    public function show($params) {
        $id = (int) (isset($params['id']) ? $params['id'] : 0);

        if ($id <= 0) {
            http_response_code(404);
            echo 'Photo not found';
            return;
        }

        $photo = $this->photo->getById($id);

        if (!$photo) {
            http_response_code(404);
            echo 'Photo not found';
            return;
        }

        require __DIR__ . '/../views/photos/show.php';
    }

    public function delete() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /index.php/login');
            exit;
        }

        $id = (int) (isset($_POST['id']) ? $_POST['id'] : 0);

        if ($id <= 0) {
            header('Location: /index.php/photos');
            exit;
        }

        $photo = $this->photo->getById($id);

        if (!$photo || (int) $photo['user_id'] !== (int) $_SESSION['user_id']) {
            header('Location: /index.php/photos');
            exit;
        }

        $filePath = __DIR__ . '/../public/images/uploads/' . basename($photo['file_name']);

        if (is_file($filePath)) {
            unlink($filePath);
        }

        $this->photo->delete($id, (int) $_SESSION['user_id']);

        header('Location: /index.php/photos');
        exit;
    }
}
