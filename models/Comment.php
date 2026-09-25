<?php

class Comment extends Model
{
    public function create($photoId, $userId, $comment) {
        $stmt = $this->db->prepare(
            'INSERT INTO comments (photo_id, user_id, comment, date_time)
             VALUES (:photo_id, :user_id, :comment, NOW())'
        );

        return $stmt->execute([
            'photo_id' => $photoId,
            'user_id' => $userId,
            'comment' => $comment
        ]);
    }

    public function delete($commentId, $userId) {
        $stmt = $this->db->prepare(
            'DELETE FROM comments
             WHERE id = :id AND user_id = :user_id'
        );

        return $stmt->execute([
            'id' => $commentId,
            'user_id' => $userId
        ]);
    }

    public function getByPhoto($photoId) {
        $stmt = $this->db->prepare(
            'SELECT comments.*, users.first_name, users.last_name
             FROM comments
             INNER JOIN users ON users.id = comments.user_id
             WHERE comments.photo_id = :photo_id
             ORDER BY comments.date_time ASC'
        );

        $stmt->execute(['photo_id' => $photoId]);

        return $stmt->fetchAll();
    }
}
