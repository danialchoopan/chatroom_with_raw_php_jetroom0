<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\Message;
use App\Models\Room;

class AdminController extends Controller {
    private $userModel;
    private $messageModel;
    private $roomModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /login');
            exit;
        }

        $this->userModel = new User();
        $this->messageModel = new Message();
        $this->roomModel = new Room();
    }

    public function index() {
        $users = $this->userModel->getAllUsers();
        return $this->view('admin/dashboard', ['users' => $users]);
    }

    public function rooms() {
        $rooms = $this->roomModel->getAll();
        return $this->view('admin/rooms', ['rooms' => $rooms]);
    }

    public function addRoom() {
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $slug = $_POST['slug'] ?? '';

        if ($name && $slug) {
            $this->roomModel->create($name, $description, $slug);
        }
        header('Location: /admin/rooms');
    }

    public function editRoom() {
        $id = $_POST['id'] ?? null;
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $slug = $_POST['slug'] ?? '';

        if ($id && $name && $slug) {
            $this->roomModel->update($id, $name, $description, $slug);
        }
        header('Location: /admin/rooms');
    }

    public function deleteRoom() {
        $id = $_POST['id'] ?? null;
        if ($id) {
            $this->roomModel->delete($id);
        }
        header('Location: /admin/rooms');
    }

    public function toggleBlock() {
        $userId = $_POST['user_id'] ?? null;
        if ($userId) {
            $this->userModel->toggleBlock($userId);
        }
        header('Location: /admin');
    }

    public function deleteUser() {
        $userId = $_POST['user_id'] ?? null;
        if ($userId) {
            $this->userModel->delete($userId);
        }
        header('Location: /admin');
    }

    public function deleteMessage() {
        $messageId = $_POST['message_id'] ?? null;
        if ($messageId) {
            $this->messageModel->delete($messageId);
            return $this->json(['success' => true]);
        }
        return $this->json(['success' => false], 400);
    }
}
