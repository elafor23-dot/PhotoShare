<?php

class CommentController
{
    private $comment;

    public function __construct($db)
    {
        $this->comment = new Comment($db);
    }

    public function delete() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /index.php/login');
            exit;
        }

        $commentId = (int) (isset($_POST['comment_id']) ? $_POST['comment_id'] : 0);
        $photoId = (int) (isset($_POST['photo_id']) ? $_POST['photo_id'] : 0);

        if ($commentId > 0) {
            $this->comment->delete($commentId, (int) $_SESSION['user_id']);
        }

        if ($photoId > 0) {
            header('Location: /index.php/photo/' . $photoId);
        } else {
            header('Location: /index.php/photos');
        }
        exit;
    }

    public function add() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /index.php/login');
            exit;
        }

        $photoId = (int) (isset($_POST['photo_id']) ? $_POST['photo_id'] : 0);
        $text = trim(isset($_POST['comment']) ? $_POST['comment'] : '');

        if ($photoId <= 0 || $text === '') {
            header('Location: /index.php/photos');
            exit;
        }

        $this->comment->create($photoId, (int) $_SESSION['user_id'], $text);

        header('Location: /index.php/photo/' . $photoId);
        exit;
    }
}
