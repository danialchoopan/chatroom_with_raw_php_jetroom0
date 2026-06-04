<?php

namespace App\Models;

use App\Core\Model;

class Message extends Model {
    public function getByRoomId($roomId, $limit = 50) {
        $stmt = $this->db->prepare("
            SELECT * FROM (
                SELECT m.*, u.username, u.role as user_role
                FROM messages m
                JOIN users u ON m.user_id = u.id
                WHERE m.room_id = :room_id
                ORDER BY m.created_at DESC
                LIMIT :limit
            ) AS sub ORDER BY created_at ASC
        ");
        $stmt->bindValue(':room_id', $roomId, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create($userId, $roomId, $message, $imagePath = null) {
        $stmt = $this->db->prepare("
            INSERT INTO messages (user_id, room_id, message, image_path)
            VALUES (:user_id, :room_id, :message, :image_path)
        ");
        return $stmt->execute([
            'user_id' => $userId,
            'room_id' => $roomId,
            'message' => $message,
            'image_path' => $imagePath
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM messages WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
