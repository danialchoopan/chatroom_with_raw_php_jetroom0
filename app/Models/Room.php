<?php

namespace App\Models;

use App\Core\Model;

class Room extends Model {
    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM rooms ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM rooms WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
}
