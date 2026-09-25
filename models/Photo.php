<?php

class Photo extends Model
{
    public function create(
        $userId,
        $fileName,
        $title,
        $description,
        $dateTime
    ) {
        $stmt = $this->db->prepare(
            'INSERT INTO photos
            (user_id, file_name, title, description, date_time)
            VALUES (:user_id, :file_name, :title, :description, :date_time)'
        );

        return $stmt->execute([
            'user_id' => $userId,
            'file_name' => $fileName,
            'title' => $title,
            'description' => $description,
            'date_time' => $dateTime
        ]);
    }

    public function getAll() {
        $stmt = $this->db->query(
            'SELECT photos.*, users.first_name, users.last_name
             FROM photos
             INNER JOIN users ON users.id = photos.user_id
             ORDER BY photos.date_time DESC'
        );

        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare(
            'SELECT photos.*, users.first_name, users.last_name
             FROM photos
             INNER JOIN users ON users.id = photos.user_id
             WHERE photos.id = :id
             LIMIT 1'
        );

        $stmt->execute(['id' => $id]);

        $photo = $stmt->fetch();

        return $photo ?: null;
    }

    public function getByUser($userId) {
        $stmt = $this->db->prepare(
            'SELECT * FROM photos
             WHERE user_id = :user_id
             ORDER BY date_time DESC'
        );

        $stmt->execute(['user_id' => $userId]);

        return $stmt->fetchAll();
    }

    public function delete($id, $userId) {
        $stmt = $this->db->prepare(
            'DELETE FROM photos
             WHERE id = :id AND user_id = :user_id'
        );

        return $stmt->execute([
            'id' => $id,
            'user_id' => $userId
        ]);
    }
}
