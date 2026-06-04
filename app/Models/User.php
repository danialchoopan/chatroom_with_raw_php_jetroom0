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

    public function create($username, $password, $role = 'user') {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
        return $stmt->execute([
            'username' => $username,
            'password' => $hashedPassword,
            'role' => $role
        ]);
    }

    public function verify($username, $password) {
        $user = $this->findByUsername($username);
        if ($user && password_verify($password, $user['password'])) {
            if ($user['is_blocked']) {
                return 'blocked';
            }
            return $user;
        }
        return false;
    }

    public function getOnlineUsers($currentUserId = null) {
        $sql = "SELECT id, username, role, is_blocked FROM users";
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

    public function getAllUsers() {
        $stmt = $this->db->query("SELECT * FROM users ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function toggleBlock($id) {
        $stmt = $this->db->prepare("UPDATE users SET is_blocked = 1 - is_blocked WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
