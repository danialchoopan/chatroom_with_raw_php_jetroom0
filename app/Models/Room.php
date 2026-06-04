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

    public function create($name, $description, $slug) {
        $stmt = $this->db->prepare("INSERT INTO rooms (name, description, slug) VALUES (:name, :description, :slug)");
        return $stmt->execute([
            'name' => $name,
            'description' => $description,
            'slug' => $slug
        ]);
    }

    public function update($id, $name, $description, $slug) {
        $stmt = $this->db->prepare("UPDATE rooms SET name = :name, description = :description, slug = :slug WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'name' => $name,
            'description' => $description,
            'slug' => $slug
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM rooms WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
