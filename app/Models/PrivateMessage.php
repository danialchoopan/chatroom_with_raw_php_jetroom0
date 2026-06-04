<?php

namespace App\Models;

use App\Core\Model;

class PrivateMessage extends Model {
    public function getChatHistory($user1, $user2, $limit = 50) {
        $stmt = $this->db->prepare("
            SELECT * FROM (
                SELECT pm.*, u.username as sender_name
                FROM private_messages pm
                JOIN users u ON pm.sender_id = u.id
                WHERE (sender_id = :u1 AND receiver_id = :u2)
                   OR (sender_id = :u2 AND receiver_id = :u1)
                ORDER BY pm.created_at DESC
                LIMIT :limit
            ) AS sub ORDER BY created_at ASC
        ");
        $stmt->bindValue(':u1', $user1, \PDO::PARAM_INT);
        $stmt->bindValue(':u2', $user2, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create($senderId, $receiverId, $message, $imagePath = null) {
        $stmt = $this->db->prepare("
            INSERT INTO private_messages (sender_id, receiver_id, message, image_path)
            VALUES (:sender_id, :receiver_id, :message, :image_path)
        ");
        return $stmt->execute([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'message' => $message,
            'image_path' => $imagePath
        ]);
    }

    public function getActiveChats($userId) {
        // Find users who have exchanged messages with current user
        $stmt = $this->db->prepare("
            SELECT DISTINCT u.id, u.username
            FROM users u
            JOIN private_messages pm ON (u.id = pm.sender_id OR u.id = pm.receiver_id)
            WHERE (pm.sender_id = :user_id OR pm.receiver_id = :user_id)
            AND u.id != :user_id
        ");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }
}
