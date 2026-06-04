<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class User extends Model {
    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch();
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create($username, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        return $stmt->execute([
            'username' => $username,
            'password' => $hashedPassword
        ]);
    }

    public function verify($username, $password) {
        $user = $this->findByUsername($username);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function getOnlineUsers($currentUserId = null) {
        // Since we don't have a real-time online status in DB,
        // we return all users. For a production system, we'd check a 'last_activity' timestamp.
        $sql = "SELECT id, username FROM users";
        $params = [];
        if ($currentUserId) {
            $sql .= " WHERE id != :id";
            $params = ['id' => $currentUserId];
        }
        $sql .= " ORDER BY username ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
